<?php
/**
 * The default template for displaying content of portfolio
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header">
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
            <h2 class="title"><?php the_title(); ?></h2>
        </a>
    </div> <!-- .entry-header -->
<?php 
if ( is_singular() ): 
    $slides         = lgr_get_post_meta(TPLNAME . '_project_slider');
    $lightbox       = ot_get_option(TPLNAME . '_single_project_lightbox');
    $slider_effect  = ot_get_option(TPLNAME . '_project_slider_effect');
    $slider_speed   = ot_get_option(TPLNAME . '_project_slider_speed');
    $slider_timeout = ot_get_option(TPLNAME . '_project_slider_timeout');

    if ( $slides != null && count($slides) ): ?>
    <div class="entry-thumbnail">
        <div id="portfolio-slides" class="carousel slide">
            <div class="carousel-inner">
            <?php foreach ( $slides as $index => $slide ): ?>
                <div class="item <?php echo ( $index == 0 ? 'active' : false ); ?>">
                    <a href="<?php echo $slide['slide-img-src']; ?>">
                        <img src="<?php echo $slide['slide-img-src']; ?>" alt="slide" />
                    </a>
                </div> <!-- .item -->
            <?php endforeach; ?>
            </div> <!-- .carousel-inner -->
            <?php if ( count($slides) != 1 ): ?>
            <ol class="carousel-indicators">
            <?php foreach ( $slides as $index => $slide ): ?>
                <li data-target="#portfolio-slides" data-slide-to="<?php echo $index; ?>" class="<?php echo ( $index == 0 ? 'active' : false ); ?>"></li>
            <?php endforeach; ?>
            </ol>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#portfolio-slides" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#portfolio-slides" data-slide="next">&rsaquo;</a>
            <?php endif; ?>
        </div> <!-- #portfolio-slides -->
    </div> <!-- .entry-thumbnail -->
    <?php 
    endif;
endif; ?>
    <div class="entry-body">
        <?php if ( is_singular() ): ?>

        <?php the_content(); ?>

        <?php else : ?>

        <p><?php the_excerpt(); ?></p>

        <?php endif; ?>
        
        <?php if ( !is_singular() || is_user_logged_in() ): ?>
        <div class="post-share-view">
            <?php edit_post_link(__('Edit', TPLNAME), '<p class="edit-link">', '</p>'); ?>
            
            <?php if ( !is_singular() ): ?>
            <a class="btn continue-reading" href="<?php echo get_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                <?php echo __('Continue Reading', TPLNAME) ?>
            </a>
            <?php endif; ?>
        </div> <!-- .post-share-view -->
        <?php endif; ?>
    </div> <!-- .entry-body -->
</div><!-- .post -->
<div class="entry-nav">
    <?php 
        // Get links for next and previous project
        ob_start();

            next_post_link( '%link', '%title' );

            $next_post_link = ob_get_contents();
            $next_post_link = preg_match( '/(?<=href\=")[^"]+?(?=")/', $next_post_link, $next_post );

        ob_clean();

            previous_post_link( '%link', '%title' );

            $previous_post_link = ob_get_contents();
            $previous_post_link = preg_match( '/(?<=href\=")[^"]+?(?=")/', $previous_post_link, $prev_post );

        ob_end_clean();
    ?>
    <div class="row-fluid">
        <div class="span6">
        <?php if( isset( $prev_post[0] ) ): ?>
            <a href="<?php echo $prev_post[0]; ?>" rel="prev" class="btn"><i class="fa fa-arrow-left"></i> <?php _e('Previous', TPLNAME); ?></a>
        <?php endif; ?>
        </div> <!-- .span6 -->
        <div class="span6 text-right">
        <?php if( isset( $next_post[0] ) ): ?>
            <a href="<?php echo $next_post[0]; ?>" rel="next" class="btn"><?php _e('Next', TPLNAME); ?> <i class="fa fa-arrow-right"></i></a>
        <?php endif; ?>
        </div> <!-- .span6 -->
    </div> <!-- .row-fluid -->
</div> <!-- .entry-nav -->
