<?php

add_action( 'tgmpa_register', 'mytheme_require_plugins' );

function mytheme_require_plugins() {
        $plugins = array( 
            array(
                'name'      => 'Query Monitor',
                'slug'      => 'query-monitor',
                'required'  => false, // this plugin is recommended
            ),
            array(
                    'name'      => 'Callback',
                    'slug'      => 'bazz-callback-widget',
                    //'source' => your source, example: get_stylesheet_directory().'/plugins/bazz-callback-widget.zip' or link,
                    'required'  => false, // this plugin is recommended
            ),
            array(
                    'name'      => 'Jivochat Chat',
                    'slug'      => 'jivochat',
                    'required'  => false, // this plugin is recommended
            ),
            array(
                    'name'      => 'WP Smushit',
                    'slug'      => 'wp-smushit',
                    'required'  => false, // this plugin is recommended
            ),
            array(
                    'name'      => 'W3 Total Cache',
                    'slug'      => 'w3-total-cache',
                    'required'  => false, // this plugin is recommended
            ),
            array(
                    'name'      => 'Autoptimize',
                    'slug'      => 'autoptimize',
                    'required'  => false, // this plugin is recommended
            ),
        );    
    $config = array(
        /* The array to configure TGM Plugin Activation */
        /*domain => $theme_text_domain, // текстовый домен, точно такой как указан в вашей теме*/
        /*dafault_path => '', // Абсолютный путь по умолчанию к папке плагинов*/
        /*menu => 'install-my-theme-plugin', // Menu slug*/
        'settings' => array(
        /*'page_title' => __('Install Required Plugins', $theme_text_domain)*/
        /*'menu_title' => __('Install Plugins', $theme_text_domain)*/
        /*'instructions_install' => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name */
        /*'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
        /*'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name */
        /*'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name */
        /*'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
        /*'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL */
        /*'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
        /*'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
        /*'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
        /*'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
        ),
    );
    tgmpa( $plugins, $config );
}
