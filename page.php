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
    <?php if ( is_front_page() && ot_get_option(TPLNAME . '_slider_on') ): ?>
        <?php
            $slides           = ot_get_option(TPLNAME . '_mainslider');
            $number_of_slides = is_array($slides) ? count($slides) : 0;
        ?>
        <div id="home-slider" class="carousel slide">
            <?php if ( $number_of_slides > 0 ): ?>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                <?php foreach ( $slides as $index => $slide ): ?>
                    <div class="item <?php echo ( $index == 0 ? 'active' : false ); ?>">
                        <?php if ( $slide[TPLNAME . '_slide_extenal_link'] ): ?>
                        <a href="<?php echo $slide[TPLNAME . '_slide_extenal_link']; ?>" target="_blank">
                        <?php endif; ?>
                        <?php 
                            $media_url = $slide[TPLNAME . '_slide_media_upload'];
                            $media_fallback_url = $slide[TPLNAME . '_slide_image_fallback'];
                            $file_ext  = strtolower(pathinfo($media_url, PATHINFO_EXTENSION));
                            if ( $file_ext == "jpg" || $file_ext == "jpeg" ||
                                 $file_ext == "png" || $file_ext == "webp" ||
                                 $file_ext == "gif" ): ?>
                            <div class="slide-img" style="background-image: url('<?php echo $media_url ?>')"></div> <!-- .slide-img -->
                        <?php elseif ( $file_ext == "webm" || $file_ext == "mp4" ): ?>
                            <div class="slide-img">
                                <video poster="<?php echo $media_fallback_url ?>" autoplay="" loop="" muted="">
                                    <source src="<?php echo $media_url; ?>" type="video/<?php echo $file_ext; ?>">
                                </video>
                            </div> <!-- .slide-img -->
                        <?php endif; ?>
                            <?php if ( $slide['title'] && $slide[TPLNAME . '_slide_description'] ): ?>
                            <div class="carousel-caption">
                                <h2><?php echo $slide['title']; ?></h2>
                                <p><?php echo apply_filters('the_content', $slide[TPLNAME . '_slide_description']); ?></p>
                            </div> <!-- .carousel-caption -->
                            <?php endif; ?>
                        <?php if ( $slide[TPLNAME . '_slide_extenal_link'] ): ?>
                        </a>
                        <?php endif; ?>
                    </div> <!-- .item -->
                <?php endforeach; ?>
                </div> <!-- .carousel-inner -->
                <?php if ( $number_of_slides > 1 ): ?>
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php for ( $i = 0; $i < $number_of_slides; ++ $i ): ?>
                    <li data-target="#home-slider" data-slide-to="<?php echo $i; ?>" class="<?php echo ( $i == 0 ? 'active' : '' ) ?>"></li>
                    <?php endfor; ?>
                </ol>
                <!-- Controls -->
                <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
                <!-- JavaScript for Autoplay -->
                <script type="text/javascript">
                    (function($) {
                        $('.carousel').carousel();
                    })(jQuery);
                </script>
                <?php endif; ?>
            <?php endif; ?>
        </div> <!-- #home-slider -->
    <?php endif ?>
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