<?php 
/*
* This file register post type for Instagram posts & Portfolio
* 
*/
require_once(ABSPATH . '/wp-admin/includes/file.php');
require_once(ABSPATH . '/wp-admin/includes/media.php');
require_once(ABSPATH . '/wp-admin/includes/image.php' );

add_action( 'init', 'register_inst_post_type' );
function register_inst_post_type() {
    $instagram_type = get_field('instagram_include_type', 'options');
    if( !empty( $instagram_type ) && $instagram_type === 'php' ){
        
         $labels = array(
                "name" => __("Портфолио", "hcc"),
                "singular_name" => __("Портфолио", "hcc"),
                "menu_name" => __("Портфолио", "hcc"),
                "all_items" => __("Все портфолио", "hcc"),
                "add_new" => __("Добавить", "hcc"),
                "add_new_item" => __("Добавить", "hcc"),
                "edit" => __("Редактировать", "hcc"),
                "edit_item" => __("Редактировать", "hcc"),
                "new_item" => __("Новый", "hcc"),
                "view" => __("Смотреть", "hcc"),
                "view_item" => __("Смотреть запись", "hcc"),
                "search_items" => __("Искать записи", "hcc"),
                "not_found" => __("Не найдено", "hcc"),
                "not_found_in_trash" => __("Не найдено", "hcc"),
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
                "rewrite" => true,
                'slug' => 'new prefix',
                'with_front' => true,
                'feeds' => true,
                'pages' => true,
                "query_var" => true,
                "menu_position" => 5,
                "menu_icon" => "dashicons-admin-post",
                "supports" => array( "title", "editor", "thumbnail", "custom-fields" ),
           );

            $register = register_post_type( "portfolio", $args ); 
            if( is_wp_error( $register ) ){
                echo $register->get_error_message('fallen');
            }
            add_filter('use_block_editor_for_portfolio', '__return_false', 10);
    }
}

function portfolio_error( $some = false ){
	if( !$some )
		return new WP_Error('fallen', __('Ошибка при добавлении поста портфолио', 'hcc'));
	else
		return true;
}

function portfolio_download_error( $some = false ){
	if( !$some )
		return new WP_Error('fallen', __('Ошибка при загрузке изображения портфолио', 'hcc'));
	else
		return true;
}

function portfolio_save_error( $some = false ){
	if( $some )
		return new WP_Error('fallen', __('Ошибка при сохранении изображения портфолио', 'hcc'));
	else
		return true;
}

function insertPortfolio( $title, $alt, $url, $meta_id ){
    try{
        if( empty( $title) || empty( $alt ) || empty( $url ) || empty( $meta_id ) ){
            throw new Exception( __('Получен пустой параметр функции сохранения портфолио, критично', 'hcc') );
        }
    }
    catch (Exception $e) {
            echo $e->getMessage(), "\n";
    }
    
    $post    = get_page_by_title( $title, ARRAY_A, 'portfolio' );
    $post_id = $post['ID'];
    $meta_id = get_post_meta( $post_id, 'meta_id', true );
    
    if( ( !empty( $post['post_title'] ) && !empty( $post_id ) ) || ( $meta_id !== false ) ){
        $post_data = wp_slash( array(
                   'ID'            => $post_id,
                   'post_title'    => $title,
                   'post_content'  => $alt,
                   'post_status'   => 'publish',
                   'post_author'   => 1,
                   'meta_input'    => array( 'meta_id'=>$meta_id ),
                   'post_type'     => 'portfolio',
        ) );
    }
    else{
        $post_data = wp_slash( array(
                   'post_title'    => $title,
                   'post_content'  => $alt,
                   'post_status'   => 'publish',
                   'post_author'   => 1,
                   'meta_input'    => array( 'meta_id'=>$meta_id ),
                   'post_type'     => 'portfolio',
        ) );
    }
    
    $new_portfolio = wp_insert_post( $post_data );
    $return        = portfolio_error( $new_portfolio );
    if( is_wp_error( $return ) ){
        echo $return->get_error_message('fallen');
    }

    if( $post_id ){
        downloadPortfolioImg( $url, $post_id );
    }
}

function downloadPortfolioImg( $url, $post_id ){
    $tmp    = download_url( $url );
    $tmp_er = portfolio_download_error( $tmp );
    
    if( is_wp_error( $tmp_er ) ){
        echo $tmp_er->get_error_message('fallen');
    }
    else{
        $file = array(
            'name'     =>  basename($url) . '.jpg',
            'type'     => 'image/jpeg',
            'tmp_name' => $tmp,
            'error'    => 0,
            'size'     => filesize($tmp),
        );
        $overrides = array( 'test_form' => false, );
        $results   = wp_handle_sideload( $file, $overrides );
        $error     = portfolio_save_error( $results['error'] );
        
        if( !empty($results['error']) || is_wp_error( $error ) ){
            echo $results['error'];
            echo '<br/>';
            echo $error->get_error_message('fallen');
            echo '<br/>';
        }
        else{
            $filename  = $results['file'];
		    $local_url = $results['url'];
		    $type      = $results['type'];

            if( $filename && $local_url && $type && $post_id ){
                SetPortfolioImg( $filename, $local_url, $type, $post_id );
            }
        }
    }
	@ unlink( $tmp );
}

function SetPortfolioImg( $filename, $local_url, $type, $post_id ){
    try{
        $wp_upload_dir = wp_upload_dir();
        $type          = $type ? $type : wp_check_filetype( $filename );
        $local_url     = $local_url ? $local_url : $wp_upload_dir['url'] . '/' . basename( $filename );
        $title         = preg_replace( '/\.[^.]+$/', '', basename( $filename ) );
        
        if( empty( $wp_upload_dir ) || empty( $type ) || empty( $local_url ) || empty( $title ) ){
            throw new Exception( __('Получен пустой параметр функции установки изображения портфолио, критично', 'hcc') );
            return false;
        }
        
        $attachment = array(
            'guid'           => $local_url, 
            'post_mime_type' => $type,
            'post_title'     => $title,
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
    }
    catch (Exception $e) {
            echo $e->getMessage(), "\n";
    }
    
    $attach_id   = wp_insert_attachment( $attachment, $filename, $post_id );
    if( is_wp_error( $attach_id ) ){
                echo $attach_id->get_error_message('fallen');
    }
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    if( is_wp_error( $attach_data ) ){
                echo $attach_data->get_error_message('fallen');
    }
    $metadata = wp_update_attachment_metadata( $attach_id, $attach_data );
    if( $metadata && has_post_thumbnail( $post_id ) ){
        wp_delete_attachment( get_post_thumbnail_id( $post_id ), false );
    }
    $set_img  = set_post_thumbnail( $post_id, $attach_id );
    if( is_wp_error( $set_img ) ){
                echo $set_img->get_error_message('fallen');
    }
}