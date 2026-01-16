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
if ( ! defined( 'REVETIJO_VERSION' ) ) {
    define( 'REVETIJO_VERSION', '1.0.0' );
}
if ( ! defined( 'REVETIJO_PLUGIN_DIR' ) ) {
    define( 'REVETIJO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'REVETIJO_PLUGIN_URL' ) ) {
    define( 'REVETIJO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Include necessary files
require_once REVETIJO_PLUGIN_DIR . 'includes/helpers.php';
require_once REVETIJO_PLUGIN_DIR . 'includes/shortcode.php';
require_once REVETIJO_PLUGIN_DIR . 'includes/admin-settings.php';

/**
 * Handle activation
 */
function revetijo_activate() {
    // Initialization logic if needed
}
register_activation_hook( __FILE__, 'revetijo_activate' );

/**
 * Enqueue scripts and styles
 */
function revetijo_enqueue_assets() {
    wp_enqueue_style( 'revetijo-timer-style', REVETIJO_PLUGIN_URL . 'assets/css/timer.css', array(), REVETIJO_VERSION );
    wp_enqueue_script( 'revetijo-timer-script', REVETIJO_PLUGIN_URL . 'assets/js/timer.js', array(), REVETIJO_VERSION, true );
    
    // Output dynamic CSS
    $defaults = array(
        'primary_color' => '#0073aa',
        'bg_color'      => '#f9f9f9',
        'font_size'     => '2.5',
        'border_radius' => '8'
    );
    $options = get_option( 'revetijo_settings', $defaults );
    $options = wp_parse_args( $options, $defaults );

    $primary = !empty($options['primary_color']) ? $options['primary_color'] : $defaults['primary_color'];
    $bg      = !empty($options['bg_color']) ? $options['bg_color'] : $defaults['bg_color'];
    $size    = !empty($options['font_size']) ? $options['font_size'] : $defaults['font_size'];
    $radius  = !empty($options['border_radius']) ? $options['border_radius'] : $defaults['border_radius'];

    $custom_css = "
        :root {
            --revetijo-primary-color: " . esc_attr( $primary ) . ";
            --revetijo-bg-color: " . esc_attr( $bg ) . ";
            --revetijo-font-size: " . esc_attr( $size ) . "em;
            --revetijo-border-radius: " . esc_attr( $radius ) . "px;
        }";
    wp_add_inline_style( 'revetijo-timer-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'revetijo_enqueue_assets' );

/**
 * Enqueue admin assets
 */
function revetijo_admin_assets( $hook ) {
    if ( 'toplevel_page_reveal-timer-jo' !== $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'revetijo-admin-style', REVETIJO_PLUGIN_URL . 'assets/css/admin.css', array(), REVETIJO_VERSION );
    wp_enqueue_script( 'revetijo-admin-js', REVETIJO_PLUGIN_URL . 'assets/js/admin.js', array( 'wp-color-picker' ), REVETIJO_VERSION, true );
    
    // Dynamic CSS for admin preview
    $defaults = array(
        'primary_color' => '#0073aa',
        'bg_color'      => '#f9f9f9',
        'font_size'     => '2.5',
        'border_radius' => '8'
    );
    $options = get_option( 'revetijo_settings', $defaults );
    $options = wp_parse_args( $options, $defaults );

    $primary = !empty($options['primary_color']) ? $options['primary_color'] : $defaults['primary_color'];
    $bg      = !empty($options['bg_color']) ? $options['bg_color'] : $defaults['bg_color'];
    $size    = !empty($options['font_size']) ? $options['font_size'] : $defaults['font_size'];
    $radius  = !empty($options['border_radius']) ? $options['border_radius'] : $defaults['border_radius'];

    $custom_css = "
        :root {
            --revetijo-primary-color: " . esc_attr( $primary ) . ";
            --revetijo-bg-color: " . esc_attr( $bg ) . ";
            --revetijo-font-size: " . esc_attr( $size ) . "em;
            --revetijo-border-radius: " . esc_attr( $radius ) . "px;
        }";
    wp_add_inline_style( 'revetijo-admin-style', $custom_css );
}
add_action( 'admin_enqueue_scripts', 'revetijo_admin_assets' );

/**
 * Register settings
 */
function revetijo_register_settings() {
    register_setting( 'revetijo_settings_group', 'revetijo_settings', array(
        'type'              => 'array',
        'sanitize_callback' => 'revetijo_sanitize_settings',
        'default'           => array(
            'primary_color' => '#0073aa',
            'bg_color'      => '#f9f9f9',
            'font_size'     => '2.5',
            'border_radius' => '8'
        )
    ));
}
add_action( 'admin_init', 'revetijo_register_settings' );

/**
 * Sanitize settings
 */
function revetijo_sanitize_settings( $input ) {
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
