<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Corporate_SPA
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

	<base href="/">

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site" ng-app="corporatespaApp">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'corporatespa' ); ?></a>

	<header fill-height id="masthead" class="site-header" role="banner"
			style='background:url("<?php
				$header_image = get_header_image();

				if ( ! empty( $header_image ) ) {
					header_image();
				}
			?>"); background-size: cover;'>

		<div class="header-wrapper">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .site-branding -->
		</div><!-- .header-wrapper -->

	</header><!-- #masthead -->

	<div class="site-logo"></div>

	<nav id="site-navigation" class="main-navigation" role="navigation" ng-controller="navbarCtrl">
		<md-fab-toolbar md-open="false" count="0"
						md-direction="left">
			<md-fab-trigger class="align-with-text">
				<md-button aria-label="menu" class="md-fab md-primary">
					<md-icon md-svg-src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/menu.svg'; ?>"></md-icon>
				</md-button>
			</md-fab-trigger>
			<md-toolbar>
				<md-fab-actions class="md-toolbar-tools">
					<ul>
						<li ng-repeat="menuitem in menus" class="{{menuitem.title}}_li">
							<md-button aria-label="{{menuitem.title}}" class="md-icon-button">
								<a href="{{menuitem.url}}"><md-icon md-svg-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icons/{{menuitem.title}}.svg"></md-icon></a>
							</md-button>
						</li>
					</ul>
				</md-fab-actions>
			</md-toolbar>
		</md-fab-toolbar>
	</nav><!-- #site-navigation -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">