<?php get_header(); ?>

<!-- taxonomy.php -->

<header class="row">

	<?php
	$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	$slug = $term->slug;
	$name = $term->name;
	$desc = $term->description;
	?>
	
	<h2 class="entry-title"><?php echo $name; ?></h2>
	<p class="entry-content"><?php echo $desc; ?></p>

</header>

<section>
	<div class="post-gallery row">
	<div class="mobile grid four">
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'inc/portfolio-item' ); ?>
	
	<?php endwhile; endif; ?>
	
	
	</div><!-- grid -->
	</div><!-- row -->
</section>

<?php get_footer(); ?>