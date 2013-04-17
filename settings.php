<?php

// Add the "HTML Cleanup" entry to the Wordpress "Settings" menu
add_action('admin_menu', 'html_cleanup_menu');
function html_cleanup_menu() {
	add_options_page('HTML Cleanup Options', 'HTML Cleanup', 'manage_options', 'html_cleanup', 'html_cleanup_options');
}

// Output the template for the plugin's "Settings" page
function html_cleanup_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	echo "<div class='wrap'>";
	screen_icon();
	echo "<h2>HTML Cleanup Options</h2>";
	echo "<form method='post' action='options.php'>";
	settings_fields('html_cleanup_group');
	do_settings_sections('html_cleanup');
	submit_button();
	echo "</form></div>";
}

// Register options in the database for the plugin
add_action('admin_init', 'register_html_cleanup_settings');
function register_html_cleanup_settings() {
	register_setting('html_cleanup_group', 'blacklisted_patterns');
	if (get_option('blacklisted_patterns') === false) {
		update_option('blacklisted_patterns', "");
	}
	add_settings_section('html_cleanup_blacklist_settings', 'Blacklist settings', 'text_html_cleanup_blacklist_settings', 'html_cleanup');
	add_settings_field('html_cleanup_blacklisted_patterns', 'List of patterns to blacklist', 'text_html_cleanup_blacklist', 'html_cleanup', 'html_cleanup_blacklist_settings');
	
	register_setting('html_cleanup_group', 'cleanup_override');
	add_settings_section('html_cleanup_override_settings', 'Override settings', 'text_html_cleanup_override_settings', 'html_cleanup');
	if (get_option('cleanup_override') === false || get_option('cleanup_override') === "") {
		update_option('cleanup_override', generateOverrideString());
	}
	add_settings_field('html_cleanup_override', 'URL parameter to override filtering', 'text_html_cleanup_override', 'html_cleanup', 'html_cleanup_override_settings');
	
	register_setting('html_cleanup_group', 'cleanup_comment');
	add_settings_section('html_cleanup_comment_settings', 'Comment settings', 'text_html_cleanup_comment_settings', 'html_cleanup');
	if (get_option('cleanup_comment') === false) {
		update_option('cleanup_comment', "on");
	}
	add_settings_field('html_cleanup_comment', 'Include comment in page header?', 'text_html_cleanup_comment', 'html_cleanup', 'html_cleanup_comment_settings');
}

// Generate a random string of characters to use as the cleanup override parameter
function generateOverrideString() {
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charlength = strlen($chars) - 1;
	$key = "";
	for ($i = 1; $i <= 16; $i++) {
		$key .= $chars[rand(0,$charlength)];
	}
	return $key;
}

// Output the descriptive text for the plugin's blacklist options on the "Settings" page
function text_html_cleanup_blacklist_settings() {
	echo "<p>In the box below, provide <a href='http://www.regular-expressions.info'>regular expression</a> patterns (or normal sequences of characters) that you want to exclude from the final HTML output. Lines of HTML in the output containing <b>any</b> of the below patterns will be removed, <b>so try to be as specific as possible</b>. Enter each pattern on a separate line.</p>";
}

// Output the blacklist input field on the plugin's "Settings" page
function text_html_cleanup_blacklist() {
	echo "<textarea id='html_cleanup_blacklisted_patterns' name='blacklisted_patterns' rows=10 cols=100>" . get_option('blacklisted_patterns') . "</textarea>";
}

// Output the descriptive text for the plugin's override options on the "Settings" page
function text_html_cleanup_override_settings() {
	echo "<p>You can provide a string of characters that can be specified as a URL parameter to temporarily disable <i>HTML Cleanup</i>'s activity. A string is automatically generated for you - save a blank value in this field to re-generate the override string. It is recommended that you choose a string of characters that is not easily guessable - otherwise visitors to your site could guess the pattern and see all the lines of HTML you are hiding.</p>";
	$overrideLink = home_url() . "?cleanupoverride=" . get_option('cleanup_override');
	echo "<p><b>Usage</b>: <a href='" . $overrideLink . "'>" . $overrideLink . "</a></p>";
	echo "<p>";
}

// Output the comment checkbox on the plugin's "Settings" page
function text_html_cleanup_override() {
	echo "<input type='text' id='html_cleanup_override' name='cleanup_override' value='" . get_option('cleanup_override') . "' />";
}

// Output the descriptive text for the plugin's comment options on the "Settings" page
function text_html_cleanup_comment_settings() {
	echo "<p>By default, the <i>HTML Cleanup</i> plugin inserts a comment into the header of public pages. This allows you to test the filtering capabilities of the plugin - try specifying <b>3UYbKPTEsahhppWL</b> as a blacklisted pattern above to remove it.</p>";
	echo "<p>Once you're happy with how the plugin works, you can uncheck the box below to turn the comment off completely.</p>";
}

// Output the override input field on the plugin's "Settings" page
function text_html_cleanup_comment() {
	if (get_option('cleanup_comment') === "on") {
		echo "<input type='checkbox' id='html_cleanup_comment' name='cleanup_comment' checked='checked' />";
	} else {
		echo "<input type='checkbox' id='html_cleanup_comment' name='cleanup_comment' />";
	}
}

?>