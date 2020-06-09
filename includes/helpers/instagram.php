<?php 
/**
*  Intagram feed on site.
*  This file need ACF for coorect work
*/
?>
<?php
/**
*  Add Instagram subpage
*
*/
add_action('init', 'hcc_inst_init');
function hcc_inst_init() {
    if( function_exists('acf_add_options_sub_page') ) {
        $instagram_page = acf_add_options_sub_page(array(
                    'page_title'	=> __('Instagram settings', 'hcc'),
                    'menu_title'	=> __('Instagram', 'hcc'),
                    'parent_slug'	=> 'theme-general-settings',
        ));
    }
}

/**
*  Add Instagram settings
*
*/

$instagram_api  = get_field('instagram_api', 'options');
$instagram_type = get_field('instagram_include_type', 'options');

require_once('instagram/register_portfolio.php');

if( !empty( $instagram_api ) && $instagram_api === 'disable' ){
    
    if( !empty( $instagram_type ) && $instagram_type === 'js' ){
        /*
        * This file include js version of Instagram page parse without Instagram API
        * 
        */
        add_action( 'get_footer', 'hcc_add_inst_scripts' );
        function hcc_add_inst_scripts() {
            $options = get_field('inst_js_api_disabled', 'options');
            wp_register_script( 'instagramFeed', THEME_URI . '/assets/public/jquery.instagramFeed.min.js', array('jquery'), '', true );
            wp_localize_script( 'theme-js', 'hcc_instagram_params', array(
                'name' => $options['name']   ? wp_kses_post( trim( $options['name'] ) ) : null,
                'tag'  => $options['tag']    ? wp_kses_post( trim( $options['tag'] ) ) : null,
                'items'=> $options['items']  ? wp_kses_post( trim( $options['items'] ) ) : 6,
                'row'  => $options['row']    ? wp_kses_post( trim( $options['row'] ) ) : 3,
                'host' => $options['host']   ? wp_kses_post( trim( $options['host'] ) ) : 'https://www.instagram.com/',
            ));
            wp_enqueue_script( 'instagramFeed');
        }
        
    }
    
    if( !empty( $instagram_type ) && $instagram_type === 'php' ){
             /*
              * This file include php version of Instagram page parse without Instagram API
              * 
              */
            $options = get_field('inst_php_api_disabled', 'options');
            $host    = $options['host']   ? wp_kses_post( trim( $options['host'] ) ) : 'https://www.instagram.com/';
            $name    = $options['name']   ? wp_kses_post( trim( $options['name'] ) ) : null;
            require_once('instagram/inst_php_parser.php');
        
             /*
              * WP cron task
              * 
              */
            $hook_settings = array( $host, $name );
            if( !wp_next_scheduled('instagram_copy_content', $hook_settings ) ){
                $event = wp_schedule_event( time(), 'every_48_hours', 'instagram_copy_content', $hook_settings );
                if( is_wp_error( $event ) ){
                            echo $event->get_error_message('fallen');
                }
            }
            
            add_action( 'instagram_copy_content', 'hcc_inst_php_get_page', 10, 3 );
    }
    
}

