<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/* Register Meta Boxes */
add_filter( 'rwmb_meta_boxes', 'lgr_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function lgr_register_meta_boxes($meta_boxes) {
    /**
     * prefix of meta keys (optional)
     * Use underscore (_) at the beginning to make keys hidden
     * Alt.: You also can make prefix empty to disable it
     */
    $prefix = TPLNAME . '_';

    /**
     * The Current Page Visiting.
     * It's defined by WordPress.
     */
    global $pagenow;

    /* ---------------------------------------------------------------------- */
    /*  General
    /* ---------------------------------------------------------------------- */
    $meta_boxes[] = array(
        'id'       => 'general-settings',
        'title'    => __('General Settings', TPLNAME),
        'pages'    => array('page', 'post'),
        'context'  => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name'    => __('Page Layout', TPLNAME),
                'id'      => $prefix . 'page_layout',
                'type'    => 'radio',
                'options' => array(
                    ''              => '<img src="' . SS_BASE_URL . 'images/layout/default.png" alt="' . __('Use theme default setting', TPLNAME) . '" title="' . __('Use theme default setting', TPLNAME) . '" />',
                    'full-width'    => '<img src="' . SS_BASE_URL . 'images/layout/full-width.png" alt="' . __('Fullwidth - No sidebar', TPLNAME) . '" title="' . __('Fullwidth - No sidebar"', TPLNAME) . ' />',
                    'left-sidebar'  => '<img src="' . SS_BASE_URL . 'images/layout/left-sidebar.png" alt="' . __('Sidebar on the left', TPLNAME) . '" title="' . __('Sidebar on the left', TPLNAME) . '" />',
                    'right-sidebar' => '<img src="' . SS_BASE_URL . 'images/layout/right-sidebar.png" alt="' . __('Sidebar on the right', TPLNAME) . '" title="' . __('Sidebar on the right', TPLNAME) . '" />'
                ),
                'std'  => ( isset( $_GET['post_type'] ) && ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $_GET['post_type'] == 'page' ?  '1col' : '' ),
                'desc' => __('Here you can overwrite the Site Structure setting from the Theme Options, just for this page.', TPLNAME)
            ),
        )
    );

    /* ---------------------------------------------------------------------- */
    /*  Pages
    /* ---------------------------------------------------------------------- */
    $meta_boxes[] = array(
        'id'       => 'page-settings',
        'title'    => __('Page Settings', TPLNAME),
        'pages'    => array('page'),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __('Page Title', TPLNAME),
                'id'   => $prefix . 'page_title',
                'type' => 'text',
                'std'  => '',
                'desc' => __('This field will overwrite the default page title.', TPLNAME)
            ),
            array(
                'name' => __('Page Description', TPLNAME),
                'id'   => $prefix . 'page_description',
                'type' => 'text',
                'std'  => '',
                'desc' => __('This will be shown under the page title', TPLNAME)
            ),
            array(
                'name' => __('Page Subdescription', TPLNAME),
                'id'   => $prefix . 'page_subdescription',
                'type' => 'text',
                'std'  => '',
                'desc' => __('This will be shown under the page title or under the page description', TPLNAME)
            ),
            array(
                'name' => __('Disable Page Header', TPLNAME),
                'id'   => $prefix . 'disable_page_header',
                'type' => 'checkbox',
                'std'  => '',
                'desc' => ''
            ),
            array(
                'name' => __('Enable Comment Form', TPLNAME),
                'id'   => $prefix . 'enable_comment_form',
                'type' => 'checkbox',
                'std'  => '',
                'desc' => ''
            ),
        )
    );

    /* ---------------------------------------------------------------------- */
    /*  Portfolio
    /* ---------------------------------------------------------------------- */
    $meta_boxes[] = array(
        'id'       => 'project-settings',
        'title'    => __('Project Settings', TPLNAME),
        'pages'    => array('portfolio'),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name'     => __('Project Page Layout', TPLNAME),
                'id'       => $prefix . 'project_page_layout',
                'type'     => 'radio',
                'options' => array(
                    ''              => '<img src="' . SS_BASE_URL . 'images/layout/default.png" alt="' . __('Use theme default setting', TPLNAME) . '" title="' . __('Use theme default setting', TPLNAME) . '" />',
                    'full-width'    => '<img src="' . SS_BASE_URL . 'images/layout/full-width.png" alt="' . __('Fullwidth - No sidebar', TPLNAME) . '" title="' . __('Fullwidth - No sidebar"', TPLNAME) . ' />',
                    'left-sidebar'  => '<img src="' . SS_BASE_URL . 'images/layout/left-sidebar.png" alt="' . __('Sidebar on the left', TPLNAME) . '" title="' . __('Sidebar on the left', TPLNAME) . '" />',
                    'right-sidebar' => '<img src="' . SS_BASE_URL . 'images/layout/right-sidebar.png" alt="' . __('Sidebar on the right', TPLNAME) . '" title="' . __('Sidebar on the right', TPLNAME) . '" />'
                ),
                'std'  => '',
                'desc' => ''
            ),
        )
    );
    $meta_boxes[] = array(
        'id'       => 'project-gallery-slider',
        'title'    => __('Project Slider', TPLNAME),
        'pages'    => array('portfolio'),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __('Disable slider', TPLNAME),
                'id'   => $prefix . 'disable_project_slider',
                'type' => 'checkbox',
                'std'  => '',
                'desc' => __('By checking this option, you can disable the slider functionality (JavaScript part). But slides will be still generated, so you can use slides as you normally would.', TPLNAME)
            ),
            array(
                'name' => __('The Slides', TPLNAME),
                'id'   => $prefix . 'project_slider',
                'type' => 'project_slider',
                'std'  => '',
                'desc' => __('If slider has only one slide and it\'s totally empty, slider won\'t be created. <br /> Also, if slider has <u>only one</u> slide, which has any content, slider pagination arrows will be hidden.', TPLNAME)
            ),
        )
    );

    return $meta_boxes;
}