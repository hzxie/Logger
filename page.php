<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
get_header(); 

/* Global Page Layout */
$blog_layout     = ot_get_option(TPLNAME . '_blog_layout');
/* Page Layout for this Page */
$page_layout     = lgr_get_post_meta(TPLNAME . '_page_layout');

if ( $page_layout ) {
    $blog_layout = $page_layout;
}
/* Is full Width Layout? */
$is_full_width   = ( $blog_layout == 'full-width' );
?>
	<div id="content">
		<div class="container">
			<div class="row-fluid">
            <?php if ( $blog_layout == 'left-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
                <div id="main-content" class="span<?php echo ($is_full_width ? 12 : 8);?>">
                <?php if ( have_posts() ):
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part('content', 'page');
                    endwhile;
                    // Dummy Pagination to Pass Theme Check 
                    wp_link_pages();
                    // Previous/next post navigation.
                    lgr_paging_nav();
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