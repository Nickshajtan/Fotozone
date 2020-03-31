<?php
/*
* Register Gutenberg styles & scripts for ACF blocks
*
*/
add_action( 'enqueue_block_editor_assets', 'hcc_myguten_enqueue' );
function hcc_myguten_enqueue(){
	wp_register_script(
		'hcc-acf-guten-script',
		THEME_STYLE_URI . '/includes/helpers/gutenberg/blocks.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
	);
    wp_enqueue_script('hcc-acf-guten-script');
	wp_register_style( 
		'hcc-acf-guten-style', 
		THEME_STYLE_URI . '/assets/public/gtb.min.css'
	);
    wp_enqueue_style('hcc-acf-guten-style');
}

/*
* Register Gutenberg styles & scripts with WP Gutenberg Block API
*
*/
add_action( 'enqueue_block_assets', 'hcc_gtb_load_front_end' );
function hcc_gtb_load_front_end(){
    if( !is_admin() ){
        // enqueue front end only scripts and styles here
        // scripts: array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' )
        // styles: array( 'wp-edit-blocks' )
    }
}

add_action( 'enqueue_block_editor_assets', 'hcc_gtb_load_admin' );
function hcc_gtb_load_admin(){
    wp_register_script(
        'hcc-guten-script',
        THEME_STYLE_URI . '/includes/helpers/gutenberg/gtn-api.js',
        array('wp-blocks','wp-editor', 'wp-dom-ready', 'wp-edit-post'),
		true
    );
    wp_enqueue_script('hcc-guten-script');
    wp_register_style( 
		'hcc-guten-style', 
		THEME_STYLE_URI . '/assets/public/gtb-wp.min.css'
	);
    wp_enqueue_style('hcc-guten-style');
}

/*
* Register Gutenberg categories
* 
*/
add_filter( 'block_categories', 'hcc_acf_block_categories', 10, 3 );
function hcc_acf_block_categories( $categories, $post ) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'acf-blocks',
                    'title' => __( 'HCC ACF blocks', 'hcc' ),
                    'icon'  => 'vault',
                ),
                array(
                    'slug' => 'hcc-blocks',
                    'title' => __( 'HCC API blocks', 'hcc' ),
                    'icon'  => 'vault',
                ),
            )
        );
}

// All blocks you will see with next JS code: wp.blocks.getBlockTypes().forEach( function(blockType){console.log( blockType.name); });
add_filter( 'allowed_block_types', 'hcc_allowed_block_types', 10, 4  );
function hcc_allowed_block_types( $allowed_blocks, $post  ) {
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    // Disable Widgets Blocks
    unset($registered_blocks['core/calendar']);
    unset($registered_blocks['core/legacy-widget']);
    unset($registered_blocks['core/rss']);
    unset($registered_blocks['core/search']);
    unset($registered_blocks['core/tag-cloud']);
    unset($registered_blocks['core/latest-comments']);
    unset($registered_blocks['core/archives']);
    unset($registered_blocks['core/categories']);
    unset($registered_blocks['core/latest-posts']);
    unset($registered_blocks['core/shortcode']);
    
    $registered_blocks = array_keys($registered_blocks);
	return array_merge(
        array(
            'acf/acf-blocks', 
            'hcc/hcc-blocks',
        ), 
        $registered_blocks
	);
 
}

/*
* Register meta for Gutenberg
*
*/
add_action( 'init', 'hcc_gtb_meta_block_init' );
function hcc_gtb_meta_block_init() {
	register_meta( 'post_type', 'meta_key', array(
		'show_in_rest' => true,
		'single' => true,
	) );
}

/*
* Register Gutenberg blocks with WP Gutenberg Block API
*
*/
add_action('init', 'hcc_register_gtb_blocks');
function hcc_register_gtb_blocks(){
    register_block_type( 'hcc/get-post', array(
       'attributes'      => array(
                'postType' => array(
                    'type'    => 'string',
                    'default' => 'portfolio',
                ),
				'postsPerPage' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'order'        => array(
					'type'    => 'string',
					'default' => 'desc',
				),
        ),
	   'render_callback' => 'hcc_render_block_get_post',
       'editor_script'   => 'hcc-guten-script',
       'category'        => 'hcc-blocks',
    ) );
    function hcc_render_block_get_post( $attribites, $content ) {
        $args = [
			'posts_per_page' => $attributes['postsPerPage'],
			'post_status'    => 'publish',
			'order'          => $attributes['order'],
            'post_type'      => $attributes['postType'],
		];
        $posts = get_posts( $args );
        $html  = '';
        if ( $posts ) {
			$html .= '<div class="wp-block-get-post-wrapper"><ul>';
            foreach ( $posts as $item ) {
                $html .= sprintf( '<li><a class="wp-block-get-post" href="%1$s">%2$s</a></li>', esc_url( get_the_permalink( $item->ID ) ), esc_html( get_the_title( $item->post_title ) ) );
			}
            $html .= '</ul></div>';
        }

		return $html;
    }
}