if( !empty( $instagram_api ) && $instagram_api === 'enable' ){
    
    if( !empty( $instagram_type ) && $instagram_type === 'js' ){
            /*
            * This file include js version of Instagram page parse with Instagram API : DEMO
            * 
            */
            add_action( 'get_footer', 'hcc_add_inst_scripts' );
            function hcc_add_inst_scripts() {
                $options = get_field('inst_js_api_enabled', 'options');
                $token   = $options['token'];
                if( empty( $token ) ){
                    
                    $settings = get_filed('main_options');
                     /*
                      * WP cron task
                      * 
                      */
                    $hook_settings = array( $settings );
                    if( !wp_next_scheduled('instagram_get_token', $hook_settings ) ){
                        $token = wp_schedule_event( time(), 'every_48_hours', 'instagram_get_token', $hook_settings );
                        if( is_wp_error( $token ) ){
                                    echo $token->get_error_message('fallen');
                        }
                    }

                    add_action( 'instagram_get_token', 'hcc_get_api_token', 10, 3 );
                    
                }
                wp_register_script( 'instagramFeed', THEME_URI . '/assets/public/instApi.min.js', array('jquery'), '', true );
                wp_localize_script( 'theme-js', 'hcc_instagram_params', array(
                    'name' => $options['name']   ? wp_kses_post( trim( $options['name'] ) ) : null,
                    'tag'  => $options['tag']    ? wp_kses_post( trim( $options['tag'] ) ) : null,
                    'items'=> $options['items']  ? wp_kses_post( trim( $options['items'] ) ) : 6,
                    'row'  => $options['row']    ? wp_kses_post( trim( $options['row'] ) ) : 3,
                    'host' => $options['host']   ? wp_kses_post( trim( $options['host'] ) ) : 'https://api.instagram.com/',
                    'token'=> $token  ? hcc_encode( wp_kses_post( trim( $token ) ) ) : null,
                ));
                wp_enqueue_script( 'instagramFeed');
            }
    }
    
    if( !empty( $instagram_type ) && $instagram_type === 'php' ){
            /*
              * This file include php version of Instagram page parse with Instagram API : DEMO
              * 
              */
            $options = get_field('inst_php_api_enabled', 'options');
            $host    = $options['host']   ? wp_kses_post( trim( $options['host'] ) ) : 'https://api.instagram.com/';
            $name    = $options['name']   ? wp_kses_post( trim( $options['name'] ) ) : null;
            $limit   = $options['limit']  ? wp_kses_post( trim( $options['limit'] ) ) : 12;
            $token   = $options['token']  ? wp_kses_post( trim( $options['token'] ) ) : null;
            
            if( empty( $token ) ){
                
                $settings = get_filed('main_options');
                 /*
                  * WP cron task
                  * 
                  */
                $hook_settings = array( $settings );
                if( !wp_next_scheduled('instagram_get_token', $hook_settings ) ){
                    $token = wp_schedule_event( time(), 'every_48_hours', 'instagram_get_token', $hook_settings );
                    if( is_wp_error( $token ) ){
                                echo $token->get_error_message('fallen');
                    }
                }

                add_action( 'instagram_get_token', 'hcc_get_api_token', 10, 3 );

            }
            else{
                
                 /*
                  * WP cron task
                  * 
                  */
                $hook_settings = array( $token, $host, $name, $limit );
                if( !wp_next_scheduled('instagram_get_data', $hook_settings ) ){
                    $data = wp_schedule_event( time(), 'every_48_hours', 'instagram_get_data', $hook_settings );
                    if( is_wp_error( $data ) ){
                                echo $data->get_error_message('fallen');
                    }
                }

                add_action( 'instagram_get_data', 'hcc_get_api_data', 10, 3 );

            }
        
            if( !empty( $data ) ){
                $count = 1;
                foreach( array_slice($data->data, 0, $limit) as $post ) {

                      $post_text  = wp_slash( trim( $post->caption->text ) );
                      $post_text  = preg_replace('~#\S+\s+~', '', $post_text);
                      $post_text  = preg_replace('/(#\w+)/', '', $post_text);
                      $post_text  = preg_replace('~@\S+\s+~', '', $post_text);
                      $post_text  = wp_kses($post_text, 'strip');
                      $post_title = trim(  __('Инстаграм портфолио', 'hcc') . ' ' . $count );
                      $post_id    = trim( wp_kses( $post->id, 'strip' ) );
                      $post_image = trim( $post->images->standard_resolution->url );
                      $count++;

                }   
            }
             /*
              * WP cron task
              * 
              */
            $hook_settings = array( $post_title, $post_text, $post_image, $post_id );
            if( !wp_next_scheduled('instagram_copy_content', $hook_settings ) ){
                $event = wp_schedule_event( time(), 'every_48_hours', 'instagram_copy_content', $hook_settings );
                if( is_wp_error( $event ) ){
                            echo $event->get_error_message('fallen');
                }
            }
            
            add_action( 'instagram_copy_content', 'insertPortfolio', 10, 3 );
    }
    
}

/*
 * Encrypt Function : base85 code mode
 *
 */
function hcc_encode($t) {
  $l = strlen($t); 
  $o = 4-($l%4); 
  $l+= $o; 
  $t.= "zzzz";
    
  for($i=0; $i < $l; $i+=4){
        $n=unpack("N",substr($t,$i,4))[1];
        for($j=0; $j<5; $j++){
            $o.=(chr($n%85+42));
            $n=(int)($n/85);
        }   
  }
  return str_replace('\\', '!', $o);
}

/*
 *  get Instagram API token with cURL session
 *
 */

function hcc_get_api_token( $settings ){
    try{
                    
                    if( $settings ){
                        $settings = get_filed('main_options');
                        $fields = array(
                            'client_id'     => $settings['client_id'],
                            'client_secret' => $settings['client_key'],
                            'grant_type'    => 'authorization_code',
                            'redirect_uri'  => $settings['redirect'] ? $settings['redirect'] : get_home_url('/'),
                            'code'          => $settings['client_code'],
                        );
                        if( empty( $fields['client_id'] ) || empty( $fields['client_secret'] ) || empty( $fields['grant_type'] ) || empty( $fields['redirect_uri'] ) || empty( $fields['code'] ) ){
                            throw new Exception( __('Невозможно выполнить запрос cURL: неверные параметры запроса', 'hcc') );
                            return false;
                        }
                    }
                    else{
                        throw new Exception( __('Невозможно выполнить запрос cURL: неверные параметры запроса', 'hcc') );
                        return false;
                    }
                    
                    $url   = 'https://api.instagram.com/oauth/access_token';
                    if( empty( $url ) ){
                        throw new Exception( __('Невозможно выполнить запрос cURL: неверный URL', 'hcc') );
                        return false;
                    }
                    $token = hcc_get_instagram_api_token( $url, $fileds );
                    if( $token === 'Error' ){
                        throw new Exception( __('Невозможно выполнить запрос cURL', 'hcc') );
                        return false;
                    }
                }
        catch (Exception $e) {
                       echo $e->getMessage(), "\n";
        }
        return $token;
}

