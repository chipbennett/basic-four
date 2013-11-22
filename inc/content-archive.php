<div <?php post_class( 'item' ) ?>>

	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
	<figure><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' );?></a></figure>
	<?php endif; ?>

	<article>

        <header>			
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        </header>

		<div class="entry-content">
		
			<?php 
			
			if ( is_category() || is_archive() ) :
				the_excerpt();
			else :
				the_content();
			endif; 
			
			?>
			
		</div>

		<?php if( is_single() and has_category() ) : ?>
		<footer>
			<p>Posted in <?php the_category(', ') ?></p>
		</footer>
		<?php endif; ?>
				
	</article>

</div><!-- post -->
