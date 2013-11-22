<?php
/*
Template Name: Portfolio Overview
*/
?>

<?php get_header(); ?>



<!-- Portfolio Template -->



<header class="row">
	
    <header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
    </header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

</header>

<section>
<div class="row">

	<?php echo do_shortcode('[get_portfolio]'); ?>

</div><!-- row -->
</section>



<?php get_footer(); ?>