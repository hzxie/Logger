<?php
/**
 * The template for displaying 404 pages (Not Found)
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
                    <div class="page page-404">
                        <div class="entry-header">
                            <h2>Error 404: <?php echo __('Page Not Found', TPLNAME); ?></h2>
                        </div> <!-- .entry-header -->
                        <div class="entry-body">
                            <h3><?php echo __('The requested URL was not found on this server.', TPLNAME); ?></h3>
                            <img src="<?php echo LGR_CDN_BASE_URL; ?>/images/404.png" alt="">
                        </div> <!-- .entry-body -->
                    </div><!-- .post -->
                </div> <!-- #main-content -->
            <?php if ( $blog_layout == 'right-sidebar' ): ?>
                <?php get_sidebar(); ?>
            <?php endif; ?>
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #content -->
<?php
get_footer();