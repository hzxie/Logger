<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
        $page_title             = lgr_get_post_meta(TPLNAME . '_page_title');
        $page_description       = lgr_get_post_meta(TPLNAME . '_page_description');
        $page_subdescription    = lgr_get_post_meta(TPLNAME . '_page_subdescription');
    ?>
    <?php if ( !empty($page_title) ): ?>
    <div class="entry-header">
        <h2><?php echo $page_title; ?></h2>
        
        <?php if ( !empty($page_description) ): ?>
            <h3 class="page-description"><?php echo $page_description; ?></h3>
        <?php endif; ?>

        <?php if ( !empty($page_subdescription) ): ?>
            <h3 class="page-subdescription"><?php echo $page_subdescription; ?></h3>
        <?php endif; ?>
    </div> <!-- .entry-header -->
    <?php endif; ?>

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

        <?php edit_post_link(__('Edit', TPLNAME), '<p class="edit-link">', '</p>'); ?>
    </div> <!-- .entry-body -->

    <?php if ( !is_front_page() && lgr_get_post_meta(TPLNAME . '_enable_comment_form') == '1' ): ?>
    <div id="comments">
        <?php comment_form(); ?>
    </div> <!-- #comments -->
    <?php endif; ?>
</div><!-- .post -->