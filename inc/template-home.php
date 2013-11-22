<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>



<!-- home -->



<header id="feature">
<div class="row">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class() ?>>
		
		<?php 
		if ( has_shortcode( $post->post_content, 'gallery' ) ) :
		
			get_template_part( 'inc/feature', 'image' );
			
		elseif ( has_post_thumbnail() ) : 
		
			get_template_part( 'inc/feature' );
		
		endif;
		?>
		
		<div class="entry-content"><?php //the_content(); ?></div>

	</div><!-- post -->
	
<?php endwhile; endif; ?>

</div><!-- row -->
</header><!-- feature -->


<?php get_template_part( 'inc/template', 'home-updates' ); ?>


<?php get_footer(); ?>