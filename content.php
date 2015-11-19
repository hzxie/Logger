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
        <div class="post-share-view">
            <?php edit_post_link(__('Edit', TPLNAME), '<button class="btn">', '</button>'); ?>
            <a class="btn continue-reading" href="<?php echo get_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                <?php echo __('Continue Reading', TPLNAME) ?>
            </a>
        </div> <!-- .post-share-view -->
    </div> <!-- .entry-body -->
</div><!-- #post-## -->
