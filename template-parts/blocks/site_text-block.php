<?php
/**
 * Site Addon Block : text & image
 *
 *
 */
$blockName = 'site-addon';
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

$block  = get_field('text_block');
$title  = get_conf_title('text-center', $block);
$text   = wp_kses_post( $block['text']);

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> white-bg light-theme">
    <div class="container">
        <div class="row">
            <?php if( $title ) : ?>
            <div class="col-12 flex-column justify-content-center align-items-center d-flex">
                <div class="section-header">
                    <?php echo $title; ?>    
                </div>
            </div>
            <?php endif;
            if( $text ) : ?>
            <div class="col-12">
                <?php echo $text; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>