<?php

/* This theme uses wp_nav_menu() in one location.
-------------------------------------------------------------- */
register_nav_menu( 'primary', __( 'Primary', 'framework' ) );



/* Load support files 
-------------------------------------------------------------- */
require 'functions/customizer.php';
require 'functions/bean-portfolios/bean-portfolios.php';
require 'functions/shortcodes.php';
//require 'functions/meta_box_framework.php';



/* Register Theme Features 
-------------------------------------------------------------- */
function custom_theme_features()  {

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'image','gallery' ) );
	add_editor_style ( 'css/typography.css' );

}
add_action( 'after_setup_theme', 'custom_theme_features' );



/* Images 
-------------------------------------------------------------- */
update_option('thumbnail_size_w', 280);
update_option('thumbnail_size_h', 280);
update_option('medium_size_w', 600);
update_option('medium_size_h', 800);
update_option('large_size_w', 1200);
update_option('large_size_h', 1200);

update_option('image_default_align', 'none' );
update_option('image_default_link_type', 'none' );
update_option('image_default_size', 'medium' );

if ( ! isset( $content_width ) ) $content_width = 1200;



/* Register sidebars
-------------------------------------------------------------- */
register_sidebar(array(
	'name' 			=> 'Sidebar Widgets',
	'id'  			=> 'sidebar',
	'description'   => 'These are widgets for all sidebars.',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div><!-- end widget -->',
	'before_title'  => '<h3>',
	'after_title'   => '</h3>'
));




/* Register javascript and stylesheets
-------------------------------------------------------------- */
if (!function_exists('theme_scripts')) : function theme_scripts() {


	// Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	if ( is_singular() && comments_open() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' );
	
	
	// Styles
	wp_enqueue_style( 'norm', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'base', get_template_directory_uri() . '/css/base.css' );
	wp_enqueue_style( 'type', get_template_directory_uri() . '/css/typography.css' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css' );


} endif;
add_action('wp_enqueue_scripts', 'theme_scripts', 5);




/* Register javascript for galleries
-------------------------------------------------------------- */
if (!function_exists('gallery_scripts')) : function gallery_scripts() {

	global $post;
	
	if ( is_singular() && has_shortcode( $post->post_content, 'gallery' ) ) {
		
		// magnific lightbox
		wp_enqueue_script( 'magnific-js', get_template_directory_uri() . '/js/magnific/magnific.js', array('jquery') );
		wp_enqueue_style( 'magnific', get_template_directory_uri() . '/js/magnific/magnific.css' );
		
	}
	
	if ( is_singular() && has_shortcode( $post->post_content, 'gallery' ) ) {
		
		// owl carousel
		wp_enqueue_script( 'owl-js', get_template_directory_uri() . '/js/owl/owl.carousel.min.js', array('jquery') );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/js/owl/owl.carousel.css' );
		wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/js/owl/owl.theme.css' );
		
	}

} endif;
add_action('wp_enqueue_scripts', 'gallery_scripts');




/* remove junk from head
-------------------------------------------------------------- */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );




/* Custom User Contact Info
-------------------------------------------------------------- */
function extra_contact_info($contactmethods) {
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['linkedin'] = 'LinkedIn';
	return $contactmethods;
}
add_filter('user_contactmethods', 'extra_contact_info');




/* meta box stuff
-------------------------------------------------------------- */
function add_custom_meta_boxes() {
	$meta_box = array(
		'id'		=> 'post_meta_box', // Meta box ID
		'title'		=> 'Additional information', // Meta box title
		'pages'		=> array( 'post', 'page', 'portfolio' ), // Post types this meta box should be shown on
		'context'	=> 'normal', // Meta box context
		'priority'	=> 'high', // Meta box priority
		'fields'	=> array(

			array(
				'label'	=> 'Title Additional Info',
				'desc'	=> 'An additional text block in the title area.',
				'id'	=> 'cram_title_info',
				'type'	=> 'text'
			),
			array(
				'label'	=> 'Post Additional Info',
				'desc'	=> 'Further information to be highlighted.',
				'id'	=> 'cram_post_info',
				'type'	=> 'textarea'
			),
			array(
				'label'	=> 'Show widget bar',
				'desc'	=> 'Show widgets',
				'id'	=> 'cram_show_widgets',
				'type'	=> 'checkbox',
				'std'	=> 0
			)

		)
	);
	dev7_add_meta_box( $meta_box );
}
add_action( 'dev7_meta_boxes', 'add_custom_meta_boxes' );


// simple way to return the value
function cram_meta( $key = "" ) {

	//$meta = get_post_custom();
	//if( isset($meta[$key]) ) return $meta[ $key ][0];
	return get_post_meta( get_the_ID(), $key, true );

}


/* The End - thanks
-------------------------------------------------------------- */
?>