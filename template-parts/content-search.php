<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hcc
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<p><?php the_post_thumbnail(); ?></p>
	<p>Published: <em><?php echo get_the_date(); ?></em></p>
	<p>Author: <em><?php the_author_meta('display_name'); ?></em></p>
	<p>Views: <em><?php echo ccz_getPostViews(get_the_ID()); ?></em></p>
	<p>Category: <em><?php the_category(','); ?></em></p>
	<h1><?php the_title(); ?></h1>
	<p><?php the_content() ?></p>
</article><!-- #post-<?php the_ID(); ?> -->
