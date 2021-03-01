=== FG Drupal to WordPress Premium Internationalization module ===
Contributors: Frédéric GILLES
Plugin Uri: https://www.fredericgilles.net/fg-drupal-to-wordpress/
Tags: drupal, wordpress, importer, migrator, converter, import, internationalization, wpml, multilang
Requires at least: 4.5
Tested up to: 5.6
Stable tag: 1.3.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to migrate the Drupal translations to WPML (WordPress)
Needs «FG Drupal to WordPress Premium» and WPML plugins to work

== Description ==

This is the Internationalization module. It works only if the plugin FG Drupal to WordPress Premium and the WPML plugin are already installed.
It has been tested with **Drupal 6, 7 and 8**, **WPML 4** and **Wordpress 5.6**. It is compatible with multisite installations.

Major features include:

* migrates the nodes translations
* migrates the taxonomies translations

== Installation ==

1.  Prerequesite: Buy and install the plugin «FG Drupal to WordPress Premium»
2.  Extract plugin zip file and load up to your wp-content/plugin directory
3.  Activate Plugin in the Admin => Plugins Menu
4.  Run the importer in Tools > Import > Drupal

== Translations ==
* English (default)
* French (fr_FR)
* other can be translated

== Changelog ==

= 1.3.1 =
Fixed: [ERROR] Error:SQLSTATE[42000]: Syntax error or access violation: 1066 Not unique table/alias: 'nd'
Fixed: Wrong total number in the progress bar
Fixed: Missing terms translations from Drupal 8
Fixed: Missing nodes translations from Drupal 8

= 1.3.0 =
Compatible with FG Drupal to WordPress Premium 2.34.0
Tested with WordPress 5.6

= 1.2.0 =
New: Add WP-CLI and CRON support
Tested with WordPress 5.5

= 1.1.2 =
Compatible with FG Drupal to WordPress Premium 2.13.1
Tested with WordPress 5.4

= 1.1.1 =
Fixed: Some field values were not imported

= 1.1.0 =
New: Import the node translations using the table "field_data_title_field"
Tested with WordPress 5.3

= 1.0.4 =
Fixed: Translations not imported on Drupal 8
Fixed: [ERROR] Error:SQLSTATE[23000]: Integrity constraint violation: 1052 Column 'langcode' in where clause is ambiguous
Fixed: The progress bar exceeds 100% with Drupal 8 sites
Tested with WordPress 5.2

= 1.0.3 =
Fixed: Categories translations whose name is the same as in the original language were not imported
Tested with WordPress 5.1
Tested with WPML 4.2

= 1.0.2 =
Fixed: Some categories imported in wrong language
Tested with WordPress 4.8
Tested with WPML 3.8

= 1.0.1 =
Fixed: The language codes with more than 2 characters (eg. pt-br) were not imported

= 1.0.0 =
Initial version
