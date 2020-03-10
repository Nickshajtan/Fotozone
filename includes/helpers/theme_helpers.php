<?php

/*
* hide admin bar front-end
*/ 
show_admin_bar( false );

/*
* allow svg files
*/ 
add_filter('upload_mimes', 'cc_mime_types');
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

/*
* limit blog intro title
*/
function get_title( $count, $content ) {
	$title = get_the_title();
	if (!empty($content)) {
		$title = $content;
	}
	if (strlen($title)>$count){
		$title = strip_tags($title);
		$title = substr($title, 0, $count);
		$title = substr($title, 0, strripos($title, " "));
		$title = $title.'...';
	}
	return $title;
}

/*
* limit blog intro text
*/
function get_excerpt( $count, $content ) {
	if (!empty($content)) {
		$excerpt = $content;
	} else {
		$excerpt = get_the_excerpt();
		if (empty($excerpt)) {
			$excerpt = get_the_content();
		}
	}
	if (mb_strlen($excerpt) > $count) {
		$excerpt = strip_tags($excerpt);
		$excerpt = mb_substr($excerpt, 0, $count);
		$excerpt = mb_substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = $excerpt.'...';
	}
	return $excerpt;
}

/*
* Add styles/classes to the "Styles" drop-down
*/
// add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
function fb_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title' => 'Title H1',
			'selector' => '*',
			'classes' => 'title-h1'
		),
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}


if ( ! function_exists( 'hcc_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function hcc_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'hcc' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'hcc_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function hcc_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'hcc' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'hcc_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function hcc_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'hcc' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'hcc' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'hcc' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'hcc' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'hcc' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'hcc' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'hcc_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function hcc_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
  * Apply all hooks the_content to get_the_content()
  *
  */
function hcc_get_content(){
    $content = get_the_content( $post -> ID );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    echo $content;
}

/**
  * Site logo: the_custom_logo() & ACF define
  *
  */
function hcc_the_custom_logo( $separator = '|' ){
    $logo_img='';
    if( !empty( SITE_LOGO ) ){
        if( is_front_page() || is_home() ){
             $logo_img = '<div class="site-branding">' . SITE_LOGO .'</div>';
        }
        else{
            if( !empty( THEME_HOME_URL) ){
                $logo_img = '<a href="' . THEME_HOME_URL . '" target="_self" class="site-branding">' . SITE_LOGO .'</a>';       
            }
            else{
                $logo_img = '<a href="/" target="_self" class="site-branding">' . get_custom_logo() .'</a>';
            }
        }
    }
    else{
        if( $separator ){
            $first    = substr( SITE_NAME, 0, strpos( SITE_NAME, $separator ) );
            $second   = stristr( SITE_NAME, $separator );   
        }
        else{
            $first = SITE_NAME;
            $second = '';
        }
        
        if( is_front_page() || is_home() ){
            $logo_img = '<div class="site-branding"><span class="main-part">' . $first . '</span>' . '<span class="separator-part"> ' . $second .'</span></div>';
        }
        else{
            $logo_img = '<a href="' . THEME_HOME_URL . '" target="_self" class="site-branding"><span class="main-part">' . $first . '</span>' . '<span class="separator-part"> ' . $second .'</span></a>';
        }
    }
    echo $logo_img;
}
