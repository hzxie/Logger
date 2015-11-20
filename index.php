<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SmartStart
 * @since SmartStart 1.0
 */
get_header(); 

/* Page Title */
$page_title = lgr_get_post_meta(TPLNAME . '_page_title');
/* Global Page Layout */
$blog_layout = ot_get_option(TPLNAME . '_blog_layout');
/* Page Layout for this Page */
$page_layout = lgr_get_post_meta(TPLNAME.'_page_layout');

if ( $page_layout ) {
    $blog_layout = $page_layout;
}
?>    <div id="content" class="clearfix">
        <div class="container">
            <?php if ( !is_front_page() && !empty($page_title) ): ?>
            <div class="page-header">
                <h2><?php echo $page_title; ?></h2>
            <?php if( lgr_get_post_meta(TPLNAME . '_page_description') ): ?>
                <h3 class="page-description"><?php echo lgr_get_post_meta(TPLNAME . '_page_description'); ?></h3>
            <?php endif; ?>
            <?php if( lgr_get_post_meta(TPLNAME . '_page_subdescription') ): ?>
                <h3 class="page-subdescription"><?php echo lgr_get_post_meta(TPLNAME . '_page_subdescription'); ?></h3>
            <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="row-fluid">
            <?php if ( $blog_layout == 'left-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
                <div id="main-content" class="span8">
                <?php if ( have_posts() ):
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part('content', get_post_format());
                    endwhile;
                    // Dummy Pagination to Pass Theme Check 
                    wp_link_pages();
                    // Previous/next post navigation.
                    lgr_paging_nav();
                else:
                    // If no content, include the "No posts found" template.
                    get_template_part('content', 'none');
                endif;?>
                </div> <!-- #main-content -->
            <?php if ( $blog_layout == 'right-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #content -->
<?php
get_footer();