<?php 
/*
* This file include php version of Instagram page parse without Instagram API
* 
*/
function file_get_contents_curl($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
}

function hcc_inst_php_get_page( $host, $name ){
   $url      = $host . $name;
   $response = wp_remote_get($url, array( 'user-agent' => 'GOOGLE'  ));
   $code     = wp_remote_retrieve_response_code( $response );
    
   if ( !is_wp_error( $response ) && !empty( $popper_url ) && ( $code == '200') ){
       $insta_source = $response;
       $shards = explode('window._sharedData = ', $insta_source['body']);
       $insta_json = explode(';</script>', $shards[1]);
       $insta_array = json_decode($insta_json[0], TRUE);
   }
   elseif( function_exists('file_get_contents') ){
       $insta_source = file_get_contents($url);
       $shards = explode('window._sharedData = ', $insta_source);
       $insta_json = explode(';</script>', $shards[1]);
       $insta_array = json_decode($insta_json[0], TRUE);
   }
   else{
       $insta_source = file_get_contents_curl($url);
       $shards = explode('window._sharedData = ', $insta_source);
       $insta_json = explode(';</script>', $shards[1]);
       $insta_array = json_decode($insta_json[0], TRUE);
   }
   try{
       $media = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
       if( empty ( $media ) ){
           throw new Exception( __('Получен пустой массив данных', 'hcc') );
       }
       if( !empty( $media ) ){
           $count = 1;
           $data = array();
           foreach( array_slice ( $media, 0, 20)  as $row ){
              try{
                  $data[] = array(
                        'id'       => $row['node']['id'],
                        'title'    => __('Инстаграм портфолио', 'hcc') . ' ' . $count++,
                        'text'     => $row['node']['edge_media_to_caption']['edges'][0]['node']['text'],
                        'image'    => $row['node']['thumbnail_src'],
                  );
                  if( empty( $data['id'] ) ||  empty( $data['text'] ) ){
                        throw new Exception( __('Получен пустой массив дополнительных данных', 'hcc') );
                  }
                  if( empty( data['title'] ) ){
                        throw new Exception( __('Сбой именования портфолио', 'hcc') );
                  }
                  if( empty( data['image'] ) ){
                        throw new Exception( __('Получен пустой массив данных изображения, критично', 'hcc') );
                        break;
                  }
              }
              catch (Exception $e) {
                  echo $e->getMessage(), "\n";
              }
            }
            if( !empty( $data ) ){
                foreach( $data as $post ){
                      $post['text']  = wp_slash( trim( $post['text'] ) );
                      $post['text']  = preg_replace('~#\S+\s+~', '', $post['text']);
                      $post['text']  = preg_replace('/(#\w+)/', '', $post['text']);
                      $post['text']  = preg_replace('~@\S+\s+~', '', $post['text']);
                      $post['text']  = wp_encode_emoji( wp_kses($post['text'], 'strip') );
                      $post['title'] = trim( $post['title'] );
                      $post['id']    = trim( wp_kses( $post['id'], 'strip' ) );

                      $post['image'] = trim( $post['image'] );

                      insertPortfolio( $post['title'], $post['text'], $post['image'], $post['id'] );  
                }
           }
       }
   }
   catch (Exception $e) {
                  echo $e->getMessage(), "\n";
   }
}