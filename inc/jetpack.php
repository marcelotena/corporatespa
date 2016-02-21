<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Corporate_SPA
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function corporatespa_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'corporatespa_infinite_scroll_render',
		'footer'    => 'page',
	) );

	/**
	 * Add theme support for Portfolio Custom Post Type.
	 */
	add_theme_support( 'jetpack-portfolio' );

} // end function corporatespa_jetpack_setup
add_action( 'after_setup_theme', 'corporatespa_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function corporatespa_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function corporatespa_infinite_scroll_render


/**
 * Add support for the Site Logo
 */
function corporatespa_site_logo_init() {
	add_image_size( 'component-s-logo', 200, 200 );
	add_theme_support( 'site-logo', array( 'size' => 'component-s-logo' ) );
}
add_action( 'after_setup_theme', 'corporatespa_site_logo_init' );

/**
 * Return early if Site Logo is not available.
 */
function corporatespa_the_site_logo() {
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		return;
	} else {
		jetpack_the_site_logo();
	}
}

/**
* Add theme support for Responsive Videos.
*/
add_theme_support( 'jetpack-responsive-videos' );
