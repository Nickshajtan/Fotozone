<?php
/**
 * The template for displaying category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if ( have_posts() ) :

	get_template_part( 'template-parts/loop', 'archive' );


else :

	get_template_part( 'template-parts/content', 'none' );

endif;
get_sidebar();
get_footer();
