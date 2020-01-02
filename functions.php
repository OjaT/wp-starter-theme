<?php

// Remove wp-embed 

function deregister_wp_embed(){
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'deregister_wp_embed' ); 



// Deregister the default jQuery

function reassign_jQuery() {
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-core' );
    wp_deregister_script( 'jquery-migrate' );

    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), '3.4.1', true);
    wp_add_inline_script( 'jquery', "window.jQuery || document.write('<script src=\"".get_template_directory_uri() ."/assets/jquery-3.4.1.min.js\">\\x3C/script>')");
    
    wp_enqueue_script('jquery');

}
if ( ! is_admin() )
    add_action('init', 'reassign_jQuery');


// Load scripts

function add_script() {
	$version = filemtime( get_stylesheet_directory() . '/assets/main.js');
	//wp_enqueue_script('owl', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', false, null, true);
	//wp_enqueue_script('masonry', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', false, null, true);
	//wp_enqueue_script('cookie', 'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', false, null, true);
	//wp_enqueue_script('aos', 'https://unpkg.com/aos@next/dist/aos.js', false, null, true);
	//wp_enqueue_script('scroll', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.js', false, null, true);
	//wp_enqueue_script('vivus', 'https://cdn.jsdelivr.net/npm/vivus@latest/dist/vivus.min.js', false, null, true);
	wp_enqueue_script('main', get_template_directory_uri() . '/assets/main.js', false, $version, true);
	//wp_localize_script( 'main', 'ajax_url', admin_url('admin-ajax.php') );
}

add_action( 'wp_enqueue_scripts', 'add_script' );



// Load css

function add_css() {
	$version = filemtime( get_stylesheet_directory() . '/assets/style.css');
	wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/style.css', false, $version, 'all');
	//wp_enqueue_style('owl', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', false, null, all);
	//wp_enqueue_style( 'libaries', get_template_directory_uri() . '/assets/libaries.css.min.css', false, null, all);
	
}
add_action( 'wp_enqueue_scripts', 'add_css');



// Clean up the <head>

function remove_tags () {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 ); 
	remove_action( 'wp_head', 'rsd_link' ); 
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' ); 
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action( 'wp_head', 'wp_generator' ); 
	remove_action( 'wp_head', 'rel_canonical');
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action('after_setup_theme', 'remove_tags');



// Remove regular dashboard widgets

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
 
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    remove_action( 'welcome_panel', 'wp_welcome_panel' );
 
}
 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );



// Remove some admin bar menu items

function dashboard_tweaks() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('view-site');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('search');   
}
add_action( 'wp_before_admin_bar_render', 'dashboard_tweaks' );



// Custom dashboard

add_action('wp_dashboard_setup', 'custom_dashboard');
  
function custom_dashboard() {

	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'Pages', 'dashboard_pages');

}
 
function dashboard_pages() {
	edit_post_link();
	$post_url = admin_url( 'post.php?post=' . $post_id ) . '&action=edit';

	$pages = get_pages(); 
	foreach ($pages as $page) {
	    $page_id = $page->ID;
	    $page_title = $page->post_title;
	    $post_url = admin_url( 'post.php?post=' . $page_id ) . '&action=edit';
	    echo "<a href=".$post_url.">".$page_title."</a><br>";
	}
}



// Add meta tags ( acf fields / options page )

function addMeta() {
	
	if( class_exists('acf') ) {

	$meta_description = get_field('meta_description', 'option');
	$meta_keywords = get_field('meta_keywords', 'option');
	$meta_author = get_field('meta_author', 'option');
	$meta_og_image = get_field('meta_og_img', 'option');
	$meta_img_full = $meta_og_image['url'];

	}

	if ( $meta_description ) {
		echo '<meta name="description" content="'.$meta_description.'">'; 
	}

	if ( $meta_keywords ) {
		echo '<meta name="keywords" content="'.$meta_keywords.'">'; 
	}

	if ( $meta_author ) {
		echo '<meta name="author" content="'.$meta_author.'">'; 
	}

	if ( $meta_og_image ) {
		echo '<meta name="twitter:card" content="summary" />';
		echo '<meta property="og:image" content="'.$meta_img_full.'" />';
	}

}

add_action('meta', 'addMeta');


// Add GA ( acf fields / options page )

function addGA() {
	
	if( class_exists('acf') ) {
		$acode = get_field('analytics_code', 'option');
	}

	if ( $acode ) {
		echo $acode; 
	}
	
}

add_action('analytics', 'addGA');



//Remove comments in its entirety

// From admin menu
add_action( 'admin_menu', 'pk_remove_admin_menus' );
function pk_remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}

// From post and pages
add_action('init', 'pk_remove_comment_support', 100);
function pk_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

// From admin bar
add_action( 'wp_before_admin_bar_render', 'pk_remove_comments_admin_bar' );
function pk_remove_comments_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}



// Register menus

function register_menus() {
	register_nav_menus(
		array(
			'main-menu' => 'Main Menu',
		)
	);
}
add_action( 'init', 'register_menus' );



// Featured image

add_theme_support( 'post-thumbnails' );
	


// Use standard editor

// disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);

// disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );

// remove block libary css

function remove_block_css() {
    wp_dequeue_style( 'wp-block-library' ); // Wordpress core
}



// Body ID-s

function dynamicBodyID() {

	if ( is_front_page() ) {
		echo 'class="home"';
	} 

	else if ( is_page() ) {
		echo 'class="page"';	
	}

	else if ( is_single() ) {
		echo 'class="single"';
	}

	else if ( is_page('otsing') ) {
		echo 'class="search"';
	}  

	else if ( is_post_type_archive() ) {
		echo 'class="post-type-archive"';
	}

	else if ( is_archive() ) {
		echo 'class="archive"';
	}


}



// Title-tag

function theme_slug_setup() {

	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );



// Add the options page

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}



// Image sizes

add_action( 'after_setup_theme', 'custom_sizes' );
function custom_sizes() {

    //add_image_size( 'slider', 1920, 778, true);

}



// No compression on images

add_filter('jpeg_quality', function($arg){return 100;});


?>