<?php
/**
 * MKDO Essentials
 *
 * @package           MKDO\Essentials
 *
 * Plugin Name:       MKDO Essentials
 * Description:       Essential features to support client projects.
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mkdo-essentials
 * Domain Path:       /languages
 */

namespace MKDO\Essentials;

if ( ! defined( 'WPINC' ) ) {
	die;
}

// @codingStandardsIgnoreStart
if ( ! empty( $_SERVER['HTTP_HOST'] ) && $_SERVER['REQUEST_URI'] ) {
	$url        = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$parsed_url = wp_parse_url( $url );
	$url_chunks = explode( '.', $parsed_url['host'] );
	$tld        = end( $url_chunks );
} else {
	$tld = 'test';
}
// @codingStandardsIgnoreEnd
