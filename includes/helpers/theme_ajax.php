<?php
/*
 *	File for theme ajax 
 * 
 */
?>
<?php 
add_action('wp_ajax_ajax_loadmore', 'hcc_load_posts');
add_action('wp_ajax_nopriv_ajax_loadmore', 'hcc_load_posts');

function hcc_load_posts(){
    try{
        if( empty( $_POST['query'] ) ){
            throw new Exception( __('Невозможно выполнить запрос: получен пустой массив', 'hcc') );
            return __('Невозможно выполнить запрос. Попробуйте, пожалуйста, позже', 'hcc');
            die;
        }
        else{
            $args  = unserialize( stripslashes( $_POST['query'] ) );
        }

        if( empty( $args['posts_per_page'] ) || empty( $args['paged'] ) || empty( $args['post_type'] ) ){
            throw new Exception( __('Невозможно выполнить запрос: неверные параметры запроса', 'hcc') );
            return __('Невозможно выполнить запрос. Попробуйте, пожалуйста, позже', 'hcc');
            die;
        }

        $args['paged']       = $_POST['page'] + 1;
        $args['post_status'] = 'publish';
    }
    catch (Exception $e) {
            echo $e->getMessage(), "\n";
    }
    
    if( $args['post_type'] === 'service'){
        query_posts( $args );
        if( have_posts() ) :
            while( have_posts() ): the_post(); ?>
                
                            <?php $title   = wp_kses_post( get_the_title() );
                                    $content = wp_kses_post( get_the_content() ); 
                                    $content = wp_trim_words( $content, 35, '...');
                                    $image   = esc_url( get_the_post_thumbnail_url() );
                                    $link    = esc_url( get_permalink() );
                                    if( $image ) :
                                        $bg = aq_resize( $image, 350, 250, true, true, true);
                                    endif;
                              ?>
                              <a href="<?php echo $link ? $link : '#'; ?>" class="col-12 col-md-4 col-lg-4 services-wrap d-flex justify-content-center align-items-center " data-href="<?php echo $link; ?>" >
                                  <div class="service <?php echo ($bg) ? 'has-bg' : 'no-bg'; ?>" >
                                      <div class="service-image" <?php if( $bg ) : ?>style="background-image: url('<?php echo $bg; ?>')"<?php endif; ?>>
                                          <div class="service-content d-flex flex-column align-items-center h-100 w-100">
                                              <?php if( $title ) : ?>
                                                  <div class="service-name"><strong><?php echo $title; ?></strong></div>
                                              <?php endif; ?>
                                              <?php if( $content ) : ?>
                                                  <div class="service-text"><?php echo $content; ?></div>
                                              <?php endif; ?>
                                          </div>
                                      </div>
                                  </div>
                              </a>
                
            <?php endwhile;
        endif;
    }
    
    if( $args['post_type'] === 'portfolio'){
        query_posts( $args );
        if( have_posts() ) :
            while( have_posts() ): the_post(); ?>
            
                                <?php $title   = wp_kses_post( get_the_title() );
                                        $content = strip_tags( wp_kses_post( get_the_content() ) ); 
                                        $content = wp_trim_words( $content, 35, '...'); 
                                        $image   = esc_url( get_the_post_thumbnail_url() );
                                        $link    = esc_url( get_permalink() );
                                        if( $image ) :
                                            $img   = aq_resize( $image, 500, 500, true, true, true);
                                            $modal = aq_resize( $image, 800, 800, true, true, true);
                                        endif;
                                  ?>
                                   <div class="portfolio-wrap d-flex justify-content-center align-items-center" data-href="<?php echo $link; ?>" >
                                      <a href="<?php echo ( $modal ) ? esc_attr( $modal ) : '#'; ?>" data-fancybox="portfolio" class="fancybox portfolio-modal portfolio-item" <?php if( $title ) : ?>data-name="<?php echo $title; ?>"<?php endif; ?>>
                                              <img src="<?php echo esc_url( $img ); ?>" title="<?php echo esc_attr( $image['title'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="portfolio-image img-inner">
                                              <div class="portfolio-content flex-column align-items-center w-100">
                                                  <?php if( $content ) : ?>
                                                      <div class="portfolio-text"><?php echo $content; ?></div>
                                                  <?php endif; ?>
                                                  <div class="portfolio-more"><?php echo __('Интересно?', 'hcc'); ?></div>
                                              </div>
                                      </a>
                                      <a href="<?php echo $link ? $link : '#'; ?>" class="portfolio-more-link"><?php echo __('Смотреть больше', 'hcc'); ?></a>
                                  </div>
                
            <?php endwhile;
        endif;
    }
    
	die();
}

add_action( 'wp_ajax_hcc_ajax', 'ajax_mail_function' ); // wp_ajax_{ACTION!!}
add_action( 'wp_ajax_nopriv_hcc_ajax', 'ajax_function' ); // wp_ajax_nopriv_{ACTION!!}
function ajax_function(){
    
    //Theme ajax
    function ThemeAjaxElem(){
        
    }
    
    ThemeAjaxElem();
}