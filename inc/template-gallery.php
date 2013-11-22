<?php 
// Template Name: Gallery Page
?>

<?php get_header(); ?>

<!-- template-gallery.php -->

<?php if ( has_shortcode( $post->post_content, 'gallery' ) ) get_template_part( 'inc/content', 'gallery' ); ?>

<?php get_template_part( 'inc/content', 'singular' ); ?>

<?php get_footer(); ?>