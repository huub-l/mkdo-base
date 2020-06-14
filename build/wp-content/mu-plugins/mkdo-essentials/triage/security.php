<?php
/**
 * Limit Login Attempts
 *
 * Prevent Mass WordPress Login Attacks by setting locking the system when login
 * fails.
 */

/**
 * Limit Login Attempts
 *
 * Prevent Mass WordPress Login Attacks by setting locking the system when
 * login fails.
 *
 * @see http://stackoverflow.com/questions/20498556/wordpress-limit-login-attempt-plugin-in-custom-login-form
 */
class MKDO_Limit_Login_Attempts {

	/**
	 * The ammount of login attempts allowed.
	 *
	 * @var     int
	 * @access  private
	 * @since 1.0.0
	 */
	private $failed_login_limit;

	/**
	 * The ammount of time a user should be locked out for.
	 *
	 * @var     int
	 * @access  private
	 * @since 1.0.0
	 */
	private $lockout_duration;

	/**
	 * The name of the transient the login attempt will be stored in.
	 *
	 * @var     string
	 * @access  private
	 * @since 1.0.0
	 */
	private $transient_name;

	/**
	 * Whether the lockout is global or not.
	 *
	 * @var     boolean
	 * @access  private
	 * @since 1.0.0
	 */
	private $is_lockout_global;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->failed_login_limit = 3; // Number of authentification accepted.
		$this->lockout_duration   = 1800; // Stop authentification process for 30 minutes: 60*30 = 1800.
		$this->transient_name     = 'mkdo_attempted_login'; // Transient used.
		$this->is_lockout_global  = false; // Is the lockout global or specific to each user?
	}

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( 'mkdo_core_limit_login_attempts', true );

		if ( ! $do_run ) {
			return;
		}

		add_filter( 'authenticate', array( $this, 'check_attempted_login' ), 30, 3 );
		add_action( 'wp_login_failed', array( $this, 'login_failed' ), 10, 1 );
		add_action( 'template_redirect', array( $this, 'mkdo_block_user_enumeration_attempts' ) );
	}

	/**
	 * Lock login attempts of failed login limit is reached
	 *
	 * @param  object $user     The User Object.
	 * @param  string $username The Username.
	 * @param  string $password The Password.
	 * @return object           The User Object.
	 */
	public function check_attempted_login( $user, $username, $password ) {

		$pass = $password; // Silences WPCS!

		if ( $this->is_lockout_global ) {
			$this->transient_name = 'mkdo_core_attempted_login';
		} else {
			$this->transient_name = 'mkdo_core_attempted_login_' . $username;
		}

		if ( get_transient( $this->transient_name ) ) {

			$datas = get_transient( $this->transient_name );

			if ( $datas['tried'] >= $this->failed_login_limit ) {

				$until = get_option( '_transient_timeout_' . $this->transient_name );

				$time  = $this->when( $until );

				$user = new WP_Error(
					'authentication_failed',
					sprintf(
						/* translators: 1: opening <strong> tag 2: closing <strong> tag 3: time until login permitted */
					esc_html__( '%1$sWARNING%2$s: You have attempted to login incorrectly too many times. You will be able to try again in %3$s.', 'mkdo-core' ),
						'<strong>',
						'</strong>',
						esc_html( $time )
						)
					);
			}
		}

		return $user;
	}

	/**
	 * Block User Enumeration
	 */
	public function mkdo_block_user_enumeration_attempts() {

		if ( is_admin() ) {
			return;
		}

		$author_by_id = ( isset( $_REQUEST['author'] ) && is_numeric( $_REQUEST['author'] ) ); // @codingStandardsIgnoreLine

		if ( $author_by_id ) {
			wp_die( 'Author archives have been disabled.' );
		}
	}

	/**
	 * Add transient
	 *
	 * @param  string $username The Username.
	 */
	public function login_failed( $username ) {

		$un = $username; // Silences WPCS!

		if ( get_transient( $this->transient_name ) ) {
			$datas = get_transient( $this->transient_name );
			$datas['tried']++;

			set_transient( $this->transient_name, $datas, $this->lockout_duration );

			if ( $datas['tried'] >= $this->failed_login_limit ) {
				$expiration = time() + $this->lockout_duration;
				update_option( '_transient_timeout_' . $this->transient_name, $expiration );
			}
		} else {
			$datas = array(
				'tried' => 1,
			);
			set_transient( $this->transient_name, $datas, $this->lockout_duration );
		}
	}

	/**
	 * Return difference between 2 given dates
	 *
	 * <a href="/param">@param</a>  int      $time   Date as Unix timestamp
	 *
	 * @param  string $time Datetime.
	 * @return string       Return string
	 */
	private function when( $time ) {

		if ( ! $time ) {
			return;
		}

		$right_now = time();

		$diff = abs( $right_now - $time );

		$second = 1;
		$minute = $second * 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;

		if ( $diff < $minute ) {
			return floor( $diff / $second ) . ' seconds';
		}

		if ( $diff < $minute * 2 ) {
			return 'about 1 minute ago';
		}

		if ( $diff < $hour ) {
			return floor( $diff / $minute ) . ' minutes';
		}

		if ( $diff < $hour * 2 ) {
			return 'about 1 hour';
		}

		return floor( $diff / $hour ) . ' hours';
	}
}

$limit_login = new MKDO_Limit_Login_Attempts();

$limit_login->run();

<?php
/**
 * Login One User Instance
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Only allow one instance of a user to be logged in at any one time.
 */
class Login_One_User_Instance {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_limit_login_instances', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'setup_theme', array( $this, 'mkdo_core_login_one_user_instance' ), 0 );
	}

	/**
	 * Only allow one user to be logged on at a time.
	 */
	public function mkdo_core_login_one_user_instance() {
		global $mkdo_core_sessions;

		// Only allow one user to be logged in at a time.
		$mkdo_core_sessions = \WP_Session_Tokens::get_instance( get_current_user_id() );
		$mkdo_core_sessions->destroy_others( wp_get_session_token() );
	}
}
