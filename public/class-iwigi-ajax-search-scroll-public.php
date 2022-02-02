<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @author     D Mazanenka <darya.mazanenko@gmail.com>
 */
class Iwigi_Ajax_Search_Scroll_Public 
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        if( is_search() ) {
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iwigi-ajax-search-scroll-public.css', $this->version );
        }
		
	}
	
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        if( is_search() ){
            
            global $wp_query;
            
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iwigi-ajax-search-scroll-public.js', array( 'jquery' ), $this->version, true );
		
            wp_localize_script( $this->plugin_name, 'iwigi_ajax_admin', array(
                'ajaxurl'        => admin_url( 'admin-ajax.php' ),
                'query_vars'     => json_encode( $wp_query->query ),
                'current_page'   => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                'max_pages'      => $wp_query->max_num_pages,
                'posts_per_page' => get_query_var( 'posts_per_page' ),
                'nonce'          => wp_create_nonce( 'iwigi_ajax_search' )
            ) );    
        }
		
	}
	
	/**
	 * Ajax handler to display products by args
	 *
	 * @since    1.0.0
	 */
	public function ajax_search_handler() {
	    
	    check_ajax_referer( 'iwigi_ajax_search');
	    
	    $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	    
	    $query_vars['current_page']   = $_POST['current_page'] + 1;
	    $query_vars['posts_per_page'] = $_POST['posts_per_page'];
        
	    $products = $this->get_products( $query_vars );
    	
    	if ( $products->have_posts() ) {
    	    
    		while ( $products->have_posts() ) : $products->the_post();
    		
    			wc_get_template_part( 'content', 'product' );
    			
    		endwhile;
    		
    	} 
    	
    	wp_reset_postdata();
        wp_die();
	    
	}
	
	/**
	 * Get products by creating a custom query
	 * 
	 * @since    1.0.0
	 */
	public function get_products( $query_vars ) {
    	return new WP_Query( array(
    		'post_type'      => 'product',
    		'status'         => 'publish',
    		's'              => $query_vars['s'],
    		'paged'          => $query_vars['current_page'],
    		'posts_per_page' => $query_vars['posts_per_page']
    	)); 
	}

}
