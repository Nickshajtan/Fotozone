<?php
/*
 * Change admin login page style
 * return html code
 */

add_action( 'login_enqueue_scripts', 'hcc_login_logo_one' );
function hcc_login_logo_one() { 
	$logo_img = '';
    $name = '';
	if( $custom_logo_id = get_theme_mod('custom_logo') ){
		$logo_img = wp_get_attachment_image_url( $custom_logo_id, 'full');
        if( $logo_img ){
            $result = $logo_img;
            $name = '';
        }
    }
    else{
            $result = 'none';
            $name = get_bloginfo('name');
    }
		echo '<div id="gradient"></div>';
		echo '<style type="text/css"> body.login div#login h1:after{content: "' . $name . '"; display: block; font-size: 1rem; max-width: 68%; margin-left: auto; margin-right: auto; margin-bottom: 30px; color: #fff;
    text-shadow: 2px 4px 6px rgba(11,9,9,0.35);} body.login div#login h1 a {background-image: url('. $result .'); background-size: contain; background-position: center; width: 150px; height: 100px; } #login{position:relative; z-index:100; } #login form{background: rgba(255,255,255,.5) !important; } #login a, #login a:hover{color: #fff !important; } #gradient{position: fixed; left:0; right:0; top:0; bottom:0; background: linear-gradient(-45deg, #ee7752, #3ce7e7, #23a6d5, #23d5ab); background-size: 400% 400%; animation: gradientBG 15s ease infinite; } @keyframes gradientBG {0% {background-position: 0% 50%; } 50% {background-position: 100% 50%; } 100% {background-position: 0% 50%; } } </style>'; 
} 
add_filter( 'login_headerurl', 'hcc_custom_loginlogo_url' );
function hcc_custom_loginlogo_url($url) {
	return GET_THEME_HOME_URL;
}
  
/*
 * Do things upon theme activation
 *
 */
add_action("after_switch_theme", "mytheme_do_something");
function mytheme_do_something(){
	$pages = array(
		'contact' => array(
			'new_page_title' => __('Contacts', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-contacts.php',
		),
		'404' => array(
			'new_page_title' => __('404 error', 'hcc'),
			'new_page_name' => 'error-404',
			'new_page_content' => '',
			'new_page_template' => '',
		),
		'thank-you' => array(
			'new_page_title' => __('Thank you', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-thanks.php',
		),
        'privacy' => array(
			'new_page_title' => __('Privacy Policy', 'hcc'),
			'new_page_name' => '',
			'new_page_content' => '',
			'new_page_template' => 'templates/template-privacy.php',
		),
	);
	foreach ($pages as $page) {
		$page_check = get_page_by_title($page['new_page_title']);
		$new_page = array(
			'post_type'			=> 'page',
			'post_title'		=> $page['new_page_title'],
			'post_name'			=> $page['new_page_name'],
			'post_content'	    => $page['new_page_content'],
			'post_status'		=> 'publish',
			'post_author'		=> 1,
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			if(!empty($page['new_page_template'])){
				update_post_meta($new_page_id, '_wp_page_template', $page['new_page_template']);
			}
		}
	}

    /*
     * Disable gutenberg on page
     *
     */
	$my_gtb_options = get_option('hcc-theme-gtb-tmpl');
	if (empty($my_gtb_options)) {
		$my_gtb_options = array('templates/template-contacts.php', 'templates/template-thanks.php', 'templates/template-privacy.php' );
	} else {
		array_push($my_gtb_options, 'templates/template-contacts.php', 'templates/template-thanks.php', 'templates/template-privacy.php');
	}
	update_option('hcc-theme-gtb-tmpl', $my_gtb_options);

	/*
     * Activate required plugins
     *
     */
	foreach (array(
		'cyr2lat/cyr-to-lat.php',
		'cyr3lat/cyr-to-lat.php',
		'wp-mail-smtp/wp-mail-smtp.php',
	) as $plugin) {
		$path = sprintf($plugin);
		$result = activate_plugin( $path );
		if ( !is_wp_error( $result ) ) {
			add_action( 'admin_notices', function() use ($plugin) {
				echo '<div class="notice notice-success"><p>' . sprintf('<strong>%s</strong>' . __(' plugin is required & auto-enabled by the current theme.', 'hcc'), $plugin) . '</p></div>';
			} );
		} else {
			add_action( 'admin_notices', function() use ($plugin) {
				echo '<div class="notice notice-error"><p>' . sprintf('<strong>%s</strong>' . __(' plugin can\'t be auto-enabled by the current theme.', 'hcc'), $plugin) . '</p></div>';
			} );
		}
	}
}

/*
 * Add post states
 *
 */
add_filter( 'display_post_states', 'hcc_add_post_state', 10, 2 );
function hcc_add_post_state( $post_states, $post ) {
	if( $post->post_name == 'error-404' ) {
		$post_states[] = __('404 error page', 'hcc');
	}
	if( get_page_template_slug( $post->ID ) == 'templates/template-thanks.php' ) {
		$post_states[] = __('Thank you page', 'hcc');
	}
    if( get_page_template_slug( $post->ID ) == 'templates/template-contacts.php' ) {
		$post_states[] = __('Contacts page', 'hcc');
	}
    if( get_page_template_slug( $post->ID ) == 'templates/template-privacy.php' ) {
		//$post_states[] = __('Privacy Policy page', 'hcc');
        update_option( 'wp_page_for_privacy_policy', $post->ID );
	}
	return $post_states;
}

/*
 * Add post notice
 *
 */
add_action( 'admin_notices', 'hcc_add_post_notice' );
function hcc_add_post_notice() {
	global $post;
	if( @get_page_template_slug( $post->ID ) == 'templates/template-contacts.php' ) {
		/* Add a notice to the edit page */
		//add_action( 'edit_form_after_title', 'hcc_add_page_notice_cnt', 1 );
		/* Remove the WYSIWYG editor */
		//remove_post_type_support( 'page', 'editor' );
	}

	if( isset( $post->post_name ) && ( $post->post_name == 'error-404' )) {
		/* Add a notice to the edit page */
		add_action( 'edit_form_after_title', 'hcc_add_page_notice_err', 1 );
	}
}

function hcc_add_page_notice_cnt() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'Contents of this pager are edited from the Theme options -> Contacts or follow this <a href="/wp-admin/admin.php?page=acf-options-contacts">link</a> !', 'hcc' ) . '</p></div>';
}
function hcc_add_page_notice_err() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'This page is used to display 404 page content. DO NOT CHANGE ITS SLAG!', 'hcc' ) . '</p></div>';
}

/*
 * Add menu messag
 *
 */
add_filter('admin_print_scripts-nav-menus.php', 'hcc_add_nav_message', 10, 2);
function hcc_add_nav_message( $hook ){
    if ( 'appearance_page_nav-menus.php' != $hook ) {
        wp_register_script( 'admin-nav-js', THEME_URI . '/includes/config/admin/assets/js/nav-message.min.js', array('jquery'), '', true );
        wp_localize_script( 'admin-nav-js', 'hcc_nav_params', array(
		    'message' =>  __('Если Вы хотите добавить ссылку на существующий элемент страницы используйте #ID, ID - уникальный идентификатор Вашего элемента. Используйте конструкции вида %home% или %page_name% в начале строки, чтобы указать страницу элемента.', 'hcc'),
        ) );
        wp_enqueue_script( 'admin-nav-js' );
    }
}
// Security helpers
get_template_part('includes/helpers/security_helpers');