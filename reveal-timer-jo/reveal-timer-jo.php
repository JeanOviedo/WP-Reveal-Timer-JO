<?php
/**
 * Plugin Name: Reveal Timer JO
 * Description: Reveals hidden content after a countdown. Compatible with Elementor and Gutenberg.
 * Version: 1.0.0
 * Author: Jean Carlos Oviedo Lopez
 * Text Domain: reveal-timer-jo
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * @package RevealTimerJO
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
if ( ! defined( 'RTJO_VERSION' ) ) {
    define( 'RTJO_VERSION', '1.0.0' );
}
if ( ! defined( 'RTJO_PLUGIN_DIR' ) ) {
    define( 'RTJO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'RTJO_PLUGIN_URL' ) ) {
    define( 'RTJO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Include necessary files
require_once RTJO_PLUGIN_DIR . 'includes/helpers.php';
require_once RTJO_PLUGIN_DIR . 'includes/shortcode.php';
require_once RTJO_PLUGIN_DIR . 'includes/admin-settings.php';

/**
 * Handle activation
 */
function rtjo_activate() {
    // Initialization logic if needed
}
register_activation_hook( __FILE__, 'rtjo_activate' );

/**
 * Enqueue scripts and styles
 */
/**
 * Enqueue scripts and styles
 */
function rtjo_enqueue_assets() {
    wp_enqueue_style( 'rtjo-timer-style', RTJO_PLUGIN_URL . 'assets/css/timer.css', array(), RTJO_VERSION );
    wp_enqueue_script( 'rtjo-timer-script', RTJO_PLUGIN_URL . 'assets/js/timer.js', array(), RTJO_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'rtjo_enqueue_assets' );

/**
 * Enqueue admin assets
 */
function rtjo_admin_assets( $hook ) {
    if ( 'toplevel_page_reveal-timer-jo' !== $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'rtjo-admin-js', RTJO_PLUGIN_URL . 'assets/js/admin.js', array( 'wp-color-picker' ), RTJO_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'rtjo_admin_assets' );

/**
 * Register settings
 */
function rtjo_register_settings() {
    register_setting( 'rtjo_settings_group', 'wprt_settings', array(
        'type'              => 'array',
        'sanitize_callback' => 'rtjo_sanitize_settings',
        'default'           => array(
            'primary_color' => '#0073aa',
            'bg_color'      => '#f9f9f9',
            'font_size'     => '2.5',
            'border_radius' => '8'
        )
    ));
}
add_action( 'admin_init', 'rtjo_register_settings' );

/**
 * Sanitize settings
 */
function rtjo_sanitize_settings( $input ) {
    $sanitized = array();
    
    if ( isset( $input['primary_color'] ) ) {
        $sanitized['primary_color'] = sanitize_hex_color( $input['primary_color'] );
    }
    
    if ( isset( $input['bg_color'] ) ) {
        $sanitized['bg_color'] = sanitize_hex_color( $input['bg_color'] );
    }
    
    if ( isset( $input['font_size'] ) ) {
        $sanitized['font_size'] = strval( floatval( $input['font_size'] ) );
    }
    
    if ( isset( $input['border_radius'] ) ) {
        $sanitized['border_radius'] = strval( intval( $input['border_radius'] ) );
    }
    
    return $sanitized;
}

/**
 * Output dynamic CSS
 */
function rtjo_dynamic_css() {
    $defaults = array(
        'primary_color' => '#0073aa',
        'bg_color'      => '#f9f9f9',
        'font_size'     => '2.5',
        'border_radius' => '8'
    );
    $options = get_option( 'wprt_settings', $defaults );
    $options = wp_parse_args( $options, $defaults );

    $primary = !empty($options['primary_color']) ? $options['primary_color'] : $defaults['primary_color'];
    $bg      = !empty($options['bg_color']) ? $options['bg_color'] : $defaults['bg_color'];
    $size    = !empty($options['font_size']) ? $options['font_size'] : $defaults['font_size'];
    $radius  = !empty($options['border_radius']) ? $options['border_radius'] : $defaults['border_radius'];

    echo '<style>
        :root {
            --wprt-primary-color: ' . esc_attr( $primary ) . ';
            --wprt-bg-color: ' . esc_attr( $bg ) . ';
            --wprt-font-size: ' . esc_attr( $size ) . 'em;
            --wprt-border-radius: ' . esc_attr( $radius ) . 'px;
        }
    </style>';
}
add_action( 'wp_head', 'rtjo_dynamic_css' );
add_action( 'admin_head', 'rtjo_dynamic_css' );
