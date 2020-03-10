<?php
/**
 * Reviews Block Template.
 *
 *
 */
$blockName = 'we-review';
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

$block  = get_field('we_review');
$title  = get_conf_title('text-center', $block);
$after  = wp_kses_post( $block['after_header'] );
$args = array(
                'numberposts' => 0,
                'post_type'   => 'review',
                'orderby'     => 'status',
                'order'       => 'ASC',
                'suppress_filters' => true,
);
global $post;
$tmp_post = $post;
$reviews = get_posts( $args );

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme white-bg">
    <div class="container">
        <div class="row">
            <?php if( $title || $after ) : ?>
            <div class="col-12 flex-column justify-content-center align-items-center d-flex">
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
            <?php if( $reviews ) : ?>
            <div class="col-12 reviews-wrap">
                <div class="row reviews-slider">
                    <div class="waterwall-slider w-100">
                        <?php foreach( $reviews as $post ) :
                          setup_postdata($post); 
                          $image = get_field('image', $post->ID);
                              if( $image ) : ?>
                                   <a href="<?php echo esc_url( aq_resize( $image['url'], 450, 600, true, true, true) ); ?>" data-fancybox='group' class='fancybox review-modal'>
                                       <img src="<?php echo esc_url( aq_resize( $image['url'], 250, 400, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" data-title="<?php echo wp_kses_post( get_the_title() ); ?>" class="review-image">
                                   </a>
                              <?php endif; ?>
                        <?php endforeach; ?> 
                    </div> 
                </div>  
                <div class="review-arrows w-100 d-flex">
                    <div class="review-arrow review-prev"></div>
                    <div class="review-arrow review-next"></div>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
<?php $post = $tmp_post;
      wp_reset_postdata();?>
<?php endif; ?>