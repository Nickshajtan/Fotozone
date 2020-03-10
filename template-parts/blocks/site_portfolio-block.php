<?php
/**
 * Reviews Block Template.
 *
 *
 */
$blockName = 'we-portfolio';
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

$block          = get_field('we_portfolio');
$instagram_type = get_field('instagram_include_type', 'options');
$title          = get_conf_title('text-center', $block);
$grid           = wp_kses_post( $block['columns'] );
$link           = $block['link'];
if( $link ){
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
}
$per_page       = $block['posts'] ? wp_kses_post( $block['posts'] ) : 4;
if( $grid ){
    $columns = 'grid-column-' . $grid;
}
else{
    $columns = 'grid-column-4';
}

if ( get_query_var('paged') ) {
                        $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {  
                        $paged = get_query_var('page');
} else {
                        $paged = 1;
}
$args = array(
                'numberposts' => 0,
                'posts_per_page' => $per_page ? $per_page : 4,
                'paged' => $paged,
                'post_type'   => 'portfolio',
                'orderby'     => 'status',
                'order'       => 'ASC',
                'suppress_filters' => true,
);
query_posts( $args );

if( $block && !empty( $instagram_type ) ) : ?>

<section id="<?php echo $id; ?>" class="<?php echo $className . ' ' . $blockName; ?>" data-ias="<?php echo $blockName; ?>">
    <div class="container">
        <div class="row">
            <?php if( $title ) : ?>
            <div class="col-12 justify-content-center align-items-center d-flex flex-column">
                <div class="section-header">
                    <?php echo $title; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if( have_posts() && $instagram_type === 'php' ) : ?>
    <div class="posts-wrap">
        <div class="grid-container <?php echo $columns; ?> ajax-container">
            <?php while (have_posts()) : the_post(); ?>
                                  <?php global $post; ?>
                                  <?php $title     = wp_kses_post( get_the_title() );
                                        $content   = strip_tags( wp_kses_post( get_the_content() ) ); 
                                        $content   = wp_trim_words( $content, 35, '...'); 
                                        $image     = wp_kses_post( get_the_post_thumbnail( $post->ID, 'medium', array('class' => 'img-inner portfolio-image') ) );
                                        $image_url = esc_url( get_the_post_thumbnail_url() );
                                        $link      = esc_url( get_permalink() );
                                        if( $image ) :
                                            $modal = aq_resize( $image_url, 800, 800, true, true, true);
                                        endif;
                                  ?>
                                   <div class="portfolio-wrap d-flex justify-content-center align-items-center" data-href="<?php echo $link; ?>" >
                                      <a href="<?php echo ( $modal ) ? esc_attr( $modal ) : '#'; ?>" data-fancybox="portfolio" class="fancybox portfolio-modal portfolio-item" <?php if( $title ) : ?>data-name="<?php echo $title; ?>"<?php endif; ?>>
                                              <?php if( $image ) : 
                                                        echo $image;
                                                    endif; ?>
                                              <div class="portfolio-content flex-column align-items-center w-100">
                                                  <?php if( $content ) : ?>
                                                      <div class="portfolio-text"><?php echo $content; ?></div>
                                                  <?php endif; ?>
                                                  <div class="portfolio-more"><?php echo __('Интересно?', 'hcc'); ?></div>
                                              </div>
                                      </a>
                                      <a href="<?php echo $link ? $link : '#'; ?>" class="portfolio-more-link"><?php echo __('Смотреть больше', 'hcc'); ?></a>
                                  </div>
            <?php endwhile; ?>
        </div>
        <?php if( function_exists( 'the_posts_pagination' ) ) : ?>
        <div class="container pagination-wrapper">
                    <div class="row">
                        <div class="col-12 d-none justify-content-center align-items-center">
                            <?php the_posts_pagination(); ?>
                        </div>
                    </div>
        </div>
        <?php endif; ?>
        
        <div class="container pagination-wrapper">
            <div class="row load-container">
                <?php $count_service = wp_count_posts('portfolio'); 
                if ( $count_service->publish > $per_page ) : ?>
                        <div class="col-12 d-flex justify-content-center align-items-center">
                           <div class="load-loder d-flex justify-content-center align-items-center"></div>
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-end align-items-center align-items-md-end">
                            <div class="load-more">
                               <div class="button box-button"><?php echo __('Показать ещё', 'hcc'); ?></div>
                            </div>
                            <div class="load-error d-none"><?php echo __('Невозможно выполнить запрос. Попробуйте, пожалуйста, позже', 'hcc'); ?></div>
                        </div>
                        <script>
                            var portfolio_posts        = '<?php echo serialize($args); ?>';
                            var portfolio_current_page =  <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                            var portfolio_max_pages    = '<?php echo ceil( $count_service->publish / $per_page ); ?>';
                        </script>
                 <?php endif; ?>
                 <?php if( $link ): ?>
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-end align-items-center align-items-md-start">
                        <a class="button portfolio-button d-flex align-items-center justify-content-center" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                            <?php echo esc_html( $link_title ); ?>
                        </a>
                    </div>
                  <?php endif; ?>
            </div>
         </div>
    </div>
    <?php endif; ?>
    <?php if( $instagram_type === 'js' ) : ?>
        <div class="posts-wrap">
            <div class="instagram-feed"><!-- JS parse here --></div>
        </div>
    <?php endif; ?>
</section>
<?php wp_reset_query();
endif; ?>