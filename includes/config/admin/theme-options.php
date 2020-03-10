<?php 
/**
 * Set up a WP-Admin page for managing turning on and off theme features.
 */
function hcc_theme_add_options_page() {
	add_theme_page(
		__('Theme Options', 'hcc'),
		__('Theme Options', 'hcc'),
		'manage_options',
		'hcc-theme-options',
		'hcc_theme_options_page'
	);

	// Call register settings function
	add_action( 'admin_init', 'hcc_theme_options' );
}
add_action( 'admin_menu', 'hcc_theme_add_options_page' );


/**
 * Register settings for the WP-Admin page.
 */
function hcc_theme_options() {
    // wordpress cleanup
	register_setting( 'hcc-wp-theme-options', 'hcc-theme-wp-cleanup');
	// wordpress disable blogging
	register_setting( 'hcc-wp-theme-options', 'hcc-theme-wp-blog-dn');
    
    add_settings_section('hcc-wp-settings-theme', 'WordPress' . __(' settings', 'hcc'), 'hcc_wp_options_fields', '');
    
    
	// gutenberg by post type
	register_setting( 'hcc-gtb-theme-options', 'hcc-theme-gtb-pt');
	// gutenberg by template file
	register_setting( 'hcc-gtb-theme-options', 'hcc-theme-gtb-tmpl');
	
    add_settings_section('hcc-gtb-settings-theme', 'Gutenberg' . __(' settings', 'hcc'), 'hcc_gtb_options_fields', '');
    
	// contact form demo
	register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-demo');
	// contact form thank you
	register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-thanks');
    // contact form email
	register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-email');
    // contact form saving in panel
	register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-panel-save');
    
    add_settings_section('hcc-cf-settings-theme',  __('Contact form settings', 'hcc'), 'hcc_cf_options_fields', '');
    
    // modal form
    register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-modal');
    // modal form title
    register_setting( 'hcc-cf-theme-options', 'hcc-theme-cf-modal-title');
    
    add_settings_section('hcc-mf-settings-theme',  __('Modal form settings', 'hcc'), 'hcc_mf_options_fields', '');
}

function hcc_wp_options_fields(){}
function hcc_gtb_options_fields(){}
function hcc_cf_options_fields(){}
function hcc_mf_options_fields(){}


/**
 * Build the WP-Admin settings page.
 */
function hcc_admin_tabs( $active_tab = 'wordpress' ) {
    $tabs = array( 'wordpress' => 'WordPress', 'gutenberg' => 'Gutenberg', 'contact-form' =>  __('Contact form', 'hcc') );
    echo '<h1>'.__('Theme Options', 'hcc').'</h1>
        <h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $active_tab ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab" . $class . "' href='?page=hcc-theme-options&tab=" . $tab . "'>" . $name . "</a>";
        }
        echo '</h2>';
    
}
function hcc_theme_options_page() {
    global $pagenow;
        echo '<div class="wrap"><form method="post" enctype="multipart/form-data" action="options.php">';
        $active_tab = isset( $_GET[ 'tab' ] ) ? hcc_admin_tabs( $_GET[ 'tab' ] ) : hcc_admin_tabs('wordpress');
        if ( $pagenow == 'themes.php' && $_GET['page'] == 'hcc-theme-options' ){
            if ( isset ( $_GET['tab'] ) ) $active_tab = $_GET['tab'];
            else $active_tab = 'wordpress';
                
                switch ( $active_tab ){
                    case 'wordpress' : 
                            settings_fields( 'hcc-wp-theme-options' );
                            do_settings_sections( 'hcc-wp-settings-theme' );
                            get_template_part('includes/config/admin/theme-options-wp-html');
                            break;
                    case 'gutenberg' :
                            settings_fields( 'hcc-gtb-theme-options' );
                            do_settings_sections( 'hcc-gtb-settings-theme' );
                            get_template_part('includes/config/admin/theme-options-gtb-html');
                            break;
                    case 'contact-form' :
                            settings_fields( 'hcc-cf-theme-options' );
                            do_settings_sections( 'hcc-cf-settings-theme' );
                            get_template_part('includes/config/admin/theme-options-cf-html');
                            break;
                }

        } ?>
        <div style="clear: both;">
                <?php submit_button(null, 'primary'); ?>
                <input type="hidden" name="hcc-settings-submit" value="Y" />
        </div>
        <?php echo '</form></div>';
}

function hcc_save_theme_settings() {
    global $pagenow;
    
    if ( $pagenow == 'themes.php' && $_GET['page'] == 'hcc-theme-options' ){
        if ( isset ( $_GET['tab'] ) ) $active_tab = $_GET['tab'];
        else $active_tab = 'wordpress';
        switch ( $active_tab ){
                    case 'wordpress' :
                        $new_cleanup = $_POST['hcc-theme-wp-cleanup'];
                        if( isset( $new_cleanup ) ){
                            update_option('hcc-theme-wp-cleanup', $new_cleanup );
                        }
                        $new_blog_dn = $_POST['hcc-theme-wp-blog-dn'];
                        if( isset( $new_blog_dn ) ){
                            update_option('hcc-theme-wp-blog-dn', $new_blog_dn);
                        }
                        break;
                    case 'gutenberg' :
                        $new_pt = $_POST['hcc-theme-gtb-pt[]'];
                        if( isset( $new_pt ) ){
                            update_option('hcc-theme-gtb-pt', $new_pt);
                        }
                        $new_tmpl = $_POST['hcc-theme-gtb-tmpl[]'];
                        if( isset( $new_tmpl ) ){
                            update_option('hcc-theme-gtb-tmpl', $new_tmpl);
                        }
                        break;
                    case 'contact-form' :
                
                        $new_demo = $_POST['hcc-theme-cf-demo'];
                        if( isset( $new_demo ) ){
                            update_option('hcc-theme-cf-demo', $new_demo );
                        }
                        $new_thanks = $_POST['hcc-theme-cf-thanks'];
                        if( isset( $new_thanks ) ){
                            update_option('hcc-theme-cf-thanks', $new_thanks );
                        }
                        $new_cf_email = $_POST['hcc-theme-cf-email'];
                        if( isset( $new_cf_email ) ){
                            update_option('hcc-theme-cf-email', $new_cf_email );
                        }
                        $new_cf_save = $_POST['hcc-theme-cf-panel-save'];
                        if( isset( $new_cf_save ) ){
                            update_option('hcc-theme-cf-panel-save', $new_cf_save );
                        }
                        $new_cf_modal = $_POST['hcc-theme-cf-modal'];
                        if( isset( $new_cf_modal ) ){
                            update_option('hcc-theme-cf-modal', $new_cf_modal );
                        }
                        $new_cf_title = $_POST['hcc-theme-cf-modal-title'];
                        if( isset( $new_cf_title ) ){
                            update_option('hcc-theme-cf-modal-title', $new_cf_title );
                        }

                        break;
        }
        
    }
    
}

