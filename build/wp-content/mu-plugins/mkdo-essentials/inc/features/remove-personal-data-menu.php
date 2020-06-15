<?php
/**
 * Remove Personal Data Menu.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Personal_Data_Menu;

/**
 * Remove Submenus.
 *
 * Hides the submenu for 'Erase Personal Data'.
 *
 * @return void
 */
function remove_submenus() : void {
	remove_submenu_page( 'tools.php', 'erase-personal-data.php' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_submenus', 500 );
