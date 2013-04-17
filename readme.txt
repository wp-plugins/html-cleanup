=== HTML Cleanup ===
Contributors: davidlyness
Tags: html, replace, remove, filter, regex, regular expression
Requires at least: 3.5.1
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows you to strip out lines of HTML based on predefined regular expressions.

== Description ==

This plugin allows you to specify patterns of HTML that will be removed from the final output. You can define such patterns as normal text (e.g. "test123" will remove all lines in the output HTML containing "test123") or as a regular expression (e.g. "<!--.*-->" will remove all HTML comments in the output).

For more information on regular expressions, see [http://www.regular-expressions.info].

If you come across any bugs in the plugin, or if you have any suggestions on how to make it better, contact me using [https://davidlyness.com/contact](my website) or use the Wordpress plugin support forums.

== Installation ==

1. Upload the plugin folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin using the 'HTML Cleanup' option in the "Settings" menu 

== Screenshots ==

1. The "Settings" page for the 'HTML Cleanup' plugin.

== Changelog ==

= 0.1 =
* Initial release