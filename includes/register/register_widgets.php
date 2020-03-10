<?php
/*
* Disable some default widgets
*/
function hcc_remove_default_widget() {
	unregister_widget('WP_Widget_Archives'); 
	unregister_widget('WP_Widget_Calendar'); 
	//unregister_widget('WP_Widget_Categories'); 
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Comments');
	//unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_RSS');
	//unregister_widget('WP_Widget_Search');
	//unregister_widget('WP_Widget_Tag_Cloud');
	//unregister_widget('WP_Widget_Text'); 
	//unregister_widget('WP_Nav_Menu_Widget');
}
 
add_action( 'widgets_init', 'hcc_remove_default_widget', 20 );

/*
* Register sidebars
*/
function hcc_register_sidebars(){
    $args = array(
        'name'          => __('Sidebar', 'hcc') . ' %d',
        'id'            => "sidebar-%d",
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<p class="widgettitle">',
        'after_title'   => '</p>' 
    );
    register_sidebars( 2, $args );
}

//add_action( 'init', 'hcc_register_sidebars' );