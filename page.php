<?php get_header(); ?>

<!-- page.php -->

<?php 

if ( has_post_thumbnail() ) get_template_part( 'inc/feature' );
	
get_template_part( 'inc/content', 'singular' ); 

?>

<?php get_footer(); ?>
