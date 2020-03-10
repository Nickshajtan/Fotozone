<?php

//Core
define( 'THEME', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_STYLE', get_stylesheet_directory() );
define( 'THEME_STYLE_URI', get_stylesheet_directory_uri() );
define( 'STYLESHEET_URI', get_stylesheet_uri() );
define( 'THEME_HOME_URL', home_url('/') );
define( 'GET_THEME_HOME_URL', get_home_url() );
define( 'SITE_URL', site_url() );
define( 'SITE_NAME', wp_kses_post( get_bloginfo('name') ) );

// ACF, Site options as define 
define( 'API_KEY', get_field('google_key', 'options') );
define( 'COPYRIGHT', str_ireplace( "%year%", date('Y', time()), get_field('copyright', 'options') ) );
$acf_logo = get_field('site_logo', 'options');
if( !empty( $acf_logo ) ){
    define( 'SITE_LOGO', wp_get_attachment_image( $acf_logo, 'logo-size', false, array( 'class'    => 'custom-logo', 'itemprop' => 'logo', ) ) );
}
elseif( function_exists( 'the_custom_logo' ) ){
    $logo_img = '';
    if( $custom_logo_id = get_theme_mod('custom_logo') ){
        $logo_img = wp_get_attachment_image( $custom_logo_id, 'logo-size', false, array(
            'class'    => 'custom-logo',
            'itemprop' => 'logo',
        ) );
    }
    define( 'SITE_LOGO', $logo_img );
}