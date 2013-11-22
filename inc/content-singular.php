<section>
<?php while ( have_posts() ) : the_post(); ?>

	<div class="row">

		<div <?php post_class() ?>>
	
			<article>
				
			    <header>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php if ( 'portfolio' != get_post_type() && !is_page() ) :?>
			        <p class="meta time"><?php the_time('F jS Y'); ?></p>
					<?php endif; ?>
			    </header>
			
				<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
			
				<?php if( has_category() ) : ?>
				<footer class="meta">
					<p class="category">Posted in <?php the_category(', ') ?></p>
				</footer>
				<?php endif; ?>
				
			</article>
	
		</div><!-- post -->
		
	</div><!-- row -->

<?php endwhile; ?>
</section>