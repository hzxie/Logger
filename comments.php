<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage SmartStart
 * @since SmartStart 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>
<div id="comments">
    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title">
            <?php if ( is_page() ): ?>
            
            <?php echo __('Let\'s keep in touch', TPLNAME); ?>
            
            <?php else: ?>
            
            <?php
                printf(_n('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), TPLNAME),
                    number_format_i18n( get_comments_number() ), get_the_title() );
            ?>

            <?php endif; ?>
        </h3>

        <ol class="comment-list">
            <?php
                wp_list_comments(array(
                    'callback'      => 'lgr_comments',
                ));
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <div id="comments-nav" class="pagination comment-pagination">
            <?php paginate_comments_links(); ?>
        </div><!-- #comments-nav -->
        <?php endif; // Check for comment navigation. ?>

        <?php if ( ! comments_open() ) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', TPLNAME); ?></p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>

    <?php comment_form(array(
        'fields' => apply_filters('comment_form_default_fields', array(
            'author'  => '<p class="comment-form-author"><label for="author">Name <span>(required)</span></label><input id="author" name="author" type="text" aria-required="true" required=""></p>',
            'email'   => '<p class="comment-form-email"><label for="email">Email <span>(required)</span></label><input id="email" name="email" type="email" aria-required="true" required=""></p>',
            'url'     => '<p class="comment-form-url input-block"><label for="url"><strong>Website</strong></label><input id="url" name="url" type="url"></p>',
        )),
    )); ?>
</div><!-- #comments -->
