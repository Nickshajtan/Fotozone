<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hcc
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  ?>
                </main>
            </div><!-- #content -->
            
            <footer id="colophon" class="site-footer">
                <div class="container">
                    <div class="row footer-top">
                        <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-1">
                            <?php if( function_exists( 'hcc_the_custom_logo' ) ) : 
                                hcc_the_custom_logo(); 
                            endif; ?>
                            <?php if( function_exists( 'get_field' ) ) :
                                $socials = get_field('socials', 'options'); 
                                if( $socials ) : ?>
                                   <div class="socials text-left w-100">
                                    <?php foreach( $socials as $social ) : 
                                        $image = $social['icon'];
                                        $href  = esc_url( wp_kses_post( trim( $social['link'] ) ) );
                                        if( !empty( $image ) ) : ?>
                                            <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank">
                                                <img src="<?php echo esc_url( aq_resize( $image['url'], 34, 34, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" >
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                        <div class="col-12 col-lg-4 d-flex align-items-center justify-content-center order-lg-2 order-3">
                            <a href="#masthead" class="arrow to-top"></a>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 order-lg-3 order-2">
                            <?php if( function_exists( 'get_field' ) ) :
                            
                                $phones = get_field('phone_nums', 'options'); 
                                if( $phones ) : ?>
                                   <div class="w-100 text-right phones">
                                    <?php foreach( $phones as $phone ) : ?>
                                        <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                        $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                        if( !empty( $tel ) ) : ?>
                                            <a href="tel:+38<?php echo $href; ?>" class="d-flex align-items-end justify-content-end ml-auto">
                                                <span class="icon"></span><span class="body">+38 <?php echo $tel; ?></span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif;
                            
                                $emails = get_field('emails', 'options'); 
                                if( $emails ) : ?>
                                    <div class="w-100 text-right emails">
                                    <?php foreach( $emails as $email ) : ?>
                                        <?php $email = wp_kses_post( trim( $email['email'] ) ); 
                                        if( !empty( $email ) ) : ?>
                                            <a href="mailto:<?php echo $email; ?>" class="d-flex align-items-end justify-content-end ml-auto">
                                                <span class="icon"></span><span class="body"><?php echo $email; ?></span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif;
            
                                $addresses = get_field('addresses', 'options'); 
                                if( $addresses ) : ?>
                                    <div class="w-100 text-right addresses">
                                    <?php foreach( $addresses as $adres ) : ?>
                                        <?php $adress = wp_kses_post( trim( $adres['adress'] ) );
                                        $href = esc_url( wp_kses_post( trim( $adres['g_href'] ) ) ); 
                                        if( !empty( $adress ) ) : ?>
                                            <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-end justify-content-end ml-auto">
                                                <span class="icon"></span><span class="body"><?php echo $adress; ?></span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                           <?php endif; ?>
                        </div>
                    </div>
                    <div class="row footer-bottom">
                        <div class="col-12 col-md-6 d-flex justify-content-start align-items-center text-white">
                            <a href="<?php echo get_privacy_policy_url(); ?>" class="" rel="nofollow">
                                <?php if( !empty( COPYRIGHT ) ) : echo COPYRIGHT; endif; ?>
                            </a>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-end align-items-center text-white">Created by HCC</div>
                    </div>
                </div>
            </footer><!-- #colophon -->
        </div><!-- #page -->

        <!-- include modal form -->
        <?php get_template_part('template-parts/modal', 'custom'); ?>
        <!-- include custom widgets -->
        <?php get_template_part('template-parts/widgets', 'fixed'); ?>
        
        <div class="overlay"></div>
        <div id="cube-loader" class="loaderArea">
            <div class="caption">
              <div class="cube-loader loader">
                <div class="cube loader-1"></div>
                <div class="cube loader-2"></div>
                <div class="cube loader-4"></div>
                <div class="cube loader-3"></div>
              </div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
