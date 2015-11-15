<?php
/**
 * The Header for Logger theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset ="<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Icon -->    
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ot_get_option(TPLNAME . '_favicon_upload', get_template_directory_uri().'/images/favicon.ico')?>" />
    <!-- Links -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( ot_get_option(TPLNAME . '_upgrade_browser_url') ): ?>
    <!--[if lt IE 9]>
        <script type="text/javascript">
            window.location.href = '<?php echo ot_get_option(TPLNAME . '_upgrade_browser_url'); ?>';
        </script>
    <![endif]-->
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="header">
        <div class="container">
            <div class="row-fluid">
                <?php
                    $logo_area_width = ot_get_option(TPLNAME . '_logo_area_width');
                    $margin_top      = ot_get_option(TPLNAME . '_logo_top_margin');
                    $margin_bottom   = ot_get_option(TPLNAME . '_logo_bottom_margin');

                    $logo_area_width = $logo_area_width ? $logo_area_width : 4;
                    $margin_top      = $margin_top ? $margin_top[0].$margin_top[1] : NULL;
                    $margin_bottom   = $margin_bottom ? $margin_bottom[0].$margin_bottom[1] : NULL;
                ?>

                <div id="logo" class="span<?php echo $logo_area_width; ?>" 
                     style="<?php echo $margin_top    ? "margin-top    : $margin_top; "    : '' ?>
                            <?php echo $margin_bottom ? "margin-bottom : $margin_bottom; " : '' ?>">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php if ( ot_get_option(TPLNAME . '_logo_upload') ): ?>
                        <img src="<?php echo ot_get_option(TPLNAME . '_logo_upload'); ?>" alt="Logo" />
                    <?php else: ?>
                        <h1><?php echo bloginfo('name'); ?></h1>
                    <?php endif; ?>
                    </a>
                </div>  <!-- #logo -->
                <div id="primary-navigation" class="span<?php echo (12 - $logo_area_width); ?>">
                    <?php 
                    if ( has_nav_menu('primary') ): 
                        wp_nav_menu(array(
                            'theme_location'    => 'primary',
                            'container'         => false,
                            'menu_class'        => 'list-inline',
                            'menu_id'           => '',
                            'echo'              => true,
                            'fallback_cb'       => 'wp_page_menu',
                            'depth'             => 3,
                            'walker'            => ''
                        )); ?>
                        <?php wp_nav_menu(array(
                          'theme_location'      => 'primary',
                          'container'           => false,
                          'echo'                => true,
                          'walker'              => new Walker_Nav_Menu_Dropdown(),
                          'depth'               => 3,
                          'items_wrap'          => '<select onchange="document.location.href=this.options[this.selectedIndex].value;">%3$s</select>',
                        )); 
                    endif;
                    ?>
                </div> <!-- #primary-navigation -->
            </div> <!-- .row-fluid -->
        </div> <!-- .container -->
    </div> <!-- #header -->
