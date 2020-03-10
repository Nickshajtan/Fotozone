<?php

add_action( 'enqueue_block_editor_assets', 'hcc_myguten_enqueue' );
function hcc_myguten_enqueue() {
	wp_enqueue_script(
		'hcc-myguten-script',
		THEME_STYLE_URI . '/includes/helpers/gutenberg/blocks.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
	);
	wp_enqueue_style( 
		'hcc-myguten-style', 
		THEME_STYLE_URI . '/assets/public/gtb.min.css'
	);
}
