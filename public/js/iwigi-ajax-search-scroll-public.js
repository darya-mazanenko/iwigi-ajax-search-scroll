(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */
	 
	var container   = $('ul.products').find('li:last-of-type'), // specific for Storefront theme
        canBeLoaded = true,
        bottomOffset = 2000; // flag to check if ajax is running
    
    $(window).scroll(function(){
        
       if($(document).scrollTop() > ($(document).height() - bottomOffset) && canBeLoaded){
           
           $.ajax({
                type: 'POST', 
                url: iwigi_ajax_admin.ajaxurl,
                data: {
                    action: 'get_search',
                    query_vars: iwigi_ajax_admin.query_vars,
                    current_page: iwigi_ajax_admin.current_page,
                    max_pages: iwigi_ajax_admin.max_pages,
                    posts_per_page: iwigi_ajax_admin.posts_per_page,
                    _ajax_nonce: iwigi_ajax_admin.nonce
                },
                beforeSend: function(xhr){
                    canBeLoaded = false;
                },
                success: function(data){
                    
                    container.after(data);
                    iwigi_ajax_admin.current_page++;
                    canBeLoaded = iwigi_ajax_admin.current_page < iwigi_ajax_admin.max_pages ? true : false;
     
                    console.log(iwigi_ajax_admin.current_page);
                }
            });
       } // document scroll end
       
    }); // window scroll end
})( jQuery );
