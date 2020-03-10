<?php 

add_action( 'after_setup_theme', 'hcc_setup' );
if ( ! function_exists( 'hcc_setup' ) ) :
	function hcc_setup() {
		load_theme_textdomain( 'ccz', THEME . '/languages' );
        add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
            'height'      => 57,
	        'width'       => 168,
			'flex-width'  => true,
			'flex-height' => true,
            'header-text' => '',
		) );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
    }
endif;

/**
 * Disable the confirmation notices when an administrator
 * changes their email address.
 *
 * @see http://codex.wordpress.com/Function_Reference/update_option_new_admin_email
 */
function wpdocs_update_option_new_admin_email( $old_value, $value ) {
    update_option( 'admin_email', $value );
}
add_action( 'add_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );
add_action( 'update_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );

/**
 * No slash in th end of URL
 *
 * @see http://codex.wordpress.com/Function_Reference/update_option_new_admin_email
 */
add_filter('user_trailingslashit', 'no_page_slash', 70, 2);
function no_page_slash( $string, $type ){
   global $wp_rewrite;
	if( $type == 'page' && $wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes )
		$string = untrailingslashit($string);
   return $string;
}

/**
 * Is mobile device
 *
 */
function is_mobile(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if(
		// добавить '|android|ipad|playbook|silk' в первую регулярку для определения еще и tablet
		preg_match(
			'/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i|android|ipad|playbook|silk',
			$useragent
		)
		||
		preg_match(
			'/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
			substr($useragent,0,4)
		)
	)
		return true;
	return false;   
}
/**
 * This debug function show code names of admin pages
 *
 */
//add_action( 'admin_init', 'wpse_136058_debug_admin_menu' );
function wpse_136058_debug_admin_menu() {
    echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre><style>#adminmenuback{background:transparent!important}</style>';
}

/**
 * Remove admin pages
 *
 */
function remove_menus(){
    remove_menu_page( 'edit.php' ); 
    remove_menu_page( 'users.php' );
    remove_menu_page( 'edit-comments.php' );   
    remove_menu_page('wpcf7');
    remove_menu_page( 'cptui_main_menu' ); 
    remove_menu_page( 'smush' ); 
    remove_menu_page( 'edit.php?post_type=acf-field-group' ); 
}
add_action( 'admin_menu', 'remove_menus' );

/**
 * No robots
 *
 */
add_action('wp_head', 'meta_robots');
function meta_robots () {
    if ( !is_page() && !is_attachment() ){
        echo "".'<meta name="robots" content="noindex,nofollow" />'."\n";
    } 
}

/**
 * disable scrset & sizes for images
 *
 */
remove_filter( 'the_content', 'wp_make_content_images_responsive' );

get_template_part('includes/helpers/security_helpers');