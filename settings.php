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
	add_settings_section('html_cleanup_blacklist_settings', 'Blacklist settings', 'text_html_cleanup_blacklist_settings', 'html_cleanup');
	
	register_setting('html_cleanup_group', 'blacklisted_patterns');
	if (get_option('blacklisted_patterns') === false) {
		update_option('blacklisted_patterns', "");
	}
	add_settings_field('html_cleanup_blacklisted_patterns', 'List of patterns to blacklist', 'text_html_cleanup_blacklist', 'html_cleanup', 'html_cleanup_blacklist_settings');
	
	register_setting('html_cleanup_group', 'blacklist_replace_flag');
	if (get_option('blacklist_replace_flag') === false) {
		update_option('blacklist_replace_flag', "");
	}
	add_settings_field('html_cleanup_replace_flag', 'Replace matching lines instead of removing them?', 'text_html_cleanup_replace_flag', 'html_cleanup', 'html_cleanup_blacklist_settings');
	
	register_setting('html_cleanup_group', 'blacklist_replace_string');
	if (get_option('blacklist_replace_string') === false) {
		update_option('blacklist_replace_string', "");
	}
	add_settings_field('html_cleanup_replacement_string', 'Replacement string', 'text_html_cleanup_replace_string', 'html_cleanup', 'html_cleanup_blacklist_settings');
	
	add_settings_section('html_cleanup_override_settings', 'Override settings', 'text_html_cleanup_override_settings', 'html_cleanup');
	
	register_setting('html_cleanup_group', 'cleanup_override');
	if (get_option('cleanup_override') === false || get_option('cleanup_override') === "") {
		update_option('cleanup_override', generateOverrideString());
	}
	add_settings_field('html_cleanup_override', 'URL parameter to override filtering', 'text_html_cleanup_override', 'html_cleanup', 'html_cleanup_override_settings');
	
	add_settings_section('html_cleanup_comment_settings', 'Comment settings', 'text_html_cleanup_comment_settings', 'html_cleanup');
	
	register_setting('html_cleanup_group', 'cleanup_comment');
	if (get_option('cleanup_comment') === false) {
		update_option('cleanup_comment', "on");
	}
	add_settings_field('html_cleanup_comment', 'Insert HTML comment in header?', 'text_html_cleanup_comment', 'html_cleanup', 'html_cleanup_comment_settings');
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
	echo "<p>In the box below, provide <a href='http://www.regular-expressions.info'>regular expression</a> patterns (or normal sequences of characters) that you want to exclude or replace from the final HTML output. Lines of HTML in the output containing <b>any</b> of the below patterns will be filtered, <b>so try to be as specific as possible</b>. Enter each pattern on a separate line.</p>";
}

// Output the blacklist input field on the plugin's "Settings" page
function text_html_cleanup_blacklist() {
	echo "<textarea id='html_cleanup_blacklisted_patterns' name='blacklisted_patterns' rows=10 cols=100>" . get_option('blacklisted_patterns') . "</textarea>";
}

// Output the replacement checkbox on the plugin's "Settings" page
function text_html_cleanup_replace_flag() {
	if (get_option('blacklist_replace_flag') === "on") {
		echo "<input type='checkbox' id='html_cleanup_replace_flag' name='blacklist_replace_flag' checked='checked' />";
	} else {
		echo "<input type='checkbox' id='html_cleanup_replace_flag' name='blacklist_replace_flag' />";
	}
}

// Output the replacement input field on the plugin's "Settings" page
function text_html_cleanup_replace_string() {
	echo "<input type='text' id='html_cleanup_replacement_string' name='blacklist_replace_string' value='" . get_option('blacklist_replace_string') . "' />";
}

// Output the descriptive text for the plugin's override options on the "Settings" page
function text_html_cleanup_override_settings() {
	echo "<p>You can provide a string of characters that, if specified as a URL parameter, will temporarily disable HTML Cleanup's activity. (This is useful for viewing your unfiltered page without disabling HTML Cleanup.) A string is automatically generated for you below - save a blank value in this field to re-generate the override string. It is recommended that you choose a string of characters that is not easily guessable - otherwise visitors to your site could guess the pattern and see all the lines of HTML you are hiding.</p>";
	echo "<p><b>Note</b>: The override will not work if you use a Wordpress caching plugin. You will need to disable caching functionality on the site to use HTML Cleanup's override feature.</p>";
	$overrideLink = home_url() . "?cleanupoverride=" . get_option('cleanup_override');
	echo "<p><b>Usage</b>: <a href='" . $overrideLink . "'>" . $overrideLink . "</a></p>";
}

// Output the comment checkbox on the plugin's "Settings" page
function text_html_cleanup_override() {
	echo "<input type='text' id='html_cleanup_override' name='cleanup_override' value='" . get_option('cleanup_override') . "' />";
}

// Output the descriptive text for the plugin's comment options on the "Settings" page
function text_html_cleanup_comment_settings() {
	echo "<p>By default, HTML Cleanup inserts a comment into the header of public pages. This allows you to test the filtering capabilities of the plugin - try specifying <b>3UYbKPTEsahhppWL</b> as a blacklisted pattern above to remove it.</p>";
	echo "<p>Once you're happy with how the plugin works, you can uncheck the box below to turn the comment off completely.</p>";
}

// Output the comment checkbox on the plugin's "Settings" page
function text_html_cleanup_comment() {
	if (get_option('cleanup_comment') === "on") {
		echo "<input type='checkbox' id='html_cleanup_comment' name='cleanup_comment' checked='checked' />";
	} else {
		echo "<input type='checkbox' id='html_cleanup_comment' name='cleanup_comment' />";
	}
}

?>