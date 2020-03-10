<?php
/**
 * HCC functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/* -- defines -- */
get_template_part('includes/vars');
/* -- register -- */
get_template_part('includes/register/register_scripts');
get_template_part('includes/register/register_menus');
get_template_part('includes/register/menu_walker');
get_template_part('includes/register/register_widgets');
if ( is_plugin_active( 'custom-post-type-ui/custom-post-type-ui.php' ) ) {
   get_template_part('includes/register/cpt_data/cptui-sync.php');
}
get_template_part('includes/register/register_post_types');
get_template_part('includes/register/register_taxonomies');
get_template_part('includes/register/register_image_sizes');

/* -- helpers -- */
get_template_part('includes/helpers/theme_helpers');
get_template_part('includes/helpers/theme_ajax');
if ( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
    get_template_part('includes/helpers/contact_form');
}
get_template_part('includes/helpers/acf_helpers');
get_template_part('includes/helpers/aq_resizer');
get_template_part('includes/helpers/gutenberg/gutenberg'); 
get_template_part('includes/helpers/instagram'); 
    
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) || in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   get_template_part('includes/helpers/woo_helpers');
}  

/* -- config -- */
get_template_part('includes/config/hcc_setup');
get_template_part('includes/config/admin/general-edits');
get_template_part('includes/config/admin/theme-options');

/* -- Include GTM -- */
require 'includes/gtm/class-tgm-plugin-activation.php';
require 'includes/gtm/plugins.php'; !
    
//Find BOM
require_once('includes/find_bom.php');


