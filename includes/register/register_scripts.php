<?php
/*
* Register theme styles & scripts 
*
*/
define( 'PATH', dirname(dirname(dirname(__FILE__))) );

add_action( 'wp_enqueue_scripts', 'hcc_add_head_styles' );
function hcc_add_head_styles(){
    //Base theme styles
    $path     = '/assets/public/base-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'base', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'base' );
    }
    //Compile theme less for first screen
    $path     = '/assets/public/less-header-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'less-head' );
    }
    //Compile theme sass for first screen
    $path     = '/assets/public/sass-header-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'sass-head' );
    }
    //Compile theme scss for first screen
    $path     = '/assets/public/scss-header-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'scss-head' );
    }
    //Compile theme stylus for first screen
    $path     = '/assets/public/stylus-header-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'stylus-head' );
    }
}

add_action( 'after_setup_theme', 'hcc_add_editor_styles' );
function hcc_add_editor_styles() {
    add_theme_support( 'editor-styles' );
    add_theme_support( 'editor-style' );
	add_editor_style( 'editor-styles.css' );
}

add_action( 'wp_enqueue_scripts', 'hcc_add_scripts' );
function hcc_add_scripts(){
    
    // jQuery
    wp_deregister_script( 'jquery-core' );
    /*** If CDN available ***/
    $url = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js';
    $response = wp_remote_get( $url );
    $code = wp_remote_retrieve_response_code( $response );
    if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url) && ( $code == '200') ){
	        wp_register_script( 'jquery-core', $url ,array(), null, true);
	        wp_enqueue_script( 'jquery-core' );
    }
    /*** Else ***/
    else{
            wp_register_script( 'jquery-core', THEME_URI . '/assets/public/libs/jquery/jquery.min.js', array(), null, true);
	        wp_enqueue_script( 'jquery-core');
    }	
    
    // Compile theme scripts
    if( !empty( API_KEY ) && !is_404() ){
        wp_register_script( 'google_map_js', '//maps.googleapis.com/maps/api/js?key=' . API_KEY, array('jquery'), '', true );
        wp_enqueue_script( 'google_map_js');   
    }
    
}

