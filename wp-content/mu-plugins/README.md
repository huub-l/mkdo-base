# README

## MKDO Data Model

All custom post types, taxonomies, meta boxes and customizer fields should be registered within this plugin.

The data model should be kept separate to the presentational layer, and loaded in a manner that cannot be disabled by any user, hence the use of `mu-plugins`.

Examples for each of the types of data can be found in the respective folder. PHP files beginning with the relevant prefix will automatically be included from the folders e.g. `cpt-people.php` will automatically be included from the `post-types` folder whereas `wibble-people.php` will not.

## MKDO Essentials

This plugin is a collection of useful, re-usable features that are common across projects, that make modifications to WordPress   core, plugins and themes.

In order to add a new feature to the plugin, simply create a new feature based on the `example-feature.php` template (see below) and drop it into the `/inc/features/` folder with a descriptive file name starting with a word that summarises the type of action required.

For example, if we were adding a feature that filtered post content for swear words and replaced them, then the file would be called `replace-swear-words.php` and the contents would be along these lines:

```
<?php
/**
 * Replace Swear Words.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Replace_Swear_Words;

/**
 * Feature Disabled Check.
 *
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Feature Hooks/Filters.
 *
 * NOTE: Remember to use the __NAMESPACE__ prefix with action/filter callbacks.
 */
function replace_swear_words( $content ) : string {

  // Replace swear words.
  
  return $content
}
add_filter( 'the_content', __NAMESPACE__ . '\\replace_swear_words', 20 );
```
