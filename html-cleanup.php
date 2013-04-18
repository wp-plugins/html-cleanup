<?php
/*
Plugin Name: HTML Cleanup
Plugin URI: https://davidlyness.com/plugins/html-cleanup
Description: A plugin to filter lines of outputted HTML in public pages based on predefined regular expressions.
Version: 1.0.1
Author: David Lyness
Author URI: https://davidlyness.com
License: GPLv2
*/

// File to get / set administrative options
require_once(__DIR__ . '/settings.php');

// Do the actual filtering by performing regex search / replace operations
function html_cleanup_callback($buffer) {
	$cleanupOverride = $_GET['cleanupoverride'];
	if (!isset($_GET['cleanupoverride']) || $_GET['cleanupoverride'] !== get_option('cleanup_override')) {
		if (get_option('blacklisted_patterns')) {
			$badPatterns = split("\r\n", get_option('blacklisted_patterns'));
			foreach ($badPatterns as $pattern) {
				$buffer = preg_replace('/.*' . $pattern . '.*/', '', $buffer);
			}
			$buffer = preg_replace(array("/\r\n\r\n/", "/\n\n/"), array("\r\n", "\n"), $buffer); // removing lines of HTML introduces unneeded line breaks - this replace operation removes them
		}
	}
	return $buffer;
}

 // Begin filtering content right after <head>, buffering the HTML output of the page so that it can be filtered by the html_cleanup_callback function
add_action('wp_head', 'html_cleanup_buffer_start', 1);
function html_cleanup_buffer_start() {
	ob_start("html_cleanup_callback");
	if (get_option('cleanup_comment') === "on") {
		echo "<!-- This is a sample line of HTML, added by the HTML Cleanup plugin (https://davidlyness.com/plugins/html-cleanup), so that you can try out the plugin's filtering functionality. Try blacklisting the following sequence of characters to remove it, or see the plugin's settings page for more information: 3UYbKPTEsahhppWL -->\r\n";
	}
}

 // End filtering right before </body>
add_action('wp_footer', 'html_cleanup_buffer_end', 1000);
function html_cleanup_buffer_end() {
	ob_end_flush();
}


?>