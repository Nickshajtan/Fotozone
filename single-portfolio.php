<?php
/**
 * The template for displaying portfolio single posts
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

while ( have_posts() ) : the_post(); 

$title    = wp_kses_post( get_the_title() ); 
$content  = wp_kses_post( get_the_content() ); 
$preview  = wp_kses_post( get_the_post_thumbnail( $post->ID, 'full', array('class' => 'img-inner') ) );
$prev_url = esc_url( get_the_post_thumbnail_url() );
$caption  = wp_kses_post( get_the_post_thumbnail_caption() );
if( $preview ){
    $modal = aq_resize( $prev_url, 800, 800, true, true, true);
}
$gallery = get_field('fotos'); ?>

<section class="white-bg light-theme">
    <div class="container">
        <div class="row">
            <?php if( $title ) : ?>
            <div class="col-12 justify-content-center align-items-center d-flex flex-column">
                <div class="section-header">
                    <h1 class="text-center"><?php echo $title; ?></h1>
                </div>
            </div>
            <?php endif; ?>
            <?php if( $content ) : ?>
            <div class="col-12 text-center">  
                <?php echo $content; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if( $gallery || $preview ) : ?>
    <ul class="grid-container grid-column-4">
        <?php if( $preview ) : ?>
            <li>
                    <a href="<?php echo ( $modal ) ? esc_attr( $modal ) : '#'; ?>" data-fancybox="portfolio" class="fancybox">
                         <?php echo $preview; ?>
                    </a>
                    <?php if( $caption ) : ?>
                        <p class="text-center w-100"><?php echo $caption; ?></p>
                    <?php endif; ?>
            </li>
        <?php endif; ?>
        <?php if( $gallery ) : 
              foreach( $gallery as $image ): ?>
                  <?php if( $image ) : 
                  $caption = esc_html($image['caption']); ?>
                  <li>
                    <a href="<?php echo esc_url($image['sizes']['large']); ?>" data-fancybox="portfolio" class="fancybox d-flex flex-column">
                         <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" title="<?php echo esc_attr( $image['title'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"  class="img-inner"/>
                         <?php if( $caption ) : ?>
                             <p class="text-center w-100"><?php echo $caption; ?></p>
                         <?php endif; ?>
                    </a>
                  </li>
                  <?php endif; ?>
              <?php endforeach; 
        endif; ?>
    </ul>
    <?php endif; ?>
</section>

<?php endwhile;
if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) :
                            get_template_part('template-parts/form', 'cf');
       else :
                            get_template_part('template-parts/form', 'custom');
       endif; 
get_footer(); ?>
