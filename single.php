<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
// set post views
if( function_exists('hcc_setPostViews') ){
    hcc_setPostViews($post->ID);   
}
get_header();
?>
<?php
while ( have_posts() ) :
	the_post();
	?>

	<p><?php the_post_thumbnail(); ?></p>
	<p>Published: <em><?php echo get_the_date(); ?></em></p>
	<p>Author: <em><?php the_author_meta('display_name'); ?></em></p>
	<p>Views: <em><?php if( function_exists('hcc_getPostViews') ) : echo hcc_getPostViews(get_the_ID()); endif; ?></em></p>
	<p>Category: <em><?php the_category(','); ?></em></p>
	<h1><?php the_title(); ?></h1>
	<p><?php the_content() ?></p>

	<?php
endwhile; 
?>

<?php
get_sidebar();
get_footer();
