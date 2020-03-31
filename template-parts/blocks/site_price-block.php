<?php
/**
 * We Our Prices Template.
 *
 *
 */
$blockName = 'we-price';
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

$block  = get_field('we_price');
$title  = get_conf_title('text-center', $block);
$after  = wp_kses_post( $block['after_header'] );
$before = wp_kses_post( $block['before_header'] );
$args = array(
                'numberposts' => 0,
                'post_type'   => 'price',
                'orderby'     => 'status',
                'order'       => 'ASC',
                'suppress_filters' => true,
);
global $post;
$tmp_post = $post;
$price = get_posts( $args );
$count_price = count( $price );

if( $count_price % 2 != 0 ){
    $center_pos = ceil( $count_price/2 );
    $new_count = $center_pos;
    $class  = 'center';
}
else{
    $class = 'srart';
}

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme color-bg">
    <div class="container">
        <div class="row">
            <?php if( $after || $before || $title ) : ?>
            <div class="col-12 flex-column justify-content-center align-items-center d-flex">
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
            <?php if( $price ) : ?>
            <div class="col-12 prices-wrap">
                <div class="row d-flex align-items-start justify-content-<?php echo $class; ?>">
                
                <?php $count = 1; $helper = 1;
                      foreach( $price as $post ) :
                      setup_postdata($post);
                      $title     = wp_kses_post( get_the_title() );
                      $text      = wp_kses_post( get_field('text', $post->ID) ); 
                      $old_price = wp_kses_post( get_field('old_price', $post->ID) );
                      $new_price = wp_kses_post( get_field('new_price', $post->ID) );
                ?>
                      
                      <div class="d-flex col-12 col-md-6 col-lg-4 col-xl-3 position position-<?php echo abs( $count ); ?> <?php echo ( $count % 2 == 0 ) ? 'even' : 'odd'; ?>">
                        <div class="price-block ml-auto mr-auto">
                              <?php if( $title ) : ?>
                                  <strong class="text-center w-100 d-flex align-items-center justify-content-center price-title"><?php echo $title; ?></strong>
                              <?php endif; ?>
                              <?php if( $text ) : ?>
                                  <div class="text-center w-100 d-block price-text"><?php echo $text; ?></div>
                              <?php endif; ?>
                              <?php if( $old_price ) : ?>
                                  <span class="price-desc d-block text-center w-100"><?php echo __('Старая цена', 'hcc'); ?>:</span>
                                  <span class="price-price price-old d-block text-center w-100"><?php echo $old_price; ?></span>
                              <?php endif; ?>
                              <?php if( $new_price ) : ?>
                                  <?php if( $old_price ) : ?>
                                      <span class="price-desc d-block text-center w-100"><?php echo __('Новая цена', 'hcc'); ?>:</span>
                                      <span class="price-price price-new d-block text-center w-100"><?php echo $new_price; ?></span>
                                  <?php else: ?>
                                      <span class="price-desc d-block text-center w-100"><?php echo __('Цена', 'hcc'); ?>:</span>
                                      <span class="price-price price-new d-block text-center w-100"><?php echo $new_price; ?></span>
                                  <?php endif; ?>
                                  <span class="order d-flex justify-content-center align-items-center">
                                      <a href="#" rel="nofollow" target="_self" class="modal-order button price-button d-flex text-center"><?php echo __('Заказать', 'hcc'); ?></a>
                                  </span>
                              <?php endif; ?>
                        </div>
                      </div>
                <?php 
                    if( $count >= 4 || $helper >= 4 ) : 
                        $count = 0;
                        $helper = 0;
                    endif;
                    if( $center_pos && false ) :
                          if( ( $count == $center_pos ) || ( $count == $new_count ) ) :
                                $new_count--;
                                $count--;
                          else :
                                $count++;
                          endif;
                    else :
                        $count++;
                    endif; 
                $helper++; endforeach; ?>  
                </div>  
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
<?php $post = $tmp_post;
      wp_reset_postdata();?>
<?php endif; ?>