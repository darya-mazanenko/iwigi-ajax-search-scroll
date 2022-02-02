<?php
/**
 * Plugin Name:       Ajax Infinite Woo Search Scroll
 * Plugin URI:        https://daryamazanenko.com
 * Description:       Infinite scroll of search results - WooCommerce
 * Version:           1.0.0
 * Author:            D Mazanenka
 * Author URI:        https://daryamazanenko.com
 * Text Domain:       iwigi-ajax-search-scroll
 * 
 * 
 * WC requires at least: 2.2
 * WC tested up to: 2.3
 * 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Plugin version.
 */
define( 'IWIGI_AJAX_SEARCH_SCROLL_VERSION', '1.0.0' );

/**
 * Check if WooCommerce is activated and run the plugin
 * Otherwise display admin notice
 * 
 * @since   1.0.0
 */
if( ! function_exists( 'iwigi_ajax_search_scroll_requirements' ) ) {
    function iwigi_ajax_search_scroll_requirements() {
        
        if( class_exists( 'WooCommerce' ) ) {
            
            /**
             * The core plugin class.
             */
            require plugin_dir_path( __FILE__ ) . 'includes/class-iwigi-ajax-search-scroll.php';
            
            run_iwigi_ajax_search_scroll();
            
        } else {
            
            add_filter( 'admin_notices', 'iwigi_ajax_search_scroll_requirements' );
            
        }
    }
}
add_action( 'plugins_loaded', 'iwigi_ajax_search_scroll_requirements' );

/**
 * Print admin notice if WooCommerce is not activated
 * 
 * @since   1.0.0
 */
function iwigi_ajax_search_scroll_print_notice() {
    
    $class   = "notice notice-error";
    $message = "WooCommerce is not active. The Ajax Infinite Woo Search Scroll plugin requires WooCommerce to be installed and activated.";
    
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_iwigi_ajax_search_scroll() {

	$plugin = new Iwigi_Ajax_Search_Scroll();
	$plugin->run();

}