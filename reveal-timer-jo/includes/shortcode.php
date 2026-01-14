<?php
/**
 * Shortcode logic
 * 
 * @package WPRevealTimer
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register reveal_timer shortcode
 * [reveal_timer seconds="10" label="Contenido disponible en:"]...[/reveal_timer]
 */
function rtjo_shortcode_reveal_timer( $atts, $content = null ) {
    $atts = shortcode_atts(
        array(
            'seconds' => '10',
            'label'   => __( 'Contenido disponible en:', 'reveal-timer-jo' ),
            'type'    => 'default', // Prepared for future extensions
        ),
        $atts,
        'reveal_timer'
    );

    $seconds = intval( $atts['seconds'] );
    $label   = esc_html( $atts['label'] );
    $unique_id = uniqid( 'rtjo-' );

    // Allow nested shortcodes
    $content = do_shortcode( $content );

    ob_start();
    ?>
    <div class="wprt-timer-container" id="<?php echo esc_attr( $unique_id ); ?>" data-seconds="<?php echo esc_attr( $seconds ); ?>">
        <div class="wprt-timer-header">
            <span class="wprt-timer-label"><?php echo esc_html( $label ); ?></span>
            <span class="wprt-timer-countdown"></span>
        </div>
        <div class="wprt-timer-content" style="display: none;">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'reveal_timer', 'rtjo_shortcode_reveal_timer' );
