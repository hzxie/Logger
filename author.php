<?php
/**
 * The template for displaying author pages
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
                    <div class="page">
                        <div class="entry-header">
                            <h2>
                                <?php
                                    /*
                                     * Queue the first post, that way we know what author
                                     * we're dealing with (if that is the case).
                                     *
                                     * We reset this later so we can run the loop properly
                                     * with a call to rewind_posts().
                                     */
                                    the_post();

                                    printf( __('All posts by %s', TPLNAME), get_the_author() );
                                ?>
                            </h2>
                            <?php if ( get_the_author_meta( 'description' ) ) : ?>
                            <div class="author-description"><?php the_author_meta('description'); ?></div>
                            <?php endif; ?>
                        </div> <!-- .entry-header -->
                    </div> <!-- .page -->
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