<?php
/**
 * Load 'Must Use' plugins.
 *
 * @link https://codex.wordpress.org/Must_Use_Plugins
 *
 * @package WordPress
 */

// Kirki.
require_once plugin_dir_path( __FILE__ ) . 'kirki/kirki.php';

require_once plugin_dir_path( __FILE__ ) . 'mkdo-core/plugin.php';

require_once plugin_dir_path( __FILE__ ) . 'mkdo-permissions/plugin.php';

require_once plugin_dir_path( __FILE__ ) . 'mkdo-limit-login-attempts.php';

