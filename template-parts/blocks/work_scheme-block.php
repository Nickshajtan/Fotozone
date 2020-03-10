<?php
/**
 * How We Work Block Template.
 *
 *
 */
$blockName = 'how-we-work we-work';
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

$block = get_field('work_scheme');
$title = get_conf_title('text-center', $block);
$cycle = $block['steps'];
if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme color-bg">
    <div class="container">
        <div class="row">
            <?php if( $title ) : ?>
            <div class="col-12 justify-content-center align-items-center d-flex section-header">
                <?php echo $title; ?>
            </div>
            <?php endif;
            if( $cycle ) : ?>
            <div class="col-12">
                <div class="row d-flex align-items-start justify-content-center">
                <?php foreach( $cycle as $one ) :
                      $image = $one['icon'];
                      $text  = wp_kses_post( $one['text'] ); ?>
                      
                      <div class="col-12 col-md-3 col-xl-2 d-flex flex-column justify-content-center align-items-center h-100">
                          <?php if( $image ) : ?>
                             <div class="img-wrapper d-flex justify-content-center align-items-center">
                                 <img src="<?php echo esc_url( aq_resize( $image['url'], 64, 64, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="img-inner">
                             </div>
                          <?php endif; ?>
                          <?php if( $text ) : ?>
                              <div class="about-scheme text-center w-100"><?php echo $text; ?></div>
                          <?php endif; ?>
                      </div>
                      
                <?php endforeach; ?>  
                </div>  
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>

<?php endif; ?>