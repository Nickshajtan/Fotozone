<?php
 /*
  * Template name: Home page
  * 
  */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
global $post;

if(have_posts()) : while(have_posts()) : the_post();
         
          $content = get_the_content();
          $content = apply_filters( 'the_content', $content );

          if ( !empty( $content ) ) :
                  echo $content; 
                  if( is_front_page() ) : 
                        if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) :
                            get_template_part('template-parts/form', 'cf');
                        else :
                            get_template_part('template-parts/form', 'custom');
                        endif; 
                  endif;
          else : 
                get_template_part('template-parts/content', 'none');
          endif;

endwhile; endif; 
get_footer(); ?>