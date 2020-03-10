<?php
 /*
  * Template name: ACF Gutenberg template
  * 
  */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
global $post;

if(have_posts()) : while(have_posts()) : the_post();
         
          $content = get_the_content();
          $content = apply_filters( 'the_content', $content );

          if ( $content ) :
                echo $content;
          else : 
                get_template_part('template-parts/content', 'none');
          endif;

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
				comments_template();
          endif;

endwhile; endif; get_footer(); ?>