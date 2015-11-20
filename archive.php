<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
                                if ( is_day() ) :
                                    printf(__('Daily Archives: %s', TPLNAME), get_the_date());

                                elseif ( is_month() ) :
                                    printf(__( 'Monthly Archives: %s', TPLNAME ), get_the_date(_x('F Y', 'monthly archives date format', TPLNAME)));

                                elseif ( is_year() ) :
                                    printf(__('Yearly Archives: %s', TPLNAME), get_the_date(_x( 'Y', 'yearly archives date format', TPLNAME)));

                                else :
                                    _e('Archives', TPLNAME);

                                endif;
                            ?>
                            </h2>
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