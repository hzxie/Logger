<?php
/**
 * The Template for displaying all single portfolios.
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
get_header(); 

/* Global Page Layout */
$blog_layout     = ot_get_option(TPLNAME . '_blog_layout');
?>
    <div id="content">
        <div class="container">
            <div class="row-fluid">
            <?php if ( $blog_layout == 'left-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
                <div id="main-content" class="span<?php echo ($is_full_width ? 12 : 8);?>">
                <?php 
                if ( have_posts() ):
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part('content', 'portfolio');
                    endwhile;
                    // Dummy Pagination to Pass Theme Check 
                    wp_link_pages();
                    // Previous/next post navigation.
                    lgr_paging_nav();
                endif;

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ):
                    comments_template();
                endif;
                ?>
                </div> <!-- #main-content -->
            <?php if ( $blog_layout == 'right-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #content -->
<?php
get_footer();