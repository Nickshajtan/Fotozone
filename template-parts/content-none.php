<?php
/**
* Template part for displaying a message that posts cannot be found
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/
*
* @package hcc
*/

if ( is_search() ) :
	?>
    <div class="container">
        <div class="col-12 d-flex align-items-center content-none">
	        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hcc' ); ?></p>
        </div>
    </div>
	<?php 
else : 
	?>
    <div class="container">
        <div class="col-12 d-flex align-items-center content-none">
              <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hcc' ); ?></p>  
        </div>
    </div>
	<?php
endif;
