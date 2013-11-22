<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>



<!-- fullwidth -->



<div class="primary">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div <?php post_class() ?>>
		
		<?php if (has_post_thumbnail( $post->ID )) : ?>
		<div class="feature"><?php the_post_thumbnail('large');?></div><!-- feature -->
		<?php endif; ?>

        <div class="entry-header">

			<h2 class="entry-title"><?php the_title(); ?></h2>
	
        </div>
		
		<div class="entry-content"><?php the_content(); ?></div>

	</div><!-- post -->
	
<?php endwhile; endif; ?>
	
</div><!-- primary -->

<?php get_footer(); ?>