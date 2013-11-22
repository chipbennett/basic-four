<?php get_header(); ?>

<!-- single-portfolio.php -->

<?php 

if ( has_post_format( 'gallery' ) and has_shortcode( $post->post_content, 'gallery' ) ) : 

	get_template_part( 'inc/feature', 'gallery' );
	
elseif ( has_post_format( 'image' ) and has_shortcode( $post->post_content, 'gallery' ) ) :

	get_template_part( 'inc/feature', 'image' );
	
elseif ( has_post_thumbnail() ) : 

	get_template_part( 'inc/feature' );

endif;
	
?>

<?php get_template_part( 'inc/content', 'singular' ); ?>

<?php get_footer(); ?>
