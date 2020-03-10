<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

get_header();
$your_query = new WP_Query( 'pagename=error-404' );
if( $your_query->have_posts() ) : 
    while ( $your_query->have_posts() ) : $your_query->the_post(); 
        $title = get_the_title();
        $content = get_the_content();
    ?>
    <div class="error-page">
        <section class="site-addon light-theme white-bg">
            <div class="container">
                <div class="row">
                   <?php if( $title ) : ?>
                    <div class="col-12 justify-content-start align-items-center d-flex">
                        <div class="section-header">
                           <h1 class="text-left"><?php echo $title; ?></h1>  
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-12 col-md-6 content-wrapper">
                        <div class="content"><?php echo ( $content ) ? $content : __('Упс, такой страницы не существует!', 'hcc'); ?></div>
                        <div class="link-wrapper justify-content-start align-items-center d-flex">
                            <a href="<?php echo ( THEME_HOME_URL ) ? THEME_HOME_URL : get_home_url('/'); ?>" class="button"><?php echo __('Вернуться на главную','hcc'); ?></a>
                        </div>
                    </div>
                    <?php if( has_post_thumbnail() ) : ?>
                        <div class="col-12 col-md-6 thumbnail-wrapper">
                            <?php the_post_thumbnail('full') ; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>  
    </div>  
    <?php endwhile; 
wp_reset_postdata();
endif;    
get_footer(); ?>