add_action( 'get_footer', 'hcc_add_footer_libs' );
function hcc_add_footer_libs() {
    $libs = get_field('options_libs', 'options');
    if( !empty( $libs ) ){
        foreach( $libs as $lib ){

            if( $lib === 'bootstrap_css' ){
                //Bootstrap CSS
                /*** If CDN available ***/
                $url = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css';
                $response = wp_remote_get($url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url) && ( $code == '200') ){
                            wp_register_style( 'bootstrap', $url, array(), ' ' );
                            wp_enqueue_style( 'bootstrap' );
                }
                /*** Else ***/
                else{
                        wp_register_style( 'bootstrap', THEME_URI . '/assets/public/libs/bootstrap/bootstrap.min.css', array(), ' ' );
                        wp_enqueue_style( 'bootstrap' );
                }  
                //End Bootstrap CSS
            }
            if( $lib === 'bootstrap_grid_css' ){
                //Bootstrap CSS only grid
                 wp_register_style( 'bootstrap-grid', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-grid.min.css', array(), ' ' );
                 wp_enqueue_style( 'bootstrap-grid' );
                //End
            }
            if( $lib === 'bootstrap_rebot_css' ){
                //Bootstrap CSS only rebot
                 wp_register_style( 'bootstrap-reboot', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-reboot.min.css', array(), ' ' );
                 wp_enqueue_style( 'bootstrap-reboot' );
                //End
            }
            
            if( $lib === 'popper_js' ){
                //Bootstrap Popper JS
                /*** If CDN available ***/
                $popper_url = 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js';
                $response = wp_remote_get($popper_url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $popper_url ) && !empty( $popper_url ) && ( $code == '200') ){
                            wp_register_script( 'popper', $popper_url, array(), ' ' );
                            wp_enqueue_script( 'popper' );
                }
                /*** Else ***/
                else{
                        wp_register_script( 'popper', THEME_URI . '/assets/public/libs/bootstrap/popper.min.js', array('jquery'), '', true );
                        wp_enqueue_script( 'popper' );
                }  
                //End Bootstrap Popper JS
            }
            if( $lib === 'bootstrap_js' ){
                //Bootstrap JS
                /*** If CDN available ***/
                $url = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js';
                $response = wp_remote_get($url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url ) && ( $code == '200') ){
                            wp_register_script( 'bootstrap', $url, array(), ' ' );
                            wp_enqueue_script( 'bootstrap' );
                }
                /*** Else ***/
                else{
                        wp_register_script( 'bootstrap', THEME_URI . '/assets/public/libs/bootstrap/bootstrap.min.js', array('jquery'), '', true );
                        wp_enqueue_script( 'bootstrap' );
                }  
                //End Bootstrap JS
            }
            if( $lib === 'slick' ){
                //Slick jQuery plugin
                 wp_register_style( 'slick-css', THEME_URI . '/assets/libs/slick/slick.min.css', array(), ' ' );
                 wp_enqueue_style( 'slick-css' );
                 wp_register_style( 'slick-theme-css', THEME_URI . '/assets/libs/slick/slick-theme.min.css', array(), ' ' );
                 wp_enqueue_style( 'slick-theme-css' );
                 wp_register_script( 'slick-js', THEME_URI . '/assets/libs/slick/slick.min.js', array('jquery'), '', true );
                 wp_enqueue_script( 'slick-js' );
                //End Slick
            }
            if( $lib === 'waterwall' ){
                //Waterwall jQuery plugin
                 wp_register_script( 'waterwall', THEME_URI . '/assets/libs/waterwall/waterwall.min.js', array('jquery'), '', true );
                 wp_enqueue_script( 'waterwall' );
                //End Waterwall
            }
            if( $lib === 'fancybox' ){
                //Fancybox jQuery plugin
                wp_register_style( 'fancybox-css', THEME_URI . '/assets/libs/fancybox/fancybox.min.css', array(), ' ' );
                wp_enqueue_style( 'fancybox-css' );
                wp_register_script( 'fancybox-js', THEME_URI . '/assets/libs/fancybox/fancybox.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'fancybox-js' );
                //End Fancybox
            }
            if( $lib === 'progressive' ){
                //Progressive Image (Lazy loading) jQuery plugin
                wp_register_style( 'progressive-css', THEME_URI . '/assets/libs/progressive-image/progressive.min.css', array(), ' ' );
                wp_enqueue_style( 'progressive-css' );
                wp_register_script( 'progressive-js', THEME_URI . '/assets/libs/progressive-image/progressive.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'progressive-js' );
                //End Progressive Image
            }
            if( $lib === 'ias' ){
                //Ias (scroll loading) jQuery plugin
                wp_register_script( 'ias-js', THEME_URI . '/assets/libs/ias/ias.min.js', array('jquery'), '', true );
                wp_localize_script( 'ias-js', 'hcc_ias', array(
                    'more_text' => __('Показать ещё', 'hcc'),
                ));
                wp_enqueue_script( 'ias-js' );
                //End Ias
            }
            if( $lib === 'waypoints' ){
                //Waypoints (scroll loading) jQuery plugin
                wp_register_script( 'waypoints-js', THEME_URI . '/assets/libs/waypoints/jquery.waypoints.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-js' );
                wp_register_script( 'waypoints-helper', THEME_URI . '/assets/libs/waypoints/infinite.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-helper' );
                //End Waypoints
            }
        }
    }   
}

add_action( 'get_footer', 'hcc_add_footer_scripts' );
function hcc_add_footer_scripts() {
    //Including Google API script
    $key = get_field('google_api_key', 'options');
    wp_register_script( 'google_map_js', '//maps.googleapis.com/maps/api/js?key=' . $key, array('jquery'), '', true );
    wp_enqueue_script( 'google_map_js');
    //If you want to enable independently 
    /*wp_register_script( 'custom_google_map_js', THEME_URI . '/assets/js/theme/custom-map.js', array('jquery'), '', true );
    wp_enqueue_script( 'custom_google_map_js');*/
    //Including theme vendor scripts. Always must be on the end!
    wp_register_script( 'vendor-js', THEME_URI . '/assets/public/vendor.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'vendor-js' );
    //Including theme scripts. Always must be on the end!
    wp_register_script( 'theme-js', THEME_URI . '/assets/public/theme.min.js', array('jquery'), '', true );
    wp_localize_script( 'theme-js', 'hcc_ajax_params', array(
		'ajaxurl' => SITE_URL . '/wp-admin/admin-ajax.php',
        'error_header' => __('Ошибка отправки', 'hcc'),
        'error_body' => __('Пожалуйста, попробуйте позже', 'hcc'),
        'success_header' => __('Спасибо!', 'hcc'),
        'success_body' => __('Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время', 'hcc'),
        'cfThankYou' => htmlspecialchars( trim( get_option('hcc-theme-cf-thanks') ) ),
        'more_text' => __('Показать ещё', 'hcc'),
        'error_text' => __('Ошибка запроса', 'hcc'),
        'load_text' => __('Загрузка', 'hcc'),
        'slice_more_text' => __('Показать ещё', 'hcc'),
        'slice_less_text' => __('Скрыть', 'hcc'),
	) );
    $template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
    if( $template == 'template-thanks.php' || $template == 'template-contacts.php' || $template == '404.php' || $template == 'template-privacy.php' ){
        $template_ex = false;
    }
    else{
        $template_ex = true;
    }
    wp_localize_script( 'theme-js', 'hcc_js_custom_params', array(
        'home_url' => THEME_HOME_URL,
        'theme_url' => THEME_URI . '/assets/public/',
        'true_theme_url' => THEME_URI,
        'template_name' => $template_ex,
        'is_404' => ( is_404() ) ? 'true' : 'false',
        'minute' => __('минута', 'hcc'),
        'minutes' => __('минут', 'hcc'),
        'minut' => __('минуты', 'hcc'),
    ) );
    wp_enqueue_script( 'theme-js' );
}

add_action( 'get_footer', 'hcc_add_footer_styles' );
function hcc_add_footer_styles() {
    //Compile theme fonts
    $path     = '/assets/public/fonts.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'fonts', THEME_URI . $path );
        wp_enqueue_style( 'fonts' );
    }
    //Compile theme less
    $path     = '/assets/public/less-other-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-other', THEME_URI . $path );
        wp_enqueue_style( 'less-other' );
    }
    $path     = '/assets/public/less-vendor-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-vendor', THEME_URI . $path );
        wp_enqueue_style( 'less-vendor' );
    }
    //Compile theme sass
    $path     = '/assets/public/sass-other-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-other', THEME_URI . $path );
        wp_enqueue_style( 'sass-other' );
    }
    $path     = '/assets/public/sass-vendor-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-vendor', THEME_URI . $path );
        wp_enqueue_style( 'sass-vendor' );
    }
    //Compile theme scss
    $path     = '/assets/public/scss-other-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-other', THEME_URI . $path );
        wp_enqueue_style( 'scss-other' );
    }
    $path     = '/assets/public/scss-vendor-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-vendor', THEME_URI . $path );
        wp_enqueue_style( 'scss-vendor' );
    }
    //Compile theme stylus
    $path     = '/assets/public/stylus-other-theme-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-other', THEME_URI . $path );
        wp_enqueue_style( 'stylus-other' );
    }
    $path     = '/assets/public/stylus-vendor-styles.min.css';
    $filename =  PATH . $path;
    if( file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-vendor', THEME_URI . $path );
        wp_enqueue_style( 'stylus-vendor' );
    }
    //Default
    wp_register_style( 'wp-style', STYLESHEET_URI );
	wp_enqueue_style( 'wp-style' );
}


//--remove version css, js--//
function wpex_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'wpex_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'wpex_remove_script_version', 15, 1 );