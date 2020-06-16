# README

## MKDO Data Model

All custom post types, taxonomies, meta boxes and customizer fields should be registered within this plugin.

The data model should be kept separate to the presentational layer, and loaded in a manner that cannot be disabled by any user, hence the use of `mu-plugins`.

Examples for each of the types of data can be found in the respective folder. PHP files beginning with the relevant prefix will automatically be included from the folders e.g. `cpt-people.php` will automatically be included from the `post-types` folder whereas `wibble-people.php` will not.
