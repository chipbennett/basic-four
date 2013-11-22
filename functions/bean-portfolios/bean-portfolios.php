<?php

/*
Plugin Name: Bean Portfolios
Plugin URI: http://www.themebeans.com
Description: Enables a portfolio post type for use in our Bean WordPress Themes 
Version: 1.1
Author: ThemeBeans
Author URI: http://www.themebeans.com
*/

if ( ! class_exists( 'Bean_Portfolio_Post_Type' ) ) :

class Bean_Portfolio_Post_Type {
	
	function __construct() {
	
		// PLUGIN ACTIVATION
		register_activation_hook( __FILE__, array( &$this, 'plugin_activation' ) );
		
		// PORTFOLIO THUMBNAILS
		add_theme_support( 'post-thumbnails', array( 'portfolio' ) );
		
		add_action( 'init', array( &$this, 'portfolio_init' ) );
		add_action( 'manage_posts_custom_column', array( &$this, 'display_thumbnail' ), 10, 1 );
		add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters' ) );
		add_action( 'right_now_content_table_end', array( &$this, 'add_portfolio_counts' ) );
		add_action( 'admin_menu', array( &$this, 'bean_create_portfolio_sort_page') );
		add_action( 'wp_ajax_portfolio_sort', array( &$this, 'bean_save_portfolio_sorted_order' ) );
		add_filter( 'manage_edit-portfolio_columns', array( &$this, 'add_thumbnail_column'), 10, 1 );			
	}
	
	
	/*--------------------------------------------------------------------*/
	/*	FLUSH REWRITE RULES
	/*--------------------------------------------------------------------*/
	function plugin_activation() {
		$this->portfolio_init();
		flush_rewrite_rules();
	}
	
