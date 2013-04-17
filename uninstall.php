<?php 

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

delete_option('blacklisted_patterns');
delete_option('cleanup_override');
delete_option('cleanup_comment');

?>