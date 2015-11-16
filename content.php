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
    <?php if( has_post_thumbnail() ): ?>
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>">
            <?php the_post_thumbnail(); ?>
        </a>
    <?php endif; ?>
    <div class="entry-body">
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
            <h2 class="title"><?php the_title(); ?></h2>
        </a>
        <?php if ( is_singular() ): ?>
        
        <?php the_content(); ?>
        
        <?php else : ?>
        
        <p><?php the_excerpt(); ?></p>
        
        <?php endif; ?>
        
        <p><?php edit_post_link(__('Edit', TPLNAME), '<span class="edit-link">', '</span>'); ?></p>
    </div> <!-- .entry-body -->
    <div class="entry-meta">
        <ul>
            <li>
                <a href="<?php echo get_permalink(); ?>" title="<?php sprintf( esc_attr__('Permalink to %s', TPLNAME), the_title_attribute('echo=0') ); ?>" rel="bookmark">
                    <span class="post-format <?php get_post_format(); ?>"><?php echo __('Permalink', TPLNAME) ?></span>
                </a>
            </li>
            <li>
                <span class="title"><?php echo __('Posted:', TPLNAME); ?></span>
                <?php echo sprintf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s" pubdate>%4$s</time></a>', TPLNAME ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date(get_option('time_format')) ),
                    esc_html( get_the_date(get_option('date_format')) )); ?>
            </li>
            <li><span class="title"><?php echo __('Categories:', TPLNAME); ?></span> <?php echo get_the_category_list(', ', '', $post->ID); ?></li>
        <?php if ( get_the_tags() ): ?>
            <li><span class="title"><?php echo __('Tags:', TPLNAME); ?></span> <?php echo get_the_tag_list('', ', ', ''); ?></li>
        <?php endif; ?>
        <?php if ( comments_open() || (get_comments_number() != '0' && !comments_open()) ): ?>
            <li><span class="title"><?php echo __('Comments:', TPLNAME) ?></span> <a title="Comment on <?php echo get_the_title(); ?>" href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number(); ?></a></li>
        <?php endif; ?>
        </ul>
    </div> <!-- .entry-meta -->
</div><!-- #post-## -->
