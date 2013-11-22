/* Custom
-------------------------------------------------------------- */

jQuery(document).ready(function($){

    // Toggle stuff
    $('.toggle').click( function(e){
    	$(this).toggleClass('open');
        $(this).next('.toggle-this').toggleClass('open');
        e.preventDefault();
    });
    
    
    // init magnific lightboxes
	$('.lightbox .item a').magnificPopup({ 
		type: 'image',
		gallery: {
			// options for gallery
			enabled: true,
			preload: [0,2]
		},
	});
	
	$('.gallery-item a').magnificPopup({ 
		type: 'image',
		gallery: {
			// options for gallery
			enabled: true,
			preload: [0,2]
		},
	});
	
	
	$(".owl-carousel").owlCarousel({

		navigation : true, // Show next and prev buttons

		slideSpeed : 300,
		paginationSpeed : 400,

		items : 1, 
		itemsDesktop : false,
		itemsDesktopSmall : false,
		itemsTablet: false,
		itemsMobile : false

	});

    
});

/* -------------------------------------------------------------- */


