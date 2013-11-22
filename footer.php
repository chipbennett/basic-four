<?php 

if( "on" == cram_meta('cram_show_widgets') ) : 
	if( is_page() ) get_sidebar( 'page' );
	if( is_single() ) get_sidebar();
endif;

?>



</div><!-- end content -->

<?php $options = get_option('cram_options'); ?>

<div id="footer">
<div class="row">

	<h4><?php echo $options['footer_text']; ?></h4>
	
</div><!-- end row -->
</div><!-- end footer -->
      
</div><!-- end page-wrap -->



<?php wp_footer(); ?>



<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->



<?php if ( $options['include_analytics'] ) : ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-<?php echo $options['analytics_id']; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php endif; ?>


</body>
</html>