function hcc_load_settings_page() {
     if ( $_POST['hcc-settings-submit'] == 'Y' ) {
         check_admin_referer( 'hcc-theme-options' );
         hcc_save_theme_settings();
         $url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
         wp_redirect(admin_url('themes.php?page=hcc-theme-options&'.$url_parameters));
         exit;
     }
}

/**
 * Disable gutenberg for selected post types
 */
add_filter( 'use_block_editor_for_post_type', 'hcc_disable_gtn_pt', 10, 2 );
function hcc_disable_gtn_pt( $is_enabled, $post_type ) {
	$disable_gtb_types = get_option('hcc-theme-gtb-pt');
	if (empty($disable_gtb_types)) {
		$disable_gtb_types = array();
	}
	if ( in_array( $post_type, array_values($disable_gtb_types), true ) ) {
		return false;
	}
	return $is_enabled;
}

/**
 * Disable gutenberg for selected templates
 */

add_filter('use_block_editor_for_post', 'hcc_disable_gtn_tmpl', 10, 2);
function hcc_disable_gtn_tmpl($can_edit, $post) {
	$disable_gtb_tmpls = get_option('hcc-theme-gtb-tmpl');
	if (empty($disable_gtb_tmpls)) {
		$disable_gtb_tmpls = array();
	}
	if ( in_array( get_page_template_slug($post->ID), array_values($disable_gtb_tmpls), true ) ) {
		return false;
	}
	return $can_edit;
}

/**
 * Incude and run wordpress cleanup file
 */
add_action( 'after_setup_theme', 'hcc_wordpress_cleanup' );
function hcc_wordpress_cleanup(){
	$cleaner = get_option('hcc-theme-wp-cleanup');
	if ($cleaner) {
		if (!is_plugin_active('clearfy/clearfy.php')) {
			include_once('wordpress-cleanup.php');
		}
	}
}

/**
 * Disable/Enable WP blog functionality
 */
add_action( 'after_setup_theme', 'hcc_disable_blog_features' );
function hcc_disable_blog_features(){
    $blogging_dn    = get_option('hcc-theme-wp-blog-dn');
    $active_plugins = get_option('active_plugins');
    $disable_blog   = array( 'disable-blog/disable-blog.php' );
    
    if( $blogging_dn ){
        if( $active_plugins && !is_plugin_active('disable-blog/disable-blog.php') ){
            $disable_blog = array( 'disable-blog/disable-blog.php' );
            foreach ( $disable_blog as $plugin ) {
                if ( ! in_array( $plugin, $active_plugins ) ) {
                    array_push( $active_plugins, $plugin );
                    update_option( 'active_plugins', $active_plugins );
                }
            }   
        }
    }
    else{
        if( $active_plugins && is_plugin_active('disable-blog/disable-blog.php') ){
            foreach ( $disable_blog as $plugin ) {
                    if ( in_array( $plugin, $active_plugins ) ) {
                        $active_plugins = array_flip($active_plugins);
                        unset( $active_plugins[$plugin] );
                        $active_plugins = array_flip($active_plugins);
                        update_option( 'active_plugins', $active_plugins );
                    }
            }
        }
    }
}

/**
 * enqueue admin assets
 */
//add_action( 'admin_enqueue_scripts', 'hcc_enqueue_admin_scripts' );
function hcc_enqueue_admin_scripts($hook_suffix) {
	if($hook_suffix == 'appearance_page_hcc-theme-options') {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		wp_enqueue_script( 'myupload-script', THEME_STYLE_URI . '/includes/admin/assets/admin.js', array('jquery'), null, false );
	}
	wp_register_script( 'activation-script', THEME_STYLE_URI . '/includes/admin/assets/activation.js', array('jquery'), null, false );
}

/**
 * image uploader
 */
function hcc_image_uploader_field( $name, $value = '') {
	$image = ' button">Upload image';
	$image_size = 'thumbnail'; // it would be better to use thumbnail size here (150x150 or so)
	$display = 'none'; // display state ot the "Remove image" button
	if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
		// $image_attributes[0] - image URL
		// $image_attributes[1] - image width
		// $image_attributes[2] - image height
		$image = '"><img src="' . $image_attributes[0] . '" style="max-width:300px;display:block;" />';
		$display = 'inline-block';
	} 
	return '
	<div>
	<a href="#" class="hcc_upload_image_button' . $image . '</a>
	<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr( $value ) . '" />
	<a href="#" class="hcc_remove_image_button" style="display:inline-block;display:' . $display . '">' . __("Remove image", 'hcc') . '</a>
	</div>';
}