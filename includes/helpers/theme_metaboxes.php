<?php
/*
* Metaboxes scripts
*
*/
/*
* Hide some metaboxes
*
*/
add_action('admin_menu','hcc_remove_default_post_screen_metaboxes');
function hcc_remove_default_post_screen_metaboxes() {
	// posts
	//remove_meta_box( 'postcustom','post','normal' );
	remove_meta_box( 'postexcerpt','post','normal' );
	remove_meta_box( 'commentstatusdiv','post','normal' );
	remove_meta_box( 'trackbacksdiv','post','normal' ); 
	remove_meta_box( 'slugdiv','post','normal' );
	remove_meta_box( 'authordiv','post','normal' );
 
	// pages
	//remove_meta_box( 'postcustom','page','normal' );
	remove_meta_box( 'postexcerpt','page','normal' ); 
	remove_meta_box( 'commentstatusdiv','page','normal' );
	remove_meta_box( 'trackbacksdiv','page','normal' );
	remove_meta_box( 'slugdiv','page','normal' );
	remove_meta_box( 'authordiv','page','normal' ); 
}

/*
*  Remove "All terms" and "Often terms" metabox
*
*/
add_action('admin_print_footer_scripts', 'hcc_hide_tax_metabox_tabs_admin_styles', 99);
function hcc_hide_tax_metabox_tabs_admin_styles(){
	$cs = get_current_screen();
	if( $cs->base !== 'post' || empty($cs->post_type) ){
        return false;
    }?>
	<style>
		.postbox div.tabs-panel{ max-height:1200px; border:0; }
		.category-tabs{ display:none; }
	</style>
	<?php
}

/*
*  Hierarhical terms in metabox
*
*/
add_filter( 'wp_terms_checklist_args', 'hcc_set_checked_ontop_default', 10 );
function hcc_set_checked_ontop_default( $args ) {
	
	if( ! isset($args['checked_ontop']) )
		$args['checked_ontop'] = false;
 
	return $args;
}

/*
* Edit console widget "Now"
*
*/
add_action( 'dashboard_glance_items' , 'add_right_now_info' );
function add_right_now_info( $items ){
 
	if( ! current_user_can('edit_posts') ){
         return $items;
    }
    //post types
	$args = array( 'public' => true, '_builtin' => false );
	$post_types = get_post_types( $args, 'object', 'and' );
 
	foreach( $post_types as $post_type ){
		$num_posts = wp_count_posts( $post_type->name );
		$num       = number_format_i18n( $num_posts->publish );
		$text      = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
 
		$items[] = "<a href=\"edit.php?post_type=$post_type->name\">$num $text</a>";
	}
 
	// terms
	$taxonomies = get_taxonomies( $args, 'object', 'and' );
 
	foreach( $taxonomies as $taxonomy ){
		$num_terms = wp_count_terms( $taxonomy->name );
		$num       = number_format_i18n( $num_terms );
		$text      = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ) );
 
		$items[] = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num $text</a>";
	}
 
	// users
	global $wpdb;
 
	$num  = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
    $num  = $num - 1;
	$text = _n( __('User', 'hcc'), __('Users', 'hcc'), $num );
 
	$items[] = "<a href='users.php'>$num $text</a>";
 
	return $items;
}

/*
* Disable pings
*
*/
add_action('pre_ping', 'hcc_disable_inner_ping');
function hcc_disable_inner_ping( &$links ){
	foreach( $links as $k => $val )
		if( false !== strpos( $val, str_replace('www.', '', $_SERVER['HTTP_HOST']) ) ) 
			unset( $links[$k] );
}

/*
* Add thumbs column in admin panel
*
*/
add_action('init', 'hcc_add_post_thumbs_in_post_list_table', 20 );
function hcc_add_post_thumbs_in_post_list_table(){
		$supports = get_theme_support('post-thumbnails');
		if( ! isset($ptype_names) ){
			if( $supports === true ){
				$ptype_names = get_post_types(array( 'public'=>true ), 'names');
				$ptype_names = array_diff( $ptype_names, array('attachment') );
			}
			elseif( is_array($supports) ){
				$ptype_names = $supports[0];
			}
		}
		foreach( $ptype_names as $ptype ){
			add_filter( "manage_{$ptype}_posts_columns", 'add_thumb_column' );
			add_action( "manage_{$ptype}_posts_custom_column", 'add_thumb_value', 10, 2 );
		}
	}
 
// add column
function add_thumb_column( $columns ){
		add_action('admin_notices', function(){
			echo '
			<style>
				.column-thumbnail{ width:100px; text-align:center; }
			</style>';
		});
 
		$num = 1;
		$new_columns = array( 'thumbnail' => __('Thumbnail') );
		return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}
 
// column body
function add_thumb_value( $colname, $post_id ){
		if( 'thumbnail' == $colname ){
			$width  = $height = 45;

			if( $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true ) ){
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			elseif( $attachments = get_children( array(
				'post_parent'    => $post_id,
				'post_mime_type' => 'image',
				'post_type'      => 'attachment',
				'numberposts'    => 1,
				'order'          => 'DESC',
			) ) ){
				$attach = array_shift( $attachments );
				$thumb = wp_get_attachment_image( $attach->ID, array($width, $height), true );
			}
 
			echo empty($thumb) ? ' ' : $thumb;
		}
}