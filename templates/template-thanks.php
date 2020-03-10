<?php
/**
 * Template name: Thank you
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if( have_posts() ) : 
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        $content = apply_filters( 'the_content', $content );

          if ( $content ) :
                echo '<div class="thanks-page">' . $content . '</div>';
          else : 
                get_template_part('template-parts/content', 'none');
          endif; 
        
    endwhile; 
endif; 
get_footer();
