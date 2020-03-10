<?php
/**
 * FAQ Block Template.
 *
 *
 */
$blockName = 'faq';
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

$block  = get_field('we_faq');
$title  = get_conf_title('text-center', $block);
$before = wp_kses_post( $block['header_before'] );
$cycle  = $block['steps'];
if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme white-bg">
   <div class="wrap">
        <div class="container">
            <div class="row">
                <?php if( $title || $before ) : ?>
                <div class="col-12 justify-content-center align-items-center d-flex flex-column">
                   <?php if( $title ) : ?>
                    <div class="section-header has-before">
                        <?php echo $title; ?>
                    </div>
                    <?php endif; 
                    if( $before ) : ?>
                    <div class="text-center section-subheader header-before">
                        <?php echo $before; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if( $cycle ) : ?>
                <div class="col-12">
                    <div class="row">
                    <?php $count = 0;
                          foreach( $cycle as $one ) :
                          $text  = wp_strip_all_tags( $one['text'], true ); 
                          $answ  = wp_kses_post( $one['answer'] ); 
                    ?>

                          <div class="col-12 faq-wrap">
                              <?php if( $text ) : ?>
                              <div id="faq-header-<?php echo $count; ?>" class="faq-header">
                                  <button class="w-100 d-flex justify-space-between align-items-center collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>" aria-expanded="true" aria-controls="<?php echo $count; ?>">
                                      <strong><?php echo $text; ?></strong>
                                  </button>
                              </div>
                              <?php endif; ?>
                              <?php if( $answ ) : ?>
                                  <div id="collapse-<?php echo $count; ?>" class="faq-body collapse" aria-labelledby="heading-<?php echo $count; ?>" data-parent="#faq-header-<?php echo $count; ?>">
                                      <div class="faq-desc"><?php echo __('Ответ', 'hcc'); ?>:</div>
                                      <div class="faq-answ"><?php echo $answ; ?></div>
                                  </div>
                              <?php endif; ?>
                          </div>

                    <?php $count++; endforeach; ?>  
                    </div>  
                </div>
                <?php endif; ?>

            </div>
        </div>
   </div>
</section>

<?php endif; ?>