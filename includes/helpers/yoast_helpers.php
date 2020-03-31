<?php
/**
 * Yoast: remove images with XML map
 *
 */
add_filter( 'wpseo_xml_sitemap_img', '__return_false' );

/**
 * Yoast: new separators
 *
 */
//add_filter( 'wpseo_separator_options', 'hcc_add_new_separator' );
function hcc_add_new_separator( $separators ) {

	$separators_new = [
		'sc-flore'       => '✿',
		'sc-air'         => '✈',
		'sc-drive'       => '✇',
		'sc-skull'       => '☠',
		'sc-anchor'      => '⚓',
		'sc-circle-star' => '✯',
		'sc-gier'        => '⚙',
	];

	$separators = array_merge( $separators, $separators_new );
    return $separators;
}

/**
 * Yoast: remove last element in breadcrumbs
 *
 */
//add_filter( 'wpseo_breadcrumb_single_link', 'hcc_remove_wpseo_breadcrumb_last' );
function hcc_remove_wpseo_breadcrumb_last( $link_output ) {

	if ( false !== strpos( $link_output, 'breadcrumb_last' ) ) {
		$link_output = '';
	}
	return $link_output;
}