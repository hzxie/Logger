<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page footer elements.
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
?>
    <?php wp_footer(); ?>
    <!-- Analytics Code -->
    <?php if ( ot_get_option(TPLNAME . '_analytics_code') ): ?>
    <?php echo ot_get_option(TPLNAME . '_analytics_code'); ?>
    <?php endif; ?>
</body>
</html>