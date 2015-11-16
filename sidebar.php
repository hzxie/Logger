<?php
/**
 * The sidebar containing the sidebar widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
if ( is_active_sidebar('sidebar') ) : ?>
    <div id="sidebar" class="span4">
        <?php dynamic_sidebar('sidebar'); ?>
    </div> <!-- #sidebar -->
<?php endif; ?>