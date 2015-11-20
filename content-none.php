<?php
/**
 * The template used for displaying a "No posts found" message
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
?>

<div id="post-0" class="post">
    <div class="entry-header">
        <h2><?php echo __('No Posts Found', TPLNAME); ?></h2>
    </div> <!-- .entry-header -->
    <div class="entry-body">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

        <h3><?php printf(__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', TPLNAME ), admin_url( 'post-new.php' )); ?></h3>

        <?php elseif ( is_search() ) : ?>

        <h3><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', TPLNAME); ?></h3>

        <?php else : ?>

        <h3><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', TPLNAME); ?></h3>

        <?php endif; ?>
    </div> <!-- .entry-body -->
</div><!-- .post -->