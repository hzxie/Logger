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
                    <p><?php echo str_replace('${year}', date('Y'), ot_get_option(TPLNAME . '_copyright')); ?></p>
                </div> <!-- .span6 -->
                <div class="span6 text-right">
                    <p>
                    <?php 
                        $icp_number         = ot_get_option(TPLNAME . '_icp_number');
                        $police_icp_number  = ot_get_option(TPLNAME . '_police_icp_number');
                    ?>

                    <?php if ( $icp_number || $police_icp_number ): ?>
                        <?php echo $icp_number; ?> <br>
                        <img src="http://www.beian.gov.cn/img/ghs.png" alt="Police-Logo"> <?php echo $police_icp_number; ?>
                    <?php else: ?>
                        <?php echo __( 'Proudly powered by ', TPLNAME); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', TPLNAME ) ); ?>">WordPress</a>.
                    <?php endif; ?>
                    </p>
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
            $('.bibtex-trigger').click(function() {
                var bibtexInfoContainer = $('.bibtex', $(this).parent());

                if ( $(bibtexInfoContainer).is(':visible') ) {
                    $(bibtexInfoContainer).slideUp(250);
                } else {
                    $(bibtexInfoContainer).slideDown(250);
                }
            });
        })(jQuery);
    </script>
    <script type="text/javascript">
        (function($) {
            $.fn.slideHorzShow = function( speed, easing, callback ) { this.animate( { marginLeft : 'show', marginRight : 'show', paddingLeft : 'show', paddingRight : 'show', width : 'show' }, speed, easing, callback ); };
            $.fn.slideHorzHide = function( speed, easing, callback ) { this.animate( { marginLeft : 'hide', marginRight : 'hide', paddingLeft : 'hide', paddingRight : 'hide', width : 'hide' }, speed, easing, callback ); };

            var $container     = $('#portfolio-items'),
                $itemsFilter   = $('#portfolio-filter'),
                mouseOver;

            // Copy categories to item classes
            $('.portfolio', $container).each(function(i) {
                var $this = $(this);
                $this.addClass( $this.attr('data-category') );
            });

            // Run Isotope when all images are fully loaded
            $(window).on('load', function() {
                $container.isotope({
                    itemSelector : '.portfolio',
                    layoutMode   : 'fitRows'
                });
            });

            // Filter projects
            $itemsFilter.on('click', 'a', function(e) {
                var $this         = $(this),
                    currentOption = $this.attr('data-category');
                    
                $itemsFilter.find('a').removeClass('active');
                $this.addClass('active');

                if( currentOption ) {
                    if( currentOption !== '*' ) {
                        currentOption = currentOption.replace(currentOption, '.' + currentOption);
                    }
                    $container.isotope({ filter : currentOption });
                }

                e.preventDefault();
            });
        })(jQuery);
    </script>
    <!-- Analytics Code -->
<?php if ( ot_get_option(TPLNAME . '_analytics_code') ): ?>
    <?php echo ot_get_option(TPLNAME . '_analytics_code'); ?>
<?php endif; ?>
</body>
</html>
