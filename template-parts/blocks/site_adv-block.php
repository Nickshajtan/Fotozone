<?php
/**
 * We Offer Block Template.
 *
 *
 */
$blockName = 'we-offer';
// Create id attribute allowing for custom "anchor" value.
$id = $blockName.'-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = $blockName;
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$block  = get_field('we_offer');
$title  = get_conf_title('text-center', $block);
$after  = wp_kses_post( $block['after_header'] );
$before = wp_kses_post( $block['before_header'] );
if ( get_query_var('paged') ) {
          $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {  
          $paged = get_query_var('page');
} else {
          $paged = 1;
}
$args = array(
                'numberposts' => 0,
                'posts_per_page' => 3,
                'paged' => $paged,
                'post_type'   => 'service',
                'orderby'     => 'status',
                'order'       => 'ASC',
                'suppress_filters' => true,
);
$hcc_query = query_posts( $args );

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme white-bg" data-ias="<?php echo $blockName; ?>">
    <div class="container ias-initial">
        <div class="row">
            <?php if( $after || $before || $title ) : ?>
            <div class="col-12 justify-content-center align-items-center d-flex flex-column">
                <?php if( $before ) : ?>
                <div class="text-center section-subheader header-before">
                    <?php echo $before; ?>
                </div>
                <?php endif; ?>
                <?php if( $title ) : ?>
                <div class="section-header has-before">
                    <?php echo $title; ?>
                </div>
                <?php endif; ?>
                <?php if( $after ) : ?>
                <div class="text-center section-subheader header-after">
                    <?php echo $after; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if( have_posts() ) : ?>
                <div class="col-12 servies-global-wrap ">
                    <div class="row ajax-container">
                        <?php while (have_posts()) : the_post(); ?>
                              <?php $title   = wp_kses_post( get_the_title() );
                                    $content = wp_kses_post( get_the_content() ); 
                                    $content = wp_trim_words( $content, 25, '...');
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
                        <?php endwhile; ?>
                    </div>
                </div>
                
                <?php if( function_exists( 'the_posts_pagination' ) ) : ?>
                <div class="col-12 d-none justify-content-center align-items-center">
                    <?php the_posts_pagination(); ?>
                </div>
                <?php endif; ?>
                
                <?php $count_service = wp_count_posts('service'); 
                if ( $count_service->publish > 3 ) : ?>
                <div class="col-12 d-flex flex-column justify-content-center align-items-center load-container">
                    <div class="w-100 d-flex justify-content-center align-items-center">
                           <div class="load-loder d-flex justify-content-center align-items-center"></div>
                    </div>
                    <div class="load-more">
                       <div class="button box-button"><?php echo __('Показать ещё', 'hcc'); ?></div>
                    </div>
                    <div class="load-error d-none"><?php echo __('Невозможно выполнить запрос. Попробуйте, пожалуйста, позже', 'hcc'); ?></div>
                </div>
                <script>
                    var service_posts        = '<?php echo serialize($args); ?>';
                    var service_current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                    var service_max_pages    = '<?php echo ceil( $count_service->publish / 3 ); ?>';
                </script>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
    </div>
</section>
<?php wp_reset_query(); 
endif; ?>