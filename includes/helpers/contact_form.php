<?php
/*
 *	File for email form 
 * 
 */
?>
<?php 
add_action( 'wp_ajax_hcc_ajax', 'ajax_mail_function' ); // wp_ajax_{ACTION!!}
add_action( 'wp_ajax_nopriv_hcc_ajax', 'ajax_mail_sending_function' ); // wp_ajax_nopriv_{ACTION!!}
function ajax_mail_sending_function(){
    
    //Sending function
    function AjaxSendMail(){
        //Variables
        $headers      = "Content-type: text/html; charset=utf-8\r\n";
        $sitename     = get_bloginfo('name');
        $option       = get_option('hcc-theme-cf-email');
        if( !empty( $option ) ){
            $admin_email = htmlspecialchars( trim( $option ) );
        }
        else{
            $admin_email  = htmlspecialchars( trim( get_bloginfo('admin_email') ) );
        }
        $subject      = __('Message from the site ', 'hcc') . $sitename;
        $_POST        = empty($_POST) ? $_GET : $_POST;
        $message = '<html>
                        <head>
                         <meta charset="UTF-8">
                         <title>' . __('Feedback form','hcc') . '</title>
                    </head>
                        <body style="width:94%; height:auto;">
                        <table style="width:100%; max-width:600px;height:auto;vertical-align: middle;border-color:#000;border:0px;border-style:solid;border-spacing:unset;padding:0;" summary="' . __("Application form", "hcc") . '" rules="none" frame="border" cellpadding="0" cellspacing="0">
                            <caption align="justify" style="height: 45px;">
                                <h2 style="margin: 5px;font-size: 1.5rem;">' . __('Letter','hcc') . '</h2>
                            </caption>
                            <thead align="justify" style="background-color:#ddd;border-color:#000;border:1px;border-style:solid;">
                                <tr style="height: 30px;">
                                    <td align="center" style="width:100%;" colspan="4">
                                        <h3 style="margin:5px;font-size: 1.1rem;">' . $subject . '</h3>
                                    </td>
                                </tr>
                            </thead>
                            <tbody style="font-size: 1rem;">';
        
        foreach ($_POST['data'] as $key => $value) {
            $postData[ $value['name'] ] = trim( $value['value'] );
        }
        
        if( !empty( $postData['comment'] ) || !empty( $postData['message'] ) ){
            exit;
        }
        
        FindErrors( $postData );
        
        foreach ($postData as $key => $value) {
            if( $key === 'comment' || $key === 'message' ){}
            elseif( $key === 'question' ){
                $message .= '<tr style="height:30px;width:auto;border-bottom: 1px solid black;">
                                <td colspan="4" align="center">' . __('Message', 'hcc') . ':</td>
                            </tr>
                            <tr style="height:30px;width:auto;border-bottom: 1px solid black;">
                                <td colspan="4" align="center">
                                    '. htmlspecialchars( $value ) .'
                                </td>
                            </tr>';
            }
            else{
                $message .= '<tr style="height:30px;width:auto;border-bottom: 1px solid black;">
                    <td style="border-right: 1px solid #ccc;padding-left:25px;">' . __( ucfirst( $key ), 'hcc' ) . ':</td>
                    <td style="border-left: 1px solid #ccc;padding-left:25px;">
                        '. htmlspecialchars( $value ) .'
                    </td>
                </tr>';
            }
        }
        
        $message .= '</tbody></table></body></html>';
        
        //Sending
        if( !empty( $postData['name'] ) && !empty( $postData['phone'] ) ){
            if( function_exists( 'wp_mail' ) && false){
                wp_mail($admin_email, $subject, $message, $headers);
            }
            else{
                mail($admin_email, $subject, $message, $headers);
            }
        }

        //Exit
        die();    
    }
    
    //Save mails in WP panel
    function MailsSavePanel(){
        
        //Variables
        $_POST        = empty($_POST) ? $_GET : $_POST;
        $message      = '';
        
        foreach ($_POST['data'] as $key => $value) {
            $postData[ $value['name'] ] = trim( $value['value'] );
        }
        
        if( !empty( $postData['comment'] ) || !empty( $postData['message'] ) ){
            exit;
        }
        FindErrors( $postData );
        
        foreach ($postData as $key => $value) {
            if( $key === 'comment' || $key === 'message' ){}
            elseif( $key === 'name' ){
                $user_name = __('Name', 'hcc') . ': ' . htmlspecialchars( $value );
            }
            else{
                $message .= '<b>' . __( ucfirst( $key ), 'hcc' ) . ':</b><br/>' . htmlspecialchars( $value ) . '<br/>';
            }
        }
        
        $post_data = array(
           'post_title'    => $user_name,
           'post_content'  => $message,
           'post_status'   => 'publish',
           'post_author'   => 1,
           'post_type' => 'saved_mail',
        );
        wp_insert_post( $post_data );
    }
    
    //Backend validation
    function FindErrors( $postData ){
        $error = ['error'=> false ,'errors'=>[]];
        
        if( !isset( $postData['name'] ) || !preg_match( '/^[a-zA-Zа-яА-ЯІіЁёґҐєЄїёЁЇ\\d\(\)ʼ’\'\"\s\-]{3,}$/u', $postData['name'] ) ) {
			$error['error'] = true;
			$error['errors']['name'] = __('Неверное имя','hcc');
		}
        if( !isset($postData['phone'])|| empty($postData['phone']) || strlen($postData['phone'])< 6 ) {
			$error['error'] = true;
			$error['errors']['phone'] = __('Неверный телефон', 'hcc');
		}
        if( isset( $postData['email'] ) && !preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $postData['email'])) {
			$error['error'] = true;
			$error['errors']['email'] = __('Неверный email', 'hcc');
		} 
        if( $error['error'] ){
            echo json_encode($error);   
        }
    }
    
    $save_panel = get_option('hcc-theme-cf-panel-save');
    if( !empty( $save_panel ) ){
        MailsSavePanel(); // Saving in admin panel as post type
    }
    
    AjaxSendMail(); // Sending mail
}

//Create custom post type for saving in WP panel
add_action( 'init', 'cpt_mail_calback' );
function cpt_mail_calback() {
     $save_panel = get_option('hcc-theme-cf-panel-save');
     if( !empty( $save_panel ) ){
        $labels = array(
                "name" => __("Mail", "hcc"),
                "singular_name" => __("Mail", "hcc"),
                "menu_name" => __("Mail", "hcc"),
                "all_items" => __("All mail", "hcc"),
                "add_new" => __("Add New", "hcc"),
                "add_new_item" => __("Add New", "hcc"),
                "edit" => __("Edit", "hcc"),
                "edit_item" => __("Edit", "hcc"),
                "new_item" => __("New item", "hcc"),
                "view" => __("View", "hcc"),
                "view_item" => __("View item", "hcc"),
                "search_items" => __("Search item", "hcc"),
                "not_found" => __("Not found", "hcc"),
                "not_found_in_trash" => __("Not found", "hcc"),
          );

          $args = array(
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "show_ui" => true,
                "has_archive" => false,
                "show_in_menu" => true,
                "exclude_from_search" => true,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => true,
                "rewrite" => false,
                "query_var" => true,
                "menu_position" => 7,
                "menu_icon" => "dashicons-email-alt",
                "supports" => array( "title", "editor" ),
           );

           register_post_type( "saved_mail", $args );   
           add_filter('use_block_editor_for_cpt_mail_calback', '__return_false', 10);
     }      
}
