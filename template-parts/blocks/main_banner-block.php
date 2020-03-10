<?php
/**
 * Main Banner Block Template.
 *
 *
 */
$blockName = 'we-banner';
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

$block  = get_field('we_slider');
$title  = get_conf_title('text-center', $block);
$after  = wp_kses_post( $block['after_text'] );
$args = array(
                'numberposts' => 0,
                'post_type'   => 'slide',
                'orderby'     => 'status',
                'order'       => 'ASC',
                'suppress_filters' => true,
);
global $post;
$tmp_post = $post;
$slider = get_posts( $args );

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme color-bg">
   <?php if( $title || $after ) : ?>
   <div class="abs-block">
       <div class="container">
            <div class="row">
                <div class="col-12 flex-column justify-content-center align-items-center d-flex">
                    <?php if( $after ) : ?>
                    <div class="section-header justify-content-center align-items-center d-flex has-before">
                        <strong class="text-center"><?php echo $after; ?></strong>
                    </div>
                    <?php endif; 
                    if( $title ) : ?>
                    <div class="text-center section-subheader header-after">
                        <?php echo $title; ?>
                    </div>
                    <?php endif; ?>
                    <a href="#" class="arrow arrow-to-next">
                        
                    </a>
                </div>
            </div>
        </div>
   </div>
   <?php endif; ?>
   <?php if( $slider ) : ?>
            <div class="slider slick-slider">
                <?php $counter = 1; foreach( $slider as $post ) :
                      setup_postdata($post); 
                      $text  = wp_kses_post( get_field('text', $post->ID) );
                      $image = get_field('image', $post->ID);
                ?>
                      <?php if( wp_is_mobile() && $counter === 2 ) : break; endif; ?>
                      <div class="slide">
                          <?php if( $image ) : ?>
                             <div class="slide-image">
                                 <img src="<?php echo esc_url( aq_resize( $image['url'], 1920, 825, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="img-inner">
                             </div>
                          <?php endif; ?>
                          <?php if( $text ) : ?>
                          <div class="flex-column justify-content-center align-items-center d-flex slide-text">
                              <div><?php echo $text; ?></div>
                          </div>
                          <?php endif; ?>
                          <div class="slide-overlay"></div>
                      </div>
        
                <?php $counter++; endforeach; ?>  
            </div>
  <?php endif; ?>
</section>
<?php $post = $tmp_post;
      wp_reset_postdata();?>
<?php endif; ?>