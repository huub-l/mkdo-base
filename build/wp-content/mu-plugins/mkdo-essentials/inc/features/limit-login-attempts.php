<?php
/**
 * Limit Login Attempts.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Limit_Login_Attempts;

use const MKDO\Essentials\PREFIX;

/**
 * Abort if a key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

const FAILED_LOGIN_LIMIT = 3; // Number of authentification accepted.
const LOCKOUT_DURATION   = 1800; // Stop authentification process for 30 minutes: 60*30 = 1800.
const TRANSIENT_NAME     = PREFIX . '_attempted_login'; // Transient used.
const IS_LOCKOUT_GLOBAL  = false; // Is the lockout global or specific to each user?

/**
 * Lock login attempts of failed login limit is reached
 *
 * @param  object $user     The User Object.
 * @param  string $username The Username.
 * @param  string $password The Password.
 * @return object           The User Object.
 */
function check_attempted_login( $user, $username, $password ) {

	$pass = $password; // Silences WPCS!

	if ( IS_LOCKOUT_GLOBAL ) {
		$transient_name = 'mkdo_core_attempted_login';
	} else {
		$transient_name = 'mkdo_core_attempted_login_' . $username;
	}

	if ( get_transient( $transient_name ) ) {

		$datas = get_transient( $transient_name );

		if ( $datas['tried'] >= FAILED_LOGIN_LIMIT ) {

			$until = get_option( '_transient_timeout_' . $transient_name );
			$time  = when( $until );

			$user = new \WP_Error(
				'authentication_failed',
				sprintf(
					/* translators: 1: opening <strong> tag 2: closing <strong> tag 3: time until login permitted */
				esc_html__( '%1$sWARNING%2$s: You have attempted to login incorrectly too many times. You will be able to try again in %3$s.', 'mkdo-essentials' ),
					'<strong>',
					'</strong>',
					esc_html( $time )
					)
				);
		}
	}

	return $user;
}
add_filter( 'authenticate', __NAMESPACE__ . 'check_attempted_login', 30, 3 );

/**
 * Block User Enumeration
 */
function block_user_enumeration_attempts() {

	if ( is_admin() ) {
		return;
	}

	$author_by_id = ( isset( $_REQUEST['author'] ) && is_numeric( $_REQUEST['author'] ) ); // @codingStandardsIgnoreLine

	if ( $author_by_id ) {
		wp_die( 'Author archives have been disabled.' );
	}
}
add_action( 'template_redirect', __NAMESPACE__ . 'block_user_enumeration_attempts' );

/**
* Add transient
*
* @param  string $username The Username.
*/
function login_failed( $username ) {

	if ( IS_LOCKOUT_GLOBAL ) {
		$transient_name = 'mkdo_core_attempted_login';
	} else {
		$transient_name = 'mkdo_core_attempted_login_' . $username;
	}

	if ( get_transient( $transient_name ) ) {
		$datas = get_transient( $transient_name );
		$datas['tried']++;

		set_transient( $transient_name, $datas, LOCKOUT_DURATION );

		if ( $datas['tried'] >= FAILED_LOGIN_LIMIT ) {
			$expiration = time() + LOCKOUT_DURATION;
			update_option( '_transient_timeout_' . $transient_name, $expiration );
		}
	} else {
		$datas = array(
			'tried' => 1,
		);
		set_transient( $transient_name, $datas, LOCKOUT_DURATION );
	}
}
add_action( 'wp_login_failed', __NAMESPACE__ . 'login_failed', 10, 1 );

/**
* Return difference between 2 given dates
*
* <a href="/param">@param</a>  int      $time   Date as Unix timestamp
*
* @param  string $time Datetime.
* @return string       Return string
*/
function when( $time ) {

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
