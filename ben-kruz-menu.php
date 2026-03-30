<?php
/**
 * Plugin Name: Ben Kruz Menu
 * Description: Mobil uyumlu, CTA butonlu ve "YENİ" badge destekli özel header menüsü.
 * Version: 1.0.0
 * Author: Ben Kruz
 * Text Domain: ben-kruz-menu
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BKM_PATH', plugin_dir_path( __FILE__ ) );
define( 'BKM_URL', plugin_dir_url( __FILE__ ) );

// Elementor Widget'ını Kayıt Et
function bkm_register_header_widget( $widgets_manager ) {
    require_once BKM_PATH . 'includes/class-header-widget.php';
    $widgets_manager->register( new \BenKruzMenu\Includes\Ben_Kruz_Header_Widget() );
}
add_action( 'elementor/widgets/register', 'bkm_register_header_widget' );

// Script ve Stilleri Kayıt Et
function bkm_register_assets() {
    wp_register_style( 'bkm-style', BKM_URL . 'assets/css/header-style.css', [], '1.0.0' );
    wp_register_script( 'bkm-script', BKM_URL . 'assets/js/header-script.js', ['jquery'], '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'bkm_register_assets' );