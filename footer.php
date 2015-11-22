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
    <div id="colophon">
        <div class="container">
            <div class="row-fluid">
                <div class="span8">
                    <?php 
                    if ( has_nav_menu('footer') ): 
                        wp_nav_menu(array(
                            'theme_location'    => 'footer',
                            'container'         => false,
                            'menu_class'        => 'inline',
                            'menu_id'           => 'footer-nav',
                            'echo'              => true,
                            'fallback_cb'       => 'wp_page_menu',
                            'depth'             => 1,
                            'walker'            => ''
                        ));
                    endif;
                    ?>
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Left Area')) : endif; ?>
                </div> <!-- .span8 -->
                <div class="span4">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Right Area')) : endif; ?>
                </div> <!-- .span4 -->
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #colophon -->
    <div id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span6 text-left">
                    <?php echo str_replace('${year}', date('Y'), ot_get_option(TPLNAME . '_copyright')); ?>
                </div> <!-- .span6 -->
                <div class="span6 text-right">
                    <?php echo __( 'Proudly powered by ', TPLNAME); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', TPLNAME ) ); ?>">WordPress</a>.
                </div> <!-- .span6 -->
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #footer -->
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
                    $('#back-to-top').css('right', '20px');
                } else {
                    $('#back-to-top').css('right', '-60px');
                }
            });
            $("#back-to-top").click(function() {
                $('html,body').animate({
                    scrollTop: 0
                }, 500);
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        (function($) {
            
        })(jQuery);
    </script>
    <!-- Analytics Code -->
    <?php if ( ot_get_option(TPLNAME . '_analytics_code') ): ?>
    <?php echo ot_get_option(TPLNAME . '_analytics_code'); ?>
    <?php endif; ?>
</body>
</html>