<?php 
/*
*  This file contain some custom fixed widgets
*
*/
?>
       <!-- Color Switcher -->
        <div class="switcher d-block sun">
            <div class="light-theme"></div>
            <div class="dark-theme"></div>
        </div>
        <!-- Color Switcher End -->
        <!-- Contact Us Button -->
        <?php if( function_exists( 'get_field' ) ) :
                    $visibility  = get_field('contact_button_visibility', 'options');
                    if( $visibility === 'true' ) :
                        $links       = get_field('socials_копия', 'options');
                        $phones      = get_field('phone_nums', 'options');
                        $name        = !empty( SITE_NAME ) ? SITE_NAME : '';
                        $theme_url   = !empty( THEME_URI ) ? THEME_URI : get_template_directory_uri();
                    endif;
              endif; ?>
        <?php $modal = get_option('hcc-theme-cf-modal'); ?>
        <?php if( $visibility === 'true' ) : ?>
        <div class="contact-button-wrap">
            <div class="button-tel">
                <div class="button-tel-icon"></div>
                <div class="button-tel-content">
                    <span class="text"><?php echo __('Свяжитесь с нами', 'hcc'); ?></span>
                </div>
            </div>
            <div class="buttons-socials <?php if( !$modal ) : ?> no-msg <?php endif; ?>">
                <?php if( $modal ) : ?>
                <a href="#" class="one-social message social-1" target="_self">
                    <?php if( !empty( $theme_url ) ) : ?>
                          <img src="<?php echo esc_url( $theme_url . '/assets/public/img/icons/icon-email.svg'); ?>" title="<?php echo __('Email icon') . $name; ?>" alt="<?php echo __('Email icon'); ?>">
                    <?php endif; ?>
                </a>
                <?php endif; ?>
                <?php if( $links ) : 
                            $socialCounter = 2;
                            foreach( $links as $link) :
                                $actions     = $link['actions'];
                                $link_name   = mb_strtolower( wp_kses_post( $link['nazvanie'] ) );
                                $href        = $link['link'] ? wp_kses_post( trim( $link['link'] ) ): '#'; 
                                $mobile_href = $link['link_mobile'] ? wp_kses_post( trim( $link['link_mobile'] ) ) : '#'; 
                                $image       = $link['icon'];
                                $target      = ( mb_strpos($href, 'http') !== false ) ? '_blank' : '_self'; 
                                if( $actions === 'computer' ) : 
                                    if( $href ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                elseif( $actions === 'mobile' ) : 
                                    if( $href && !is_mobile() ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                    if( $mobile_href && is_mobile() ) : ?>
                                        <a href="<?php echo $href; ?>" class="one-social social-<?php echo $socialCounter . ' ' . $link_name; ?>" target="<?php echo $target; ?>">
                                            <?php if( $image ) : ?>
                                                <img src="<?php echo esc_url( $image['url'] ); ?>" title="<?php echo esc_attr( $image['title'] ) ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endif;
                                endif;
                            $socialCounter++; endforeach; 
                endif;
                if( $phones ) :
                        $counter = 1;
                        foreach( $phones as $phone ) :
                            if( $counter === 2 ) : break; endif; 
                            $tel      = sanitize_text_field( trim( $phone['phone_num'] ) );
                            $href_tel = preg_replace( '~[^0-9]+~', '', $tel ); 
                            if( !empty( $href_tel ) ) : ?>
                                <a href="tel:+38<?php echo $href_tel; ?>" class="one-social phone social-<?php echo $socialCounter++; ?>" target="_self">
                                    <?php if( !empty( $theme_url ) ) : ?>
                                          <img src="<?php echo esc_url( $theme_url . '/assets/public/img/icons/phone.svg' ); ?>" title="<?php echo __('Phone icon') . ' ' . $name; ?>" alt="<?php echo __('Phone icon'); ?>">
                                    <?php endif; ?>
                                </a>
                            <?php endif; 
                            $counter++; 
                        endforeach;
                    endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- Contact Us Button End -->