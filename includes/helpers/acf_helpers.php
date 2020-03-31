<?php
/*
 * ACF json sync
 *
 */
add_filter('acf/settings/save_json', 'conf_acf_json');
function conf_acf_json( $path ) {
    $path = THEME_URI . '/acf-json';
    return $path;  
}
/*
 * ACF options page
 *
 */
add_action('init', 'hcc_acf_init');
function hcc_acf_init() {
    if( function_exists('acf_add_options_page') ) {
        // add parent
        $parent = acf_add_options_page(array(
            'page_title'	=> __('Theme General Settings', 'hcc'),
            'menu_title'	=> __('Theme Settings', 'hcc'),
            'menu_slug'		=> 'theme-general-settings',
            'icon_url'		=> 'dashicons-info',
            'capability'	=> 'edit_posts',
            'redirect'		=> true
        ));

        // add sub page
        acf_add_options_sub_page(array(
            'page_title'	=> __('General settings', 'hcc'),
            'menu_title'	=> __('General', 'hcc'),
            'parent_slug'	=> $parent['menu_slug'],
        ));
    
    }
}

/*
 * Pasting custom user code in head
 *
 */
add_action("wp_head", "hcc_wp_head_extra_code");
function hcc_wp_head_extra_code() {
    echo get_field('header_code','options');
}
/*
 * Pasting custom user code after <body> tag
 *
 */
add_action("wp_body_open", "hcc_wp_body_open_extra_code");
function hcc_wp_body_open_extra_code() {
    echo get_field('body_code_top','options');
}
/*
 * Pasting custom user code after <body> tag
 *
 */
add_action("wp_footer", "hcc_wp_body_close_extra_code");
function hcc_wp_body_close_extra_code() {
    echo get_field('body_code_bottom','options');
}
/*
 * Get acf title with tags
 *
 */
function get_conf_header( $class = '' ){
            $tag   = get_sub_field('tag');
            $title = wp_kses_post( get_sub_field('block_title') );
            if (empty($tag)) { $tag = 'div';	};
            if (empty($title)) { $title = '';	};
            return '<'.$tag.' class="'.$class.'">'. $title .'</'.$tag.'>';    
}
/*
 * Get acf subtitle with tags
 *
 */    
function get_conf_title( $class = '', $element ){
            $tag   = $element['tag'];
            $title = wp_kses_post( $element['block_title'] );
            if (empty($tag)) { $tag = 'div';	};
            if (empty($title)) { $title = '';	};
            return '<'.$tag.' class="'.$class.'">'. $title .'</'.$tag.'>';    
}
/*
 * Google map key
 *
 */
if( !empty( API_KEY ) ){
    function hcc_acf_google_map_api( $api ){
        $api['key'] = API_KEY; 
        return $api;
    }
    add_filter('acf/fields/google_map/api', 'hcc_acf_google_map_api');
}

/* Register ACF blocks for gutenberg
* https://www.advancedcustomfields.com/resources/blocks/
* https://www.advancedcustomfields.com/resources/acf_register_block_type/
*/
if( function_exists('acf_register_block_type') ) {
	add_action('init', 'hcc_register_acf_block_types');
}

function hcc_register_acf_block_types() {
    //Example
    acf_register_block( 
		array(
			'name'						=> 'contact_form',
			'title'						=> __('Contact form', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/FILE_NAME.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			// 'post_types'			=> array('post', 'page'),
		));
    //Project Bloks
    acf_register_block( 
		array(
			'name'						=> 'main_banner',
			'title'						=> __('Main banner', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/main_banner-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_adv',
			'title'						=> __('We offer', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_adv-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_price',
			'title'						=> __('Our prices', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_price-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_action',
			'title'						=> __('Actions', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_action-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_portfolio',
			'title'						=> __('Portfolio', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_portfolio-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_reviews',
			'title'						=> __('Reviews', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_reviews-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
     acf_register_block( 
		array(
			'name'						=> 'work_scheme',
			'title'						=> __('Work scheme', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/work_scheme-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
     acf_register_block( 
		array(
			'name'						=> 'site_faq',
			'title'						=> __('FAQ', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_faq-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_addon',
			'title'						=> __('Text & image block', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_addon-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_text',
			'title'						=> __('Text block', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_text-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
    acf_register_block( 
		array(
			'name'						=> 'site_contacts',
			'title'						=> __('Contacts', 'hcc'),
			'description'			=> __('.','hcc'),
			'render_template'	=> 'template-parts/blocks/site_contacts-block.php', //source for rendering template
			'category'				=> 'acf-blocks',
			'icon'						=> 'format-status',
			'mode'						=> 'preview',
			'supports'				=> array( 'align' => false ),
			'post_types'			=> array('page'),
		));
}

/*
 * ACF pages content for TinyMCE & Gutenberg
 */
if( is_page_template( 'templates/template-acf.php' ) || is_404() || is_page_template( 'templates/template-contacts.php' ) || is_page_template( 'templates/template-privacy.php' ) || is_page_template( 'templates/template-thanks.php' ) ){
    add_filter( 'the_content', 'hcc_content_acf_pages' );
    function hcc_content_acf_pages( $content ){
        global $post;
        $meta = get_post_meta( $post->ID );
        if( !empty( $meta ) || !has_blocks( $content ) ){
            if (get_field('flexible_content')){
                 while (has_sub_field('flexible_content')){
                     $row_layout_slug = get_row_layout();
                     $flexible = get_template_part('template-parts/flexible', $row_layout_slug);
                 }
            }
            return $flexible . $content;
        }else{
            return $content;
        }
    }   
}