=== HTML Cleanup ===
Contributors: davidlyness
Donate link: https://supporters.eff.org/donate
Tags: html, replace, remove, filter, regex, regular expression
Requires at least: 3.5.1
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to replace or remove lines of HTML generated by Wordpress and other plugins based on predefined regular expressions.

== Description ==

This plugin allows you to specify patterns of HTML that will be replaced or removed from the final output. You can define such patterns as normal text (e.g. "penguin" will filter all lines in the output HTML containing "penguin") or as a regular expression (e.g. "WinterIs(Coming|Here)" will filter all lines of text containing either "WinterIsComing" or "WinterIsHere").

For more information on regular expressions, see [regular-expressions.info](http://www.regular-expressions.info).

If you come across any bugs in the plugin, or if you have any suggestions on how to make it better, [contact me directly](https://davidlyness.com/contact) or use the Wordpress plugin support forums.

== Installation ==

1. Upload the plugin folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin to your liking using the 'HTML Cleanup' option in the "Settings" menu.

== Frequently Asked Questions ==

= What might I use this plugin for? =

HTML Cleanup is designed to be as versatile as possible. It is up to **you** to decide what you wish to filter in your HTML - this plugin only provides a method to do this reliably.

I originally created this plugin for personal use, to remove artifacts **other** plugins inserted without my permission onto my public site (even though they're [not supposed to](http://wordpress.org/extend/plugins/about/guidelines/)). It can and is used for this purpose, as well as removing hidden HTML comments left by other plugins on public pages.

Alternatively, if you wish to remove or replace some HTML inserted by your Wordpress theme without modifying the theme's files (which will be reset when the theme updates anyway), you can specify that this should be removed using HTML Cleanup.

= What if I make a mistake when configuring HTML Cleanup and remove too much HTML? Will my site become inaccessible? =

HTML Cleanup only filters the HTML output on public pages (i.e. not in the administrative settings area). Therefore, you will always be able to access your settings and modify or disable the plugin if you wish.

There is also a method to temporarily disable filtering by appending an override parameter to the URL - see the plugin's Settings page for more details.

== Screenshots ==

1. The Settings page for the HTML Cleanup plugin.

== Changelog ==

= 1.2.3 =
* Remove unnecessary PHP notice in admin area when WP_DEBUG is enabled.

= 1.2.2 =
* Ensure PHP doesn't generate a notice regarding an undefined index.

= 1.2.1 =
* Compatibility with versions of PHP prior to v5.3.

= 1.2.0 =
* HTML Cleanup can now replace blacklisted HTML patterns as well as removing them.

= 1.1.0 =
* HTML Cleanup now parses the entire page rather than just the head and body.

= 1.0.1 =
* Fixed typos in plugin readme / description.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.2.3 =
HTML Cleanup now no longer causes PHP to generate a notice regarding deleting / flushing a buffer in the admin area when WP_DEBUG is enabled.
