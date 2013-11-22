<?php 

global $post; 


if ( has_post_format( 'gallery' ) || is_page_template( 'inc/template-gallery.php' ) ) : 

	$gallery = get_post_gallery( $post, false );
	$ids = explode( ",", $gallery['ids'] );

	if( isset( $gallery['columns'] ) ) {
	
		switch( $gallery['columns'] ) {
			
			case "1":
				$class = "grid one";
				break;
				
			case "2":
				$class = "grid two";
				break;
			
			case "3":
				$class = "grid three";
				break;
			
			case "4":
				$class = "grid four";
				break;
				
			case "5":
				$class = "grid five";
				break;
				
			default:
				$class = "grid three";
			
		}
		
	} else {
	
		$class = "grid three";
		
	}
			
?>

<header>
<div class="row">

	<div class="lightbox gallery mobile <?php echo $class; ?>">
	<?php 
		
		foreach( $ids as $id ) {
			$link = wp_get_attachment_url( $id );
			$img  = wp_get_attachment_image( $id, "thumbnail");
			$ttl  = get_the_title( $id );
			$cap  = get_post($id)->post_excerpt;

			echo( "<div class='item'><a href='$link' data-lightbox-gallery='feature' title='$cap'>" . $img . "</a></div>" );
		} 
		
		add_filter( 'the_content', 'remove_first_gallery' );
		function remove_first_gallery( $content ) {
			$content = preg_replace( '/\[gallery.*?\]/', '', $content, 1 );
			return $content;
		}
				
	?>
	</div><!-- grid -->
	
</div>
</header>
	
<?php endif; ?>
