<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package hcc
 */
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  
get_header(); ?>
    <!-- Content -->
    <div class="blog-center-align">

        <!-- Blog Caption -->
        <div class="blog-caption">
            <div class="blogtitle"><?php echo single_tag_title("", false); ?></div>
        </div>

        <!-- Blog Line -->
        <div class="blog-line"></div>

        <!-- Filters Here -->
        <ul class="blog-filter-line">
            <li><?php _e('Filter By','hcc'); ?>:</li>
            <li>
                <a class="filter-caption"><p><?php _e('Author','hcc'); ?></p><span></span></a>
                <ul>

                    <?php
                    $args = array(
                        'orderby'       => 'name',
                        'order'         => 'ASC',
                        'number'        => null,
                        'optioncount'   => false,
                        'exclude_admin' => false,
                        'show_fullname' => false,
                        'hide_empty'    => true,
                        'echo'          => true,
                        'style'         => 'list',
                        'html'          => true );

                    wp_list_authors($args); ?>
                </ul>

            </li>

            <li>
                <a class="filter-caption"><p><?php _e('Category','hcc'); ?></p><span></span></a>
                <ul>
                    <?php
                    $args = array(
                        'show_option_all'    => '',
                        'orderby'            => 'name',
                        'order'              => 'ASC',
                        'style'              => 'list',
                        'show_count'         => 0,
                        'hide_empty'         => 1,
                        'use_desc_for_title' => 1,
                        'child_of'           => 0,
                        'feed'               => '',
                        'feed_type'          => '',
                        'feed_image'         => '',
                        'exclude'            => '',
                        'exclude_tree'       => '',
                        'include'            => '',
                        'hierarchical'       => 1,
                        'title_li'           => '',
                        'show_option_none'   => __('No categories','hcc'),
                        'number'             => null,
                        'echo'               => 1,
                        'depth'              => 0,
                        'current_category'   => 0,
                        'pad_counts'         => 0,
                        'taxonomy'           => 'category',
                        'walker'             => null
                    );
                    wp_list_categories($args); ?>
                </ul>
            </li>

            <li>
                <a class="filter-caption"><p><?php _e('Tags','hcc'); ?></p><span></span></a>
                <?php
                $tags = get_tags();
                $html = '<ul>';
                foreach ( $tags as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );

                    $html .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                    $html .= "{$tag->name}</a></li>";
                }
                $html .= '</ul>';
                echo $html;
                ?>
            </li>

            <li class="search">
                <form role="search" method="get" id="searchform" action="<?php echo ( !empty( SITE_URL ) ) ? SITE_URL : site_url(); ?>" >
                    <input type="search" class="searchinput" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e('SEARCH', 'hcc')?>" />
                    <button type="submit" id="searchsubmit"></button>
                </form>
            </li>
        </ul>


        <!-- Blog Nav  -->
        <div class="blog-nav">
            <span class="left"><?php echo get_previous_posts_link(__('&lt; Newer Posts','hcc')); ?></span>
            <span class="right"><?php echo get_next_posts_link(__('Older Posts &gt;','hcc')); ?></span>
            <div class="center"><?php _e('page','hcc'); ?> <?php echo $paged; ?> <?php _e('of','hcc'); ?> <?php echo $wp_query->max_num_pages; ?></div>
        </div>

    </div>
<?php get_footer(); ?>