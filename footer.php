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
    <a id="back-to-top" href="javascript:void(0);">
        <i class="fa fa-chevron-up"></i>
    </a>
    <!-- JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript">
        (function($) {
            $('#primary-navigation li.menu-item-has-children').hover(function() {
                $(this).addClass('hover');
                $('> .sub-menu', this).slideDown(100);
            }, function() {
                $(this).removeClass('hover');
                $('> .sub-menu', this).slideUp(100);
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        (function($) {
            $(window).scroll(function () {
                if( $(this).scrollTop() > 100 ) {
                    $("#back-to-top").css("right","20px");
                } else {
                    $("#back-to-top").css("right","-60px");
                }
            });
            $("#back-to-top").click(function() {
                $('html,body').animate({
                    scrollTop: 0
                }, 500);
            });
        })(jQuery);
    </script>
    <!-- Analytics Code -->
    <?php if ( ot_get_option(TPLNAME . '_analytics_code') ): ?>
    <?php echo ot_get_option(TPLNAME . '_analytics_code'); ?>
    <?php endif; ?>
</body>
</html>