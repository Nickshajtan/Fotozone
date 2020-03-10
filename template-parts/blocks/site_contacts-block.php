<?php
/**
 * Contacts Block Template.
 *
 *
 */
$blockName = 'site-contacts';
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

$block     = get_field('site_contacts');
$title     = get_conf_title('text-center', $block);
$phones    = get_field('phone_nums', 'options'); 
$emails    = get_field('emails', 'options'); 
$addresses = get_field('addresses', 'options'); 
$locations = get_field('locations','options');

if( count( $phones ) > 2 || count( $emails ) > 2 || count( $emails ) > 2){
    $ph_class = 12;
    $ph_wrap  = 'ph-column';
    $em_class = 12;
    $em_wrap  = 'em-column';
    $adr_class = 12;
    $adr_wrap  = 'adr-column';
}
else{
    $ph_class = 4;
    $ph_wrap  = 'ph-row';
    $em_class = 4;
    $em_wrap  = 'em-row';
    $adr_class = 4;
    $adr_wrap  = 'adr-row';
}

if( $block ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?> light-theme white-bg">
        <div class="container">
            <?php if( $title ) : ?>
            <div class="row">
                <div class="col-12 flex-column justify-content-center align-items-center d-flex section-header">
                    <?php echo $title; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row d-flex justify-content-center align-items-start">
                <?php if( $phones ) : ?>
                <div class="col-12 col-xl-<?php echo $ph_class; ?> d-flex justify-content-between align-items-center flex-column phones-wrapper <?php echo $ph_wrap; ?>">
                   <div class="w-100 d-flex justify-content-center align-items-center contact-name"><?php echo __('Телефон','hcc'); ?>:</div>
                   <div class="w-100 d-flex justify-content-between align-items-center contact-body">
                   <?php $counter = 1; foreach( $phones as $phone ) : ?>
                        <?php $tel = sanitize_text_field( $phone['phone_num'] );
                        $href = preg_replace( '~[^0-9]+~', '', $tel ); 
                        if( !empty( $tel ) ) : ?>
                            <div class="w-100 d-flex justify-content-center">
                                <a href="tel:+38<?php echo $href; ?>" class="d-flex align-items-center justify-content-center mr-auto ">
                                                <span class="icon"><?php echo $counter; ?></span><span class="body">+38 <?php echo $tel; ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                   <?php $counter++; endforeach; ?>
                   </div>
                </div>
                <?php endif; ?>
                <?php if( $emails ) : ?>
                <div class="col-12 col-xl-<?php echo $em_class; ?> d-flex justify-content-between align-items-center flex-column emails-wrapper <?php echo $em_wrap; ?>">
                    <div class="w-100 d-flex justify-content-center align-items-center contact-name"><?php echo __('Email','hcc'); ?>:</div>
                    <div class="w-100 d-flex justify-content-between align-items-center contact-body">
                    <?php $counter = 1; foreach( $emails as $email ) : ?>
                          <?php $email = wp_kses_post( $email['email'] ); 
                          if( !empty( $email ) ) : ?>
                            <div class="w-100 d-flex justify-content-center">
                                <a href="mailto:<?php echo $email; ?>" class="d-flex align-items-center justify-content-center mr-auto ">
                                                <span class="icon"><?php echo $counter; ?></span><span class="body"><?php echo $email; ?></span>
                                </a>
                            </div>
                          <?php endif; ?>
                    <?php $counter++; endforeach; ?>
                    </div>
                </div>    
                <?php endif; ?>
                <?php if( $addresses ) : ?>
                <div class="col-12 col-xl-<?php echo $adr_class; ?> d-flex justify-content-between align-items-center flex-column addresses-wrapper <?php echo $adr_wrap; ?>">
                    <div class="w-100 d-flex justify-content-center align-items-center contact-name"><?php echo __('Адрес','hcc'); ?>:</div>
                    <div class="w-100 d-flex justify-content-between align-items-center contact-body">
                    <?php $counter = 1; foreach( $addresses as $adres ) : ?>
                        <?php $adress = wp_kses_post( $adres['adress'] );
                              $time = wp_kses_post( $adres['time'] );
                              $href = esc_url( wp_kses_post( $adres['g_href'] ) ); ?>
                              <div class="d-flex justify-content-center align-items-center flex-column w-100">
                                  <?php if( !empty( $adress ) ) : ?>
                                  <div class="w-100 d-flex justify-content-center">
                                                <a href="<?php echo ( !empty( $href )  ) ? $href : '#'; ?>" target="_blank" rel="nofollow" class="d-flex align-items-center justify-content-center mr-auto ">
                                                    <span class="icon"><?php echo $counter; ?></span><span class="body"><?php echo $adress; ?></span>
                                                </a>
                                  </div>
                                  <?php endif;
                                  if( !empty( $time ) ) : ?>
                                  <div class="w-100 d-flex justify-content-start justify-xl-content-center">
                                            <a href="#">
                                                    <?php echo $time; ?>
                                            </a>
                                  </div>
                                  <?php endif; ?>
                              </div>
                    <?php $counter++; endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
</section>
<?php endif; ?>
<?php if( $locations ) : 
        get_template_part('template-parts/google_map', 'many_markers');
    //  get_template_part('template-parts/google_map', 'many_maps');
endif; ?>