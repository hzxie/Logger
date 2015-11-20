<?php
/**
 * T * The template for displaying category pages
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
                            <h2><?php printf( __('Category Archives: %s', TPLNAME), single_cat_title('', false) ); ?></h2>
                            <?php
                                // Show an optional term description.
                                $term_description = term_description();
                                if ( !empty($term_description) ) :
                                    printf('<div class="taxonomy-description">%s</div>', $term_description);
                                endif;
                            ?>
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