	function portfolio_init() {
	
		// REGISTER THE POST TYPE
		$labels = array(
			'name' 				 => __( 'Portfolio', 'bean' ),
			'singular_name' 	 => __( 'Portfolio Item', 'bean' ),
			'add_new' 			 => __( 'Add New', 'bean' ),
			'add_new_item'		 => __( 'Add New Portfolio', 'bean' ),
			'edit_item' 		 => __( 'Edit Portfolio Item', 'bean' ),
			'new_item' 			 => __( 'Add New', 'bean' ),
			'view_item' 		 => __( 'View Portfolio Item', 'bean' ),
			'search_items' 		 => __( 'Search Portfolio', 'bean' ),
			'not_found' 		 => __( 'No portfolio items found', 'bean' ),
			'not_found_in_trash' => __( 'No portfolio items found in trash', 'bean' )
		);
		
		$supports = array( 'title','editor','thumbnail','post-formats' );

		/*
		$args = array(
	    	'labels' 			=> $labels,
			'supports' 			=> $supports,
	    	'public' 			=> true,
			'capability_type' 	=> 'post',
			'rewrite' 			=> array('slug' => 'portfolio', 'with_front' => false ),
			'menu_position' 	=> 20,
			'has_archive' 		=> false
		);
		*/
		
		$args = array(
			'labels' 				=> $labels,
			'supports' 				=> $supports,
			'capability_type' 		=> 'post',
			'singular_label' 		=> __('Portfolio'),
			'public' 				=> true,
			'show_in_nav_menus'		=> false,
			'query_var'				=> true,
			'has_archive' 			=> false,
			'hierarchical' 			=> false,
			'rewrite' 				=> array('slug' => 'portfolio', 'with_front' => false ),
			'menu_position' 		=> 5,
		 );

		$args = apply_filters( 'bean_args', $args );

		register_post_type( 'portfolio', $args );
				
		
		// REGISTER CATEGORIES
	    $taxonomy_portfolio_category_labels = array(
			'name' 							=> __( 'Portfolio Categories', 'bean' ),
			'singular_name' 				=> __( 'Portfolio Category', 'bean' ),
			'search_items' 					=> __( 'Search Portfolio Categories', 'bean' ),
			'popular_items'					=> __( 'Popular Portfolio Categories', 'bean' ),
			'all_items' 					=> __( 'All Portfolio Categories', 'bean' ),
			'parent_item' 					=> __( 'Parent Portfolio Category', 'bean' ),
			'parent_item_colon' 			=> __( 'Parent Portfolio Category:', 'bean' ),
			'edit_item' 					=> __( 'Edit Portfolio Category', 'bean' ),
			'update_item' 					=> __( 'Update Portfolio Category', 'bean' ),
			'add_new_item' 					=> __( 'Add New Portfolio Category', 'bean' ),
			'new_item_name' 				=> __( 'New Portfolio Category Name', 'bean' ),
			'separate_items_with_commas' 	=> __( 'Separate portfolio categories with commas', 'bean' ),
			'add_or_remove_items' 			=> __( 'Add or remove portfolio categories', 'bean' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used portfolio categories', 'bean' ),
			'menu_name' 					=> __( 'Portfolio Categories', 'bean' ),
	    );
		
	    $taxonomy_portfolio_category_args = array(
			'labels' 			=> $taxonomy_portfolio_category_labels,
			'public' 			=> true,
			'show_in_nav_menus' => true,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'show_tagcloud'		=> true,
			'hierarchical' 		=> true,
			'rewrite' 			=> array( 'slug' => 'portfolio-category' ),
			'query_var' 		=> true
	    );
		
	    register_taxonomy( 'portfolio-category', array( 'portfolio' ), $taxonomy_portfolio_category_args );
		
	}


	/*--------------------------------------------------------------------*/
	/*	PORTFOLIO EDIT COLUMNS
	/*--------------------------------------------------------------------*/
	function add_thumbnail_column( $columns ) {
		$column_thumb = array( 'thumbnail' => __('Thumbnail','bean' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );
		return $columns;
	}
	
	function display_thumbnail( $column ) {
		global $post;
		switch ( $column ) {
			case 'thumbnail':
				echo get_the_post_thumbnail( $post->ID, array(35, 35) );
				break;
		}
	}


	/*--------------------------------------------------------------------*/
	/*	ADD TAXONOMY FILTERS TO THE ADMIN PAGE - http://pippinsplugins.com
	/*--------------------------------------------------------------------*/
	function add_taxonomy_filters() {
		global $typenow;
		
		// USE TAXONOMY NAME OR SLUG
		$taxonomies = array( 'portfolio-category' );
	 
	 	// POST TYPE FOR THE FILTER
		if ( $typenow == 'portfolio' ) {
	 
			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}
	
	
	/*--------------------------------------------------------------------*/
	/*	ADD PORTFOLIO COUNT TO "RIGHT NOW" DASHBOARD WIDGET
	/*--------------------------------------------------------------------*/
	function add_portfolio_counts() {
	        if ( ! post_type_exists( 'portfolio' ) ) {
	             return;
	        }
	
	        $num_posts = wp_count_posts( 'portfolio' );
	        $num = number_format_i18n( $num_posts->publish );
	        $text = _n( 'Portfolio Item', 'Portfolio Items', intval($num_posts->publish) );
	        if ( current_user_can( 'edit_posts' ) ) {
	            $num = "<a href='edit.php?post_type=portfolio'>$num</a>";
	            $text = "<a href='edit.php?post_type=portfolio'>$text</a>";
	        }
	        echo '<td class="first b b-portfolio">' . $num . '</td>';
	        echo '<td class="t portfolio">' . $text . '</td>';
	        echo '</tr>';
	
	        if ($num_posts->pending > 0) {
	            $num = number_format_i18n( $num_posts->pending );
	            $text = _n( 'Portfolio Item Pending', 'Portfolio Items Pending', intval($num_posts->pending) );
	            if ( current_user_can( 'edit_posts' ) ) {
	                $num = "<a href='edit.php?post_status=pending&post_type=portfolio'>$num</a>";
	                $text = "<a href='edit.php?post_status=pending&post_type=portfolio'>$text</a>";
	            }
	            echo '<td class="first b b-portfolio">' . $num . '</td>';
	            echo '<td class="t portfolio">' . $text . '</td>';
	
	            echo '</tr>';
	        }
	}


	/*--------------------------------------------------------------------*/
	/*	PORTFOLIO SORTING
	/*--------------------------------------------------------------------*/
	function bean_create_portfolio_sort_page() {
	    $bean_sort_page = add_submenu_page('edit.php?post_type=portfolio', __('Sort Portfolios', 'bean'), __('Sort', 'bean'), 'edit_posts', basename(__FILE__), array($this, 'bean_portfolio_sort'));
	    
	    add_action('admin_print_styles-' . $bean_sort_page, array($this, 'bean_print_sort_styles')) ;
	    add_action('admin_print_scripts-' . $bean_sort_page , array($this,'bean_print_sort_scripts'));
	}
	
	//OUTPUT FOR SORTING PAGE
	function bean_portfolio_sort() {
	
	    $portfolios = new WP_Query('post_type=portfolio&posts_per_page=-1&orderby=menu_order&order=ASC'); ?>
	   
	    <div class="wrap">
	    
	        <div id="icon-tools" class="icon32"></div>
	        
	        <h2><?php _e('Sort Portfolio', 'bean'); ?></h2>
	        
	        <p><?php _e('Click, drag, re-order & repeat as necessary. The item at the top of the list will display first.', 'bean'); ?></p>
	
		        <ul id="portfolio_list" class="attachments ui-sortable">
		        
		            <?php while( $portfolios->have_posts() ) : $portfolios->the_post();
		        
		                if( get_post_status() == 'publish' ) { ?>
		        
		                    <li id="<?php the_id(); ?>" class="menu-item">
		                    
		                    	<div class="item">
		                    	
	                            	<span class="thumb"><?php the_post_thumbnail( array( 50, 50 ) );?></span>
	        
	                                <span class="title"><?php the_title(); ?></span>
		        		        
		                    	</div>
		                    		        
		                        <ul class="menu-item-transport"></ul>
		        
		                    </li><!-- END .menu-item -->
	
		            <?php } endwhile; wp_reset_postdata(); ?>
		        
		        </ul><!-- END #portfolio_list -->
	    
	    	</div><!-- END .wrap -->
	
	<?php }
	
	//ORDER
	function bean_save_portfolio_sorted_order() {
	    global $wpdb;
	    
	    $order = explode(',', $_POST['order']);
	    $counter = 0;
	    
	    foreach($order as $portfolio_id) {
	        $wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $portfolio_id));
	        $counter++;
	    }
	    die(1);
	}
	
	// SCRIPTS
	function bean_print_sort_scripts() {
	    wp_enqueue_script('jquery-ui-sortable');
	    wp_enqueue_script( 'bean_portfolio_sort', get_template_directory_uri() . '/functions/bean-portfolios/js/bean_sort.js', array('jquery') );
	}
	
	// SORTER STYLES
	function bean_print_sort_styles() {
	    wp_enqueue_style ('nav-menu');
	    wp_enqueue_style( 'bean_portfolio_sort', get_template_directory_uri() . '/functions/bean-portfolios/css/bean_sort.css' );
	}	


}

new Bean_Portfolio_Post_Type;

endif;