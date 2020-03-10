<?php 
// declare woocommerce support
function hcc_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'hcc_add_woocommerce_support' );

// see origin/woocommerce.php file for original underscores functions
/**
 * WooCommerce setup function.
 *
 */
function hcc_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'hcc_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 */
function hcc_woocommerce_scripts() {
	wp_enqueue_style( 'ccz-woocommerce-style', THEME_URI . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'hcc-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'hcc_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 */
function hcc_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'hcc_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 */
function hcc_woocommerce_products_per_page() {
	return 12;
}
//add_filter( 'loop_shop_per_page', 'hcc_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 */
function hcc_woocommerce_thumbnail_columns() {
	return 4;
}
//add_filter( 'woocommerce_product_thumbnails_columns', 'hcc_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 */
function hcc_woocommerce_loop_columns() {
	return 3;
}
//add_filter( 'loop_shop_columns', 'hcc_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function hcc_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'hcc_woocommerce_related_products_args' );

if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper() {
		$columns = ccz_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'hcc_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'hcc_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'hcc_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function hcc_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'hcc_woocommerce_wrapper_before' );

if ( ! function_exists( 'hcc_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function hcc_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'hcc_woocommerce_wrapper_after' );