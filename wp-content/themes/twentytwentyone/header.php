<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqsKEglBEK_zLg41RA4XMTHWXoIsT0_MI&callback=initMap&libraries=&v=weekly" async ></script>
   -->
   <script type="text/javascript" src="google_dynamic_map.js"></script>
    <script src="https://unpkg.com/@googlemaps/js-api-loader@^1.2.0/dist/index.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> onload="initialize();">
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'twentytwentyone' ); ?></a>

	<?php get_template_part( 'template-parts/header/site-header' ); ?>

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
