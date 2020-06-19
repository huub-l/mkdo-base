<?php
/**
 * MKDO Data Model
 *
 * @package           MKDO\Data_Model
 *
 * Plugin Name:       MKDO Data Model
 * Description:       Underlying data model to support the project.
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mkdo-data-model
 * Domain Path:       /languages
 */

namespace MKDO\Data_Model;

if ( ! defined( 'WPINC' ) ) {
	die;
}

const ROOT_DIR = __DIR__;
const PREFIX   = 'mkdo_data_model';

require_once ROOT_DIR . '/inc/customizer-fields.php';
require_once ROOT_DIR . '/inc/meta-boxes.php';
require_once ROOT_DIR . '/inc/post-types.php';
require_once ROOT_DIR . '/inc/taxonomies.php';

load_plugin_textdomain( 'mkdo-data-model', false, ROOT_DIR . '\languages' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\Customizer_Fields\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Meta_Boxes\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Post_Types\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Taxonomies\setup' );
