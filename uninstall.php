<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Make sure we're uninstalling
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	return false;
}

// Delete all the options
delete_option( 'ola_ll_img_url');
delete_option( 'ola_ll_sizes');
?>