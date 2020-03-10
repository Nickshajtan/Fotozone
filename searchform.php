<?php
/**
 * Search form template file
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package hcc
 */
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  ?>
<form role="search" method="get" id="searchform" action="<?php echo ( !empty( SITE_URL ) ) ? SITE_URL : site_url(); ?>" >
    <fieldset>
        <input type="text" class="searchinput" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e('Type here...', 'hcc')?>" />
        <input type="submit" id="searchsubmit" class="headerfont" value="<?php _e('Search', 'hcc')?>" />
    </fieldset>
</form>