<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */
/* Define Theme Name for Localization */
$themename = 'Logger';
$shortname = 'lgr';
define('TPLNAME', $shortname);

/* Define BaseURL of the Theme */
define('LGR_BASE_DIR', get_template_directory());
define('LGR_BASE_URL', get_template_directory_uri());

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Logger 1.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1200;
}

/* ---------------------------------------------------- */
/*  Enable Theme Options Plugin
/* ---------------------------------------------------- */
/* This will hide the settings & documentation pages. */
add_filter('ot_show_pages', '__return_false');

/* Required: set 'ot_theme_mode' filter to true. */
add_filter('ot_theme_mode', '__return_true');

/* Include OptionTree. */
include_once('3rdparty/option-tree/ot-loader.php');
    
/* Include Theme Options */
include_once('inc/theme-options.php');

/* ---------------------------------------------------- */
/*  Enable MetaBox Plugin
/* ---------------------------------------------------- */
/* Include MetaBox */
include_once('3rdparty/meta-box/meta-box.php');

/* Include MetaBox Options */
include_once('inc/meta-boxes.php');

/* Register Meta Boxes */
add_filter('rwmb_meta_boxes', 'lgr_register_meta_boxes');

/* ---------------------------------------------------- */
/*  Include Essential Conmponents
/* ---------------------------------------------------- */
require_once('inc/custom-post-types.php');
require_once('inc/nav-walker.php');
require_once('inc/widgets.php');
require_once('inc/shortcodes.php');

/* ---------------------------------------------------- */
/*  Setup Theme
/* ---------------------------------------------------- */
add_action('after_setup_theme', 'lgr_setup');
if ( !function_exists('lgr_setup') ) {
    function lgr_setup() {
        // Add Theme Supports
        add_theme_support('automatic-feed-links');
        add_theme_support('custom-background');
        add_theme_support('custom-header');
        add_theme_support('post-thumbnails'); 

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain(TPLNAME, LGR_BASE_DIR . '/languages');
        $locale      = get_locale();
        $locale_file = LGR_BASE_DIR . '/languages/$locale.php';
        if ( is_readable($locale_file) ) {
            require_once($locale_file);
        }

        // This theme uses wp_nav_menu() in one location.
        add_theme_support('menus');
        register_nav_menus(
            array(
                'primary' => __('Primary Menu', TPLNAME),
                'footer'  => __('Footer Menu', TPLNAME),
            )
        );

        // Add post formats support
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
        add_post_type_support('post', 'post-formats');

        // Add Editor Style
        add_editor_style(array('css/editor-style.css'));

        // Add CDN support
        $cdn_base_url = ot_get_option(TPLNAME . '_cdn_base_url');
        define('LGR_CDN_BASE_URL', empty($cdn_base_url) ? get_site_url() : ($cdn_base_url));
    }
}

/* ---------------------------------------------------- */
/*  CDN Rewriting
/* ---------------------------------------------------- */
if ( !function_exists('lgr_add_rewrite_rules') ) {
    function lgr_add_rewrite_rules($html) {
        $origin_regex = str_replace('/', '\\/', get_site_url());
        $html = preg_replace(
            '/'. $origin_regex .'\/wp-([^"\']*?)\.(jpg|jpeg|png|gif|bmp|css|js|woff|woff2|eot|otf|ttf|mp4|pdf)/i',
            LGR_CDN_BASE_URL .'/wp-$1.$2', $html);
        return $html;
    }

    function lgr_buffer_start() {
        ob_start("lgr_add_rewrite_rules");
    }
    add_action('init', 'lgr_buffer_start');

    function lgr_buffer_end() {
        while ( ob_get_level() > 0 ) {
            ob_end_flush();
        }
    }
    add_action('shutdown', 'lgr_buffer_end');
}

/* ---------------------------------------------------- */
/*  Register and Enqueue Styles
/* ---------------------------------------------------- */
if ( !function_exists('lgr_register_styles') ) {
    function lgr_register_styles() {
        wp_register_style('bootstrap',              LGR_BASE_URL . '/css/bootstrap.min.css');
        wp_register_style('bootstrap.responsive',   LGR_BASE_URL . '/css/bootstrap-responsive.min.css');
        wp_register_style('fontawesome',            LGR_BASE_URL . '/css/font-awesome.min.css');
        wp_register_style('google-fonts',           LGR_BASE_URL . '/css/google-fonts.min.css');
        wp_register_style('custom.style',           LGR_BASE_URL . '/style.css');
    }
    add_action('init', 'lgr_register_styles');
}

if ( !function_exists('lgr_enqueue_styles') ) {
    function lgr_enqueue_styles() {
        wp_enqueue_style('bootstrap');
        wp_enqueue_style('bootstrap.responsive');
        wp_enqueue_style('fontawesome');
        wp_enqueue_style('google-fonts');
        wp_enqueue_style('custom.style');
    }
    add_action('wp_print_styles', 'lgr_enqueue_styles');
}

/* ---------------------------------------------------- */
/*  Register and Enqueue Scripts
/* ---------------------------------------------------- */
if ( !function_exists('lgr_register_scripts') ) {
    function lgr_register_scripts() {
        wp_register_script('jquery.bootstrap',  LGR_BASE_URL . '/js/bootstrap.min.js');
        wp_register_script('jquery.isotope',    LGR_BASE_URL . '/js/jquery.isotope.min.js');

    }
    add_action('init', 'lgr_register_scripts');
}

if ( !function_exists('lgr_enqueue_scripts') ) {
    function lgr_enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery.bootstrap');
        wp_enqueue_script('jquery.isotope');
    }
    add_action('wp_print_scripts', 'lgr_enqueue_scripts');
}

