<?php
/**
 * Theme functions and definitions
 *
 * @package Corporate_SPA
 */

if ( ! function_exists( 'corporatespa_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function corporatespa_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Corporate SPA, use a find and replace
	 * to change 'corporatespa' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'corporatespa', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'corporatespa-portfolio-featured-image', 800, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top-menu' => esc_html__( 'Top Menu', 'corporatespa' ),
		'social'  => __( 'Social Links Menu', 'corporatespa' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'corporatespa_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // corporatespa_setup
add_action( 'after_setup_theme', 'corporatespa_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function corporatespa_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'corporatespa_content_width', 640 );
}
add_action( 'after_setup_theme', 'corporatespa_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function corporatespa_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'corporatespa' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'corporatespa_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function corporatespa_scripts() {

	wp_enqueue_style( 'angular-material-style', 'https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.5/angular-material.min.css', '1.0');

	wp_enqueue_style( 'corporatespa-style', get_stylesheet_uri() );

	wp_enqueue_script( 'corporatespa-customizer', get_stylesheet_directory_uri() . '/assets/js/customizer.js', array($this, 'jquery'), '1.0', true);

	wp_enqueue_script( 'angular-core', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.min.js' , '1.0', false);

	wp_enqueue_script( 'angular-animate', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-animate.min.js', true);

	wp_enqueue_script( 'angular-aria', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-aria.js', true);

	wp_enqueue_script( 'angular-material', 'https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.5/angular-material.min.js', array('angular-core', 'angular-animate', 'angular-aria'), true);

	wp_enqueue_script( 'angular-ui-router', 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.18/angular-ui-router.min.js', array('angular-core'), '1.0', false );

	wp_enqueue_script( 'angular-resource', 'https://cdnjs.cloudflare.com/ajax/libs/angular-resource/1.5.0/angular-resource.min.js', array('angular-core'), '1.0', false );

	wp_enqueue_script( 'ngScripts', get_template_directory_uri() . '/assets/js/min/script.js', array('jquery', 'angular-core', 'angular-ui-router'), '1.0', true );

	wp_localize_script('ngScripts', 'appInfo',
		array(

			'api_url'				=> rest_get_url_prefix(),
			'template_directory'	=> get_template_directory_uri() . '/assets/js/angular_app/',
			'nonce'					=> wp_create_nonce( 'wp_rest' ),
			'is_admin'				=> current_user_can('administrator')

		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'corporatespa_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom post types: Services and Portfolio
 */

// Register Custom Post Type: Services
function cpt_services() {

	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'corporatespa' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'corporatespa' ),
		'menu_name'             => __( 'Services', 'corporatespa' ),
		'name_admin_bar'        => __( 'Services', 'corporatespa' ),
		'archives'              => __( 'Service Archives', 'corporatespa' ),
		'parent_item_colon'     => __( 'Parent Service:', 'corporatespa' ),
		'all_items'             => __( 'All Services', 'corporatespa' ),
		'add_new_item'          => __( 'Add New Service', 'corporatespa' ),
		'add_new'               => __( 'Add New', 'corporatespa' ),
		'new_item'              => __( 'New Service', 'corporatespa' ),
		'edit_item'             => __( 'Edit Service', 'corporatespa' ),
		'update_item'           => __( 'Update Service', 'corporatespa' ),
		'view_item'             => __( 'View Service', 'corporatespa' ),
		'search_items'          => __( 'Search Service', 'corporatespa' ),
		'not_found'             => __( 'Not found', 'corporatespa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'corporatespa' ),
		'featured_image'        => __( 'Featured Image', 'corporatespa' ),
		'set_featured_image'    => __( 'Set featured image', 'corporatespa' ),
		'remove_featured_image' => __( 'Remove featured image', 'corporatespa' ),
		'use_featured_image'    => __( 'Use as featured image', 'corporatespa' ),
		'insert_into_item'      => __( 'Insert into service', 'corporatespa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this service', 'corporatespa' ),
		'items_list'            => __( 'Services list', 'corporatespa' ),
		'items_list_navigation' => __( 'Services list navigation', 'corporatespa' ),
		'filter_items_list'     => __( 'Filter services list', 'corporatespa' ),
	);
	$args = array(
		'label'                 => __( 'Services', 'corporatespa' ),
		'description'           => __( 'Services offered by the company, to be displayed after the Intro Section.', 'corporatespa' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 0,
		'menu_icon'				=> 'dashicons-list-view',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'services', $args );

}
add_action( 'init', 'cpt_services', 0 );


// Register Custom Post Type: Portfolio
function cpt_portfolio() {

	$labels = array(
		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'corporatespa' ),
		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'corporatespa' ),
		'menu_name'             => __( 'Portfolio', 'corporatespa' ),
		'name_admin_bar'        => __( 'Portfolio', 'corporatespa' ),
		'archives'              => __( 'Portfolio Archives', 'corporatespa' ),
		'parent_item_colon'     => __( 'Parent project:', 'corporatespa' ),
		'all_items'             => __( 'All Projects', 'corporatespa' ),
		'add_new_item'          => __( 'Add New Project', 'corporatespa' ),
		'add_new'               => __( 'Add New Project', 'corporatespa' ),
		'new_item'              => __( 'New Project', 'corporatespa' ),
		'edit_item'             => __( 'Edit Project', 'corporatespa' ),
		'update_item'           => __( 'Update Project', 'corporatespa' ),
		'view_item'             => __( 'View Project', 'corporatespa' ),
		'search_items'          => __( 'Search Projects', 'corporatespa' ),
		'not_found'             => __( 'Not found', 'corporatespa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'corporatespa' ),
		'featured_image'        => __( 'Featured Image', 'corporatespa' ),
		'set_featured_image'    => __( 'Set featured image', 'corporatespa' ),
		'remove_featured_image' => __( 'Remove featured image', 'corporatespa' ),
		'use_featured_image'    => __( 'Use as featured image', 'corporatespa' ),
		'insert_into_item'      => __( 'Insert into project', 'corporatespa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'corporatespa' ),
		'items_list'            => __( 'Project list', 'corporatespa' ),
		'items_list_navigation' => __( 'Project list navigation', 'corporatespa' ),
		'filter_items_list'     => __( 'Filter project list', 'corporatespa' ),
	);
	$args = array(
		'label'                 => __( 'Portfolio', 'corporatespa' ),
		'description'           => __( 'Project portfolio, to be displayed after the Services section.', 'corporatespa' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'				=> 'dashicons-layout',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'cpt_portfolio', 0 );
