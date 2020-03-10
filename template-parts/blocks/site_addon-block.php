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

$block  = get_field('text_image_block');
$title  = get_conf_title('text-left', $block);
$text   = wp_kses_post( $block['text']);
$image  = $block['image'];

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme white-bg">
        <div class="container">
            <div class="row">
                <?php if( $title ) : ?>
                <div class="col-12 justify-content-start align-items-center d-flex">
                    <div class="section-header">
                        <?php echo $title; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-12 col-md-6 content-wrapper">
                    <?php if( $text ) : ?>
                        <div class="content"><?php echo ( $text ); ?></div>
                    <?php endif; ?>
                    <div class="link-wrapper justify-content-start align-items-center d-flex">
                        <a href="<?php echo ( THEME_HOME_URL ) ? THEME_HOME_URL : get_home_url('/'); ?>" class="button"><?php echo __('Вернуться на главную','hcc'); ?></a>
                    </div>
                </div>
                <?php if( $image ) : ?>
                    <div class="col-12 col-md-6 thumbnail-wrapper">
                         <img src="<?php echo esc_url( aq_resize( $image['url'], 570, 350, true, true, true) ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" data-title="<?php echo wp_kses_post( get_the_title() ); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
</section>  

<?php endif; ?>