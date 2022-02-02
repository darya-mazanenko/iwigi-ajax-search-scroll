<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://daryamazanenko.com
 * @since      1.0.0
 *
 * @package    Iwigi_Ajax_Search_Scroll
 * @subpackage Iwigi_Ajax_Search_Scroll/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Iwigi_Ajax_Search_Scroll
 * @subpackage Iwigi_Ajax_Search_Scroll/includes
 * @author     D Mazanenka <darya.mazanenko@gmail.com>
 */
class Iwigi_Ajax_Search_Scroll 
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Iwigi_Ajax_Search_Scroll_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'IWIGI_AJAX_SEARCH_SCROLL_VERSION' ) ) {
			$this->version = IWIGI_AJAX_SEARCH_SCROLL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'iwigi-ajax-search-scroll';
	    
	    $this->load_dependencies();
	    $this->define_public_hooks();
        
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Iwigi_Ajax_Search_Scroll_Loader. Orchestrates the hooks of the plugin.
	 * - Iwigi_Ajax_Search_Scroll_i18n. Defines internationalization functionality.
	 * - Iwigi_Ajax_Search_Scroll_Admin. Defines all hooks for the admin area.
	 * - Iwigi_Ajax_Search_Scroll_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iwigi-ajax-search-scroll-loader.php';
	
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-iwigi-ajax-search-scroll-public.php';

		$this->loader = new Iwigi_Ajax_Search_Scroll_Loader();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Iwigi_Ajax_Search_Scroll_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	    
		$this->loader->add_action( 'wp_ajax_get_search', $plugin_public, 'ajax_search_handler' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_search', $plugin_public, 'ajax_search_handler' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Iwigi_Ajax_Search_Scroll_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
