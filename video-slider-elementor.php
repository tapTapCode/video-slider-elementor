<?php
/**
 * Plugin Name: Video Slider for Elementor
 * Description: Custom Elementor widget for self-hosted video sliders with auto-play
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: video-slider-elementor
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('VIDEO_SLIDER_WIDGET_VERSION', '1.0.0');
define('VIDEO_SLIDER_WIDGET_DIR', plugin_dir_path(__FILE__));
define('VIDEO_SLIDER_WIDGET_URL', plugin_dir_url(__FILE__));

/**
 * Enqueue Swiper library and custom scripts
 */
add_action('wp_enqueue_scripts', function() {
    // Enqueue Swiper library from CDN
    wp_register_style(
        'swiper-style',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    wp_register_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    // Register custom widget styles and scripts
    wp_register_style(
        'video-slider-style',
        VIDEO_SLIDER_WIDGET_URL . 'video-slider-widget.css',
        ['swiper-style'],
        VIDEO_SLIDER_WIDGET_VERSION
    );

    wp_register_script(
        'video-slider-script',
        VIDEO_SLIDER_WIDGET_URL . 'video-slider-widget.js',
        ['swiper'],
        VIDEO_SLIDER_WIDGET_VERSION,
        true
    );

    // Enqueue if Elementor is active
    if (did_action('elementor/loaded')) {
        wp_enqueue_style('swiper-style');
        wp_enqueue_style('video-slider-style');
        wp_enqueue_script('swiper');
        wp_enqueue_script('video-slider-script');
    }
});

/**
 * Register the widget with Elementor
 */
add_action('elementor/widgets/register', function($widgets_manager) {
    require_once VIDEO_SLIDER_WIDGET_DIR . 'video-slider-widget.php';
    $widgets_manager->register(new Video_Slider_Widget());
});

/**
 * Load plugin text domain for translations
 */
add_action('plugins_loaded', function() {
    load_plugin_textdomain(
        'video-slider-elementor',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});

/**
 * Check if Elementor is installed and activated
 */
register_activation_hook(__FILE__, function() {
    if (!did_action('elementor/loaded')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            sprintf(
                esc_html__('Video Slider for Elementor requires Elementor to be installed and activated. %1$sGo back%2$s', 'video-slider-elementor'),
                '<a href="' . esc_url(admin_url('plugins.php')) . '">',
                '</a>'
            )
        );
    }
});
