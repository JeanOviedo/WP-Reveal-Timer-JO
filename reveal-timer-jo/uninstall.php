<?php
/**
 * WP Reveal Timer Uninstall
 * 
 * @package WPRevealTimer
 */

// If uninstall not called from WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Clean up any future settings or transients here if added
// delete_option('wprt_settings');
