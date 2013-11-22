<?php if( is_active_sidebar('sidebar') ) : ?>
	
<footer class="secondary widget-area">
	<div class="row">
		<div class="grid three">
		<?php dynamic_sidebar('sidebar'); ?>
		</div><!-- grid -->
	</div><!-- row -->
</footer>

<?php endif; ?>