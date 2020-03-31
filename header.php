<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hcc
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  
/*
 * Check ZLIB & set ZLIB
 *
 */
$zlib = ini_get('zlib.output_compression');
if( isset( $zlib ) && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
    ini_set('zlib.output_compression', 'On');
    ini_set('zlib.output_compression_level', '1');
endif; 
/*
 * Check ZLIB and set GZIP
 *
 */
if( isset( $zlib ) && $zlib !== 'On' && ini_get('zlib.output_compression_level') !== '1' ) :
	if ( substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ) :
		ob_start('ob_gzhandler'); 
	endif;
endif;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
	<div id="page" class="site">
		
		<header id="masthead" class="site-header closed">
			<div class="wrapper container">
               <div class="burger">
                   <span></span>
                   <span></span>
                   <span></span>
               </div>
                <div class="header-top col-12">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <?php if( function_exists( 'hcc_the_custom_logo' ) ) : 
                                hcc_the_custom_logo(); 
                            endif; ?>
                        </div>
                        <?php if( function_exists( 'get_field' ) ) :
                        $phones = get_field('phone_nums', 'options'); 
                        if( $phones ) : ?>
                        <div class="col-12 col-lg-6 phones d-flex align-items-start justify-content-xl-end">
                            
                            <?php $counter = 1; foreach( $phones as $phone ) : ?>
                                <?php $tel = sanitize_text_field( trim( $phone['phone_num'] ) );
                                $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                                if( !empty( $tel ) ) : ?>
                                    <?php if( wp_is_mobile() && $counter === 2 ) : break; endif; ?>
                                    <a href="tel:+38<?php echo $href; ?>" class="d-flex align-items-center justify-content-start phone">
                                        <span class="icon"></span><span class="body">+38 <?php echo $tel; ?></span>
                                    </a>
                                <?php endif; 
                                if( $counter == 2 ) :
                                    break;
                                endif; ?>
                            <?php $counter++; endforeach; ?>
                
                        </div>
                        <?php endif;
                        endif; ?>
                    </div>
                </div>
				<div class="header-bottom col-12">
				    <div class="row">
				        <nav id="site-navigation" class="main-navigation col-12 col-lg-10">
                            <?php wp_nav_menu( array(
                                'theme_location'	=> 'main_menu',
                                'menu_id'			=> 'primary-menu',
                                'container'		    => '',
                                'walker'            => new My_Nav_Walker(),
                            ) ); ?>
                        </nav>
                        <?php if( function_exists( 'get_field' ) ) :
                        $socials = get_field('socials', 'options'); 
                        if( $socials ) : ?>
                        <div class="d-none d-xl-flex col-12 col-lg-2 socials align-items-start justify-content-end">
                            <?php foreach( $socials as $social ) : 
                                        $image = $social['icon'];
                                        $href  = esc_url( wp_kses_post( trim( $social['link'] ) ) );
                                        if( !empty( $image ) ) : ?>
                                            <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank">
                                                <img src="<?php echo esc_url( aq_resize( $image['url'], 30, 30, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" >
                                            </a>
                                        <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif;
                        endif; ?>
				    </div>
				</div>
		    </div>
	    </header>

	<div id="content" class="site-content">
	    <main>
