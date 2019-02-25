<?php
/**
 * Helpers Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Traits
 */
require_once 'traits/trait-render-view.php';

/**
 * Class Helpers.
 *
 * Helper class where useful static methods should be added,
 * as well as the inclusion of helper traits.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Helpers {
	use Helper_Render_View;
}
