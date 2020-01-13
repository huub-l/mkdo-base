<?php
/**
 * Local Config.
 *
 * @package WordPress
 */

@ini_set( 'display_errors', 1 );
define( 'DB_NAME', 'my_project' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_CHARSET', 'utf8' );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
