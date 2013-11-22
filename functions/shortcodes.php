<?php


/* replace gallery shortcode
remove_shortcode('gallery');
add_shortcode('gallery', 'get_attached_images');
-------------------------------------------------------------- */



/* Get all attached images
function get_attached_images( $atts, $content = null ){

	extract(shortcode_atts(array(
		'posts'			=> -1,
		'size' 			=> 'large',
		'link'			=> false
	), $atts));

	$args = array(
		'post_type' 	=> 'attachment',
		'numberposts' 	=> $posts,
		'post_status' 	=> null,
		'post_parent' 	=> get_the_id(),
		'orderby' 		=> 'menu_order',
		'order'			=> 'ASC'
	);
	
	$attachments = get_posts( $args );
	if ( $attachments ) :
		$out = '<div class="attached-images">';	
		foreach ( $attachments as $attachment ) :
		
			$item 		= wp_get_attachment_image( $attachment->ID, $size );
			$large 		= wp_get_attachment_image_src( $attachment->ID, 'full' );
			$largesrc	= $large[0];
			$title		= apply_filters( 'the_title', $attachment->post_title );
			$desc		= apply_filters( 'the_title', $attachment->post_content );
			$capt	= apply_filters( 'the_title', $attachment->post_excerpt );
						
			$out .= '<div class="item item-'.$size.'">';
			if ( $link ) $out .= '<a href="'.$largesrc.'" class="thickbox thumb" rel="lightbox-gallery" title="'.$title.'">';
			$out .= $item;
			if ( $link ) $out .= '</a>';
			$out .= '<h3 class="entry-title">'.$title.'</h3>';
			if ( $capt ) $out .= '<p class="caption">'.$capt.'</p>';
			if ( $desc ) $out .= '<p class="descripton">'.$desc.'</p>';
			$out .= '</div>' . "\n";
			
		endforeach;
		$out .= '</div><!-- thumbnails -->';
	endif;
	return $out;
}
-------------------------------------------------------------- */



/* portfolio posts loop
-----------------------------------------------------------------------------------*/
function shortcode_get_thumbnail_posts( $atts, $content = null ) {

	global $post;

	extract(shortcode_atts(array(
		'posts'		=> -1,
		'size' 		=> 'thumbnail',
		'category'	=> '',
		'type'		=> 'portfolio',
		'sort'		=> 'menu_order date',
		'order'		=> 'DESC'
	), $atts));

    query_posts(array(
        'post_type' 			=> $type,
        'posts_per_page' 		=> $posts,
        'portfolio-category'	=> $category,
        'orderby'				=> $sort,
        'order'					=> $order
	));
    	
	if ( have_posts() ) : 
		$out = '<div class="post-gallery grid mobile four">';	
		while ( have_posts() ) : the_post();
	    
	    	$class	= 'item item-' . $size;
	    	$link	= get_permalink($post->ID);
	    	$title	= get_the_title($post->ID);
		    $thumb	= get_the_post_thumbnail($post->ID, $size);
	
			$out .= "\n\t";
		    $out .= '<div class="'.$class.'"><a href="'.$link.'">';
		    $out .= '<figure>'.$thumb.'</thumb>';
		    $out .= '<article><h5 class="entry-title">'.$title.'</h5></article>';
		    $out .= '</a></div>' . "\n";
		
	    endwhile;
		$out .= '</div><!-- grid -->' . "\n";
	endif;
	
	wp_reset_query();
	return $out;
}
add_shortcode( 'get_portfolio', 'shortcode_get_thumbnail_posts' );



/* blog posts loop
-----------------------------------------------------------------------------------*/
function shortcode_get_excerpt_posts( $atts, $content = null ) {

	global $post;

	extract(shortcode_atts(array(
		'posts'		=> -1,
		'category'	=> '',
		'type'		=> 'post'
	), $atts));

    query_posts(array(
        'post_type' 		=> $type,
        'posts_per_page' 	=> $posts,
        'category_name' 	=> $category
    ));
    	
	if ( have_posts() ) : 
		$out = '<div class="loop-content loop-' . $type . ' clear">';	
		while ( have_posts() ) : the_post();
	    
	    	$class		= 'item item-excerpt';
	    	$link		= get_permalink($post->ID);
	    	$title		= get_the_title($post->ID);
	    	$content 	= get_the_excerpt($post->ID);
	
			$out .= "\n\t";
		    $out .= '<div class="'.$class.'">';
		    $out .= '<h4 class="entry-title"><a href="'.$link.'">'.$title.'</a></h4>';
		    $out .= '<div class="entry-content">' . $content . '</div>';
		    $out .= '</div>' . "\n";
		
	    endwhile;
		$out .= '</div><!-- blog -->' . "\n";
	endif;
	
	wp_reset_query();
	return $out;
}
add_shortcode( 'get_blog', 'shortcode_get_excerpt_posts' );




?>