/* ---------------------------------------------------- */
/*  Sidebar and Widgets
/* ---------------------------------------------------- */
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'id'            => 'sidebar',
        'name'          => 'Sidebar Area',
        'description'   => __('Widgets for all pages and posts.', TPLNAME),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h6 class="widget-title">',
        'after_title'   => '</h6>',
    ));

    register_sidebar(array(
        'id'            => 'footerleft',
        'name'          => 'Footer Left Area',
        'description'   => __('Left side of footer.', TPLNAME),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
    ));

    register_sidebar(array(
        'id'            => 'footerright',
        'name'          => 'Footer Right Area',
        'description'   => __('Right side of footer.', TPLNAME),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
    ));
}
// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

/* ---------------------------------------------------- */
/*  Customize the Title of Pages
/* ---------------------------------------------------- */
if ( !function_exists('lgr_wp_title') ) {
    /**
     * Create a nicely formatted and more specific title element text for output
     * in head of document, based on current view.
     *
     * @since Logger 1.0
     *
     * @global int $paged WordPress archive pagination page count.
     * @global int $page  WordPress paginated post page count.
     *
     * @param string $title Default title text for current view.
     * @param string $sep Optional separator.
     * @return string The filtered title.
     */
    function lgr_wp_title($title, $sep) {
        global $paged, $page;

        if ( is_feed() ) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo( 'name', 'display' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            $title = "$title $sep " . sprintf(__('Page %s', TPLNAME), max( $paged, $page ));
        }
        return $title;
    }
    add_filter('wp_title', 'lgr_wp_title', 10, 2);
}

/* ---------------------------------------------------- */
/*  Get Meta Data for Post
/* ---------------------------------------------------- */
if ( !function_exists('lgr_get_keywords') ) {
    function lgr_get_keywords() {
        global $wp_query;
        $post_id = $post_id ? $post_id : $wp_query->get_queried_object()->ID;

        if ( is_home() || is_page() ) {
            return ot_get_option(TPLNAME . '_blog_keywords');
        }
        $tags = wp_get_post_tags($post_id, array('fields' => 'names'));
        return implode(', ', $tags);

    }
}

if ( !function_exists('lgr_get_description') ) {
    function lgr_get_description() {
        global $wp_query;
        $post = $post ? $post : $wp_query->get_queried_object();
    
        if ( is_home() || is_front_page() ) {
            return ot_get_option(TPLNAME . '_blog_description');
        }
        return mb_substr(wp_trim_words($post->post_content), 0, 160);
    }
}

if ( !function_exists('lgr_get_post_meta') ) {
    function lgr_get_post_meta($key, $post_id = null) {
        global $wp_query;
        $post_id = $post_id ? $post_id : $wp_query->get_queried_object()->ID;
        return get_post_meta( $post_id, $key, true );
    }
}

/* ---------------------------------------------------- */
/*  Get Comments for Post
/* ---------------------------------------------------- */
if ( !function_exists('lgr_comments') ) {
    function lgr_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' : ?>
                <li class="post pingback">
                    <p><?php _e('Pingback:', TPLNAME); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', TPLNAME), ' '); ?></p>
        <?php   break;
            default : ?>
                <li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                    <div id="comment-<?php comment_ID(); ?>">
                        <?php echo get_avatar($comment, 50); ?>
                        <div class="comment-meta">
                            <h5 class="author">
                                <?php printf(__('%s', TPLNAME), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
                                <?php comment_reply_link(array_merge(array('before' => ' - '), array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            </h5>
                            <p class="date">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time pubdate datetime="<?php comment_time('c'); ?>">
                                        <?php printf(__('%1$s at %2$s', TPLNAME), get_comment_date(), get_comment_time()); ?>
                                    </time>
                                </a>
                            </p>
                        </div><!-- .comment-meta -->
                        <div class="comment-body">
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <p><em><?php _e('Your comment is awaiting moderation.', TPLNAME); ?></em></p>
                            <?php endif; ?>
                            <?php comment_text(); ?>
                            <?php edit_comment_link(__('(Edit)', TPLNAME), ' '); ?>
                        </div><!-- .comment-body -->
                    </div><!-- #comment -->
                </li>
        <?php
                break;
        endswitch;
    }
}

/* ---------------------------------------------------- */
/*  Excerpt
/* ---------------------------------------------------- */
if ( !function_exists('lgr_excerpt_length') ) {
    // Sets the post excerpt length to 120 words (or 20 words if post carousel)
    function lgr_excerpt_length($length) {
        if( isset($GLOBALS['post-carousel']) ) {
            return 20;
        }
        return ot_get_option(TPLNAME . '_excerpt_length');
    }
    add_filter('excerpt_length', 'lgr_excerpt_length');
}

if ( !function_exists('lgr_auto_excerpt_more') ) {
    // Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis
    function lgr_auto_excerpt_more( $more ) {
        return '&hellip;';
    }
    add_filter('excerpt_more', 'lgr_auto_excerpt_more');
}

/* ---------------------------------------------------- */
/*  Pagination
/* ---------------------------------------------------- */
if ( !function_exists('lgr_paging_nav') ) {
    function lgr_paging_nav($pages = '', $range = 2) {
        global $wp_query, $wp_rewrite;

        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $wp_query->max_num_pages,
            'current'  => $paged,
            'mid_size' => 2,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => __( '&larr; Previous', TPLNAME ),
            'next_text' => __( 'Next &rarr;', TPLNAME ),
        ) );

        if ( $links ) : ?>
            <div class="pagination">
                <?php echo $links; ?>
            </div><!-- .pagination -->
        <?php
        endif;
    }
}

// Disabled Auto Save
add_action('admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');" ));
