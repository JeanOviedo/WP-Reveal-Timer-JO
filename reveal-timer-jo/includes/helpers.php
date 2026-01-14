<?php
/**
 * Helper functions
 * 
 * @package WPRevealTimer
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sanitize label text
 */
function rtjo_sanitize_label( $label ) {
    return sanitize_text_field( $label );
}

/**
 * Format seconds (optional utility)
 */
function rtjo_format_seconds( $seconds ) {
    return intval( $seconds );
}
