<?php
/**
 * Admin Settings Logic
 * 
 * @package RevealTimerJO
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add settings page to top-level menu
 */
function rtjo_add_admin_menu() {
    add_menu_page(
        'Reveal Timer JO Settings',
        'Reveal Timer JO',
        'manage_options',
        'reveal-timer-jo',
        'rtjo_settings_page',
        'dashicons-clock',
        80
    );
}
add_action( 'admin_menu', 'rtjo_add_admin_menu' );

/**
 * Render settings page
 */
function rtjo_settings_page() {
    $options = get_option( 'wprt_settings', array(
        'primary_color' => '#0073aa',
        'bg_color'      => '#f9f9f9',
        'font_size'     => '2.5',
        'border_radius' => '8'
    ));
    ?>
    <div class="wrap wprt-admin-wrap">
        <h1><?php esc_html_e( 'Reveal Timer JO', 'reveal-timer-jo' ); ?></h1>
        
        <div class="wprt-admin-content" style="max-width: 800px; margin-top: 20px;">
            <div class="card" style="padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #2271b1;">
                <h2><?php esc_html_e( 'ℹ️ Acerca del Plugin', 'reveal-timer-jo' ); ?></h2>
                <p><?php esc_html_e( 'Reveal Timer JO es una herramienta profesional diseñada para maximizar la retención y conversión. Permite ocultar elementos estratégicos (botones de compra, enlaces, formularios) y revelarlos automáticamente después de una cuenta regresiva.', 'reveal-timer-jo' ); ?></p>
                <p><strong><?php esc_html_e( 'Ideal para:', 'reveal-timer-jo' ); ?></strong></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li><?php esc_html_e( 'Embudos de venta (VSL) donde el botón de compra aparece en un momento clave.', 'reveal-timer-jo' ); ?></li>
                    <li><?php esc_html_e( 'Ofertas por tiempo limitado.', 'reveal-timer-jo' ); ?></li>
                    <li><?php esc_html_e( 'Contenido premium o acceso diferido.', 'reveal-timer-jo' ); ?></li>
                </ul>
            </div>

            <form method="post" action="options.php">
                <?php
                settings_fields( 'rtjo_settings_group' );
                ?>
                <div class="card" style="padding: 20px; border-radius: 8px;">
                    <h2><?php esc_html_e( '🎨 Personalización Visual', 'reveal-timer-jo' ); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Color Principal', 'reveal-timer-jo' ); ?></th>
                            <td>
                                <input type="text" name="wprt_settings[primary_color]" value="<?php echo esc_attr( $options['primary_color'] ); ?>" class="wprt-color-field" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Color de Fondo', 'reveal-timer-jo' ); ?></th>
                            <td>
                                <input type="text" name="wprt_settings[bg_color]" value="<?php echo esc_attr( $options['bg_color'] ); ?>" class="wprt-color-field" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Tamaño Fuente (em)', 'reveal-timer-jo' ); ?></th>
                            <td>
                                <input type="number" step="0.1" name="wprt_settings[font_size]" value="<?php echo esc_attr( $options['font_size'] ); ?>" class="small-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Borde Redondeado (px)', 'reveal-timer-jo' ); ?></th>
                            <td>
                                <input type="number" name="wprt_settings[border_radius]" value="<?php echo esc_attr( $options['border_radius'] ); ?>" class="small-text" />
                            </td>
                        </tr>
                    </table>
                    <?php submit_button( esc_html__( 'Guardar cambios', 'reveal-timer-jo' ) ); ?>
                </div>
            </form>

            <div class="card" style="padding: 20px; border-radius: 8px; margin-top: 20px;">
                <h2><?php esc_html_e( '🚀 Cómo usar el Shortcode', 'reveal-timer-jo' ); ?></h2>
                <p><?php esc_html_e( 'Usa el siguiente shortcode para envolver cualquier contenido que desees revelar:', 'reveal-timer-jo' ); ?></p>
                <code style="display: block; background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 15px 0; border: 1px solid #ccc;">
                    [reveal_timer seconds="10" label="<?php esc_html_e( 'Contenido disponible en:', 'reveal-timer-jo' ); ?>"]<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;button&gt;<?php esc_html_e( 'Clic aquí para oferta', 'reveal-timer-jo' ); ?>&lt;/button&gt;<br>
                    [/reveal_timer]
                </code>
            </div>
        </div>

        <div style="margin-top: 30px; font-size: 0.9em; color: #666;">
            <?php esc_html_e( 'Desarrollado por', 'reveal-timer-jo' ); ?> 
            <a href="https://jeanoviedo.com" target="_blank" rel="noopener noreferrer" style="color:#1e88e5; text-decoration:none; font-weight:bold;">
                Jean Carlos Oviedo Lopez
            </a>
            | <?php esc_html_e( 'Versión', 'reveal-timer-jo' ); ?> 1.0.0
        </div>
    </div>

    <style>
        .wprt-admin-wrap .card h2 { margin-top: 0; color: #2271b1; }
        .wprt-admin-wrap .card h3 { border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 25px; }
        .wprt-admin-wrap code { font-size: 1.1em; color: #d63638; }
        /* Ensure preview styles are applied in admin */
        #wprt-preview-container .wprt-timer-container {
            border: 1px solid #ccc;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
    </style>
    <?php
}