/*
 *  get InstagramAPI data with cURL session
 *
 */

function hcc_get_api_data( $token, $host, $name, $limit ){
    try{
                    if( empty( $token ) ){
                        throw new Exception( __('Невозможно выполнить запрос cURL: token отсутствует', 'hcc') );
                        return false;
                    }
                    if( empty( $host ) || empty( $name ) || empty( $limit ) ){
                        throw new Exception( __('Невозможно выполнить запрос cURL: неверные параметры запроса', 'hcc') );
                        return false;;
                    }
                    $link = $host . "v1/users/" . $name . "/media/recent?access_token=" . $token . "&count=" . $limit;
                    if( empty( $link ) ){
                        $link = 'https://graph.instagram.com/' . $name . '?fields=id,media,media_type,media_url,username,timestamp&access_token=' . $token;
                    }
                    $data = hcc_instagram_api_connection( $link );
                    if( $data === 'Error' ){
                        $link = 'https://graph.instagram.com/' . $name . '?fields=id,media,media_type,media_url,username,timestamp&access_token=' . $token;
                        $data = hcc_instagram_api_connection( $link );
                        if( $data === 'Error' ){
                            throw new Exception( __('Невозможно выполнить запрос cURL', 'hcc') );
                            return false;
                        }
                    }
                }
     catch (Exception $e) {
                        echo $e->getMessage(), "\n";
     }
     return $data;
}

/*
 *  cURL session
 *
 */
function hcc_instagram_api_connection( $url ){
    $curl_init = curl_init();
    curl_setopt($curl_init, CURLOPT_URL, $url);
    curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_init, CURLOPT_TIMEOUT, 20);
    $json_result = curl_exec($curl_init);
    if (!curl_errno($curl_init)) {
        $info = curl_getinfo($curl_init);
        if( empty($info['http_code']) || $info['http_code'] === 400 ||$info['http_code'] === 403 || $info['http_code'] === 404 ){
            $result = 'Error';
        }
    }
    curl_close($curl_init);
    return json_decode( $json_result );
}

/*
 * token cURL session
 *
 */

function hcc_get_instagram_api_token( $url, $fields= array() ){
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        if( empty($info['http_code']) || $info['http_code'] === 400 ||$info['http_code'] === 403 || $info['http_code'] === 404 ){
            $result = 'Error';
        }
    }
    curl_close($ch); 
    $result = json_decode($result);
    return $result->access_token;
    
}
/*
 * Custom intervals for WP cron
 *
 */
add_filter( 'cron_schedules', 'hcc_cron_interval'); 
function hcc_cron_interval( $intervals ) {
    $cron = trim(get_field('cron_time', 'options'));
	$intervals['every_48_hours'] = array(
		'interval' => ( isset($cron) && !is_null($cron) ) ? 3600 * $cron : 172800,
		'display' => __('Каждые 48 часов', 'hcc'),
	);
	return $intervals;
}

/*
* Instagram array data params
* Russian localizatiom
*/
/*
$data->id                                                   ID публикации.
$data->link                                                 Ссылка на это изображение в Instagram.
$data->images->low_resolution->url                          URL копии изображения низкого разрешения (306×306).
$data->images->thumbnail->url                               URL изображения-миниатюры (150×150).
$data->images->standard_resolution->url                     URL копии изображения стандартного разрешения (612×612).
$data->tags                                                 Массив, содержащий все теги данного изображения.
$data->filter                                               Название используемого фильтра.
$data->caption->text                                        Описание фото.
$data->created_time                                         Дата публикации в UNIX-формате. Мы можем изменить формат даты при помощи функции gmdate(): echo gmdate("Y-m-d H:i", $data->created_time);
$data->user->username                                       Имя пользователя, который запостил фотографию.
$data->user->id                                             ID пользователя.
$data->user->full_name                                      Полное имя пользователя.
$data->user->profile_picture                                URL аватарки пользователя.
$data->comments->count                                      Количество комментариев к изображению.
$data->comments->data                                       Массив объектов комментариев, который также можно пропустить через цикл foreach и получить информацию о каждом оставленном комменте, например:

                                                            foreach( $data->comments->data as $comment ) :
                                                                echo '<p><strong>' . $comment->from->username . '</strong><br />' . $comment->text . '</p>';
                                                            endforeach;
Тогда получаем следующие параметры комментариев:

$comment->created_time                                      Дата публикации комментария в UNIX формате.
$comment->id                                                ID комментария.
$comment->text                                              Текст комментария.
$comment->from->username                                    Имя пользователя, оставившего комментарий.
$comment->from->id                                          ID пользователя.
$comment->from->full_name                                   Полное имя пользователя.
$comment->from->profile_picture                             URL аватарки пользователя.
$data->likes->count                                         Количество «лайков».
$data->likes->data                                          Лайки
*/
