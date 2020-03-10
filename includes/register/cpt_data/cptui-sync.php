<?php
/**
 * Saves post type and taxonomy data to JSON and PHP files in the theme directory from CPT UI plugin.
 *
 * If CPT UI plugin is absent or deactivated pulls data from php files.
 *
 * @param array $data Array of post type data that was just saved.
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// check for plugin using plugin name
if ( !is_plugin_active( 'custom-post-type-ui/custom-post-type-ui.php' ) ) {
    include_once(THEME_STYLE.'/includes/cpt_data/register/custom_post_types.php');
    include_once(THEME_STYLE.'/includes/cpt_data/register/custom_taxonomies.php');
} 

function pluginize_local_cptui_data( $data = array() ) {
    $theme_dir = THEME_STYLE;
    // Create our directory if it doesn't exist.
    if ( ! is_dir( $theme_dir .= '/includes/register/cpt_data' ) ) {
        mkdir( $theme_dir, 0755 );
    }

    if ( array_key_exists( 'cpt_custom_post_type', $data ) ) {
        // Fetch all of our post types and encode into JSON.
        $cptui_post_types = get_option( 'cptui_post_types', array() );
        $content = json_encode( $cptui_post_types );
        // Save the encoded JSON to a primary file holding all of them.
        file_put_contents( $theme_dir . '/cptui_post_type_data.json', $content );

        $content2 = '<?php';
        foreach ( $cptui_post_types as $type ) {
            ob_start();
            cptui_get_single_post_type_registery( $type );
            $content2 .= ob_get_clean();
        }
        file_put_contents( $theme_dir . '/custom_post_types.php', $content2 );
    }

    if ( array_key_exists( 'cpt_custom_tax', $data ) ) {
        // Fetch all of our taxonomies and encode into JSON.
        $cptui_taxonomies = get_option( 'cptui_taxonomies', array() );
        $content = json_encode( $cptui_taxonomies );
        // Save the encoded JSON to a primary file holding all of them.
        file_put_contents( $theme_dir . '/cptui_taxonomy_data.json', $content );

        $content2 = '<?php';
        foreach ( $cptui_taxonomies as $type ) {
            ob_start();
            cptui_get_single_taxonomy_registery( $type );
            $content2 .= ob_get_clean();
        }
        file_put_contents( $theme_dir . '/custom_taxonomies.php', $content2 );
    }
}
add_action( 'cptui_after_update_post_type', 'pluginize_local_cptui_data' );
add_action( 'cptui_after_delete_post_type', 'pluginize_local_cptui_data' );
add_action( 'cptui_after_update_taxonomy', 'pluginize_local_cptui_data' );
add_action( 'cptui_after_delete_taxonomy', 'pluginize_local_cptui_data' );

