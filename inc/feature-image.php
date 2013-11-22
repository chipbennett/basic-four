<?php 

global $post; 

$gallery = get_post_gallery( $post, false );
$ids = explode( ",", $gallery['ids'] );
	
?>

<header>
<div class="row">

	<div class="carousel owl-carousel">
	<?php 
		
		foreach( $ids as $id ) {
			$src  = wp_get_attachment_image_src( $id, "large" );
			$img  = wp_get_attachment_image( $id, "large");
			$ttl  = get_the_title( $id );
			$cap  = get_post($id)->post_excerpt;
			
			echo( "<div class='item'><img src='$src[0]' alt='$cap' /></div>" );
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