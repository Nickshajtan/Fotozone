<?php
/**
 * Action Block Template.
 *
 *
 */
$blockName = 'we-actions';
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

$block  = get_field('we_actions');
$title  = get_conf_title('text-center', $block);
$after  = wp_kses_post( $block['after_header'] );
$actn   = wp_kses_post( $block['text'] );
$link   = $block['link'];
if( $link ){
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
}
$timer = wp_kses_post( $block['timer'] );
$time  = wp_date( 'Y-m-d', strtotime($timer) - time() );
$daTe  = strtotime($timer) - time(); 

if( !empty( $timer ) ){
    if( !empty( $time ) && ( $time > 0 ) ){
        $deadline = $timer;
    }
	else{
		$days 	  = floor($daTe/86400);
	    $hours    = floor(($daTe%86400)/3600);
	    $minutes  = floor(($daTe%3600)/60);
	    $seconds  = $timer%60;
		$deadline = $days . "-" . $hours  . "-" . $minutes;
	}
}

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
            <?php if( !empty( $timer ) ) : ?>
            <div class="timer-wrapper col-12 col-lg-6 ml-auto mr-auto">
                <div id="clockdiv" class="w-100 clockdiv " data-time="<?php echo $deadline; ?>">
                    <div class="time-message d-flex flex-column align-items-center">
                        <span class="days text-center w-100 count"></span>
                        <?php if (function_exists('get_num_ending')) : ?>
                            <?php $number = $time - 1; ?>
                            <div class="smalltext text-center days-text w-100"><?php echo get_num_ending( $number, array(__('день', 'hcc'), __('дня', 'hcc'), __('дней', 'hcc'))); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="time-message d-flex flex-column align-items-center">
                        <span class="hours text-center w-100 count"></span>
                        <?php if (function_exists('get_num_ending')) : ?>
                            <?php $number = 23 - date('H'); /* H - 24 hours, h -12 hours */?>
                            <div class="smalltext text-center hours-text w-100"><?php echo get_num_ending( $number, array(__('час', 'hcc'), __('часа', 'hcc'), __('часов', 'hcc'))); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="time-message d-flex flex-column align-items-center">
                        <span class="minutes text-center w-100 count"></span>
                        <?php if (function_exists('get_num_ending')) : ?>
                            <?php $number = 59 - date('i'); ?>
                            <div class="smalltext text-center minute-text w-100"><?php echo get_num_ending( $number, array(__('минута', 'hcc'), __('минуты', 'hcc'), __('минут', 'hcc'))); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="d-none deadline-messadge w-100">
                        <?php echo __('Время истекло!', 'hcc'); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if( $actn ) : ?>
            <div class="col-12 justify-content-center align-items-center d-flex">
                    <?php echo $actn; ?>
            </div>
            <?php endif; ?>
            <?php if( $link ): ?>
            <div class="d-flex align-items-center justify-content-center col-12 col-lg-6 ml-auto mr-auto">
                <a class="button action-button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>