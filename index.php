<?php get_header(); ?>

<!-- index.php -->

<div class="row">


<div class="primary">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div <?php post_class() ?>>

		<?php if (has_post_thumbnail( $post->ID )) : ?>
		<figure class="feature"><?php the_post_thumbnail( 'blog-thumb' );?></figure>
		<?php endif; ?>
		
		<article>
		
	        <header>
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		        <p class="meta time"><?php the_time('F jS Y'); ?></p>
		        <p class="meta comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments-link', ''); ?></p>
	        </header>
	
			<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->

			<?php if( has_category() ) : ?>
			<footer class="meta">
				<p class="category">Posted in <?php the_category(', ') ?></p>
			</footer>
			<?php endif; ?>
			
		</article>
		
	</div><!-- post -->

<?php endwhile; ?>

    <div class="postnav">
        <div class="next-posts"><?php next_posts_link('&larr; Older Entries') ?></div>
        <div class="prev-posts"><?php previous_posts_link('Newer Entries &rarr;') ?></div>
    </div><!-- postnav -->

<?php else : ?>

	<h2>Not Found</h2>

<?php endif; ?>
	
</div><!-- primary -->

<?php get_sidebar(); ?>

</div><!-- row -->

<?php get_footer(); ?>
