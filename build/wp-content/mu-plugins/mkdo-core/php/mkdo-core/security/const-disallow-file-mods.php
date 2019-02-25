<?php
/**
 * File Install
 *
 * We would like all of the plugins to be managed within the repo, also we shouldn't
 * really be putting plugins direclty on the live site without testing them.
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

// Disable Plugin and Theme Update and Installation.
// Unless our domain ends in .local (development environment).
if ( 'test' !== MKDO_CORE_TLD && ! defined( 'DISALLOW_FILE_MODS' ) ) {
	define( 'DISALLOW_FILE_MODS', true ); // @codingStandardsIgnoreLine
}
