<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
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
        <div class="entry-meta">
            <ul class="inline">
                <li>
                    <button class="btn">
                        <i class="fa fa-clock-o"></i>
                        <?php echo sprintf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s" pubdate>%4$s</time></a>', TPLNAME ),
                            esc_url( get_permalink() ),
                            esc_attr( get_the_time() ),
                            esc_attr( get_the_date(get_option('time_format')) ),
                            esc_html( get_the_date(get_option('date_format')) )); ?>
                    </button>                    
                </li>
                <li>
                    <button class="btn">
                        <i class="fa fa-folder-open"></i>
                        <?php echo get_the_category_list(', ', '', $post->ID); ?>
                    </button>
                </li>
            <?php if ( get_the_tags() ): ?>
                <li>
                    <button class="btn">
                        <i class="fa fa-tags"></i>
                        <?php echo get_the_tag_list('', ', ', ''); ?>
                    </button>
                </li>
            <?php endif; ?>
            <?php if ( comments_open() ): ?>
                <li>
                    <button class="btn">
                        <i class="fa fa-comments"></i>
                        <a title="Comment on <?php echo get_the_title(); ?>" href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number(); ?></a>
                    </button>
                </li>
            <?php endif; ?>
            </ul>
        </div> <!-- .entry-meta -->
    </div> <!-- .entry-header -->
    <?php 
    if( has_post_thumbnail() ): 
        $domsxe       = simplexml_load_string(get_the_post_thumbnail());
        $thumbnailsrc = $domsxe->attributes()->src;
    ?>
    <div class="entry-thumbnail" style="background-image: url('<?php echo $thumbnailsrc; ?>');"></div> <!-- .entry-thumbnail -->
    <?php endif; ?>
    <div class="entry-body">
        <?php if ( is_singular() ): ?>

        <?php the_content(); ?>

        <?php else : ?>

        <p><?php the_excerpt(); ?></p>

        <?php endif; ?>
        
        <?php if ( !is_singular() || is_user_logged_in() ): ?>
        <div class="post-share-view">
            <?php edit_post_link(__('Edit', TPLNAME), '<button class="btn">', '</button>'); ?>
            
            <?php if ( !is_singular() ): ?>
            <a class="btn continue-reading" href="<?php echo get_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                <?php echo __('Continue Reading', TPLNAME) ?>
            </a>
            <?php endif; ?>
        </div> <!-- .post-share-view -->
        <?php endif; ?>
    </div> <!-- .entry-body -->
</div><!-- .post -->

<?php if ( is_singular() ): ?>
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
        <?php if( isset( $prev_post[0] ) ): ?>
            <div class="span6">
                <a href="<?php echo $prev_post[0]; ?>" rel="prev" class="btn"><i class="fa fa-arrow-left"></i> <?php _e('Previous', TPLNAME); ?></a>
            </div> <!-- .span6 -->
        <?php endif; ?>
        <?php if( isset( $next_post[0] ) ): ?>
            <div class="span6 text-right">
                <a href="<?php echo $next_post[0]; ?>" rel="next" class="btn"><?php _e('Next', TPLNAME); ?> <i class="fa fa-arrow-right"></i></a>
            </div> <!-- .span6 -->
        <?php endif; ?>
    </div> <!-- .row-fluid -->
</div> <!-- .entry-nav -->
<?php endif; ?>