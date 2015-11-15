<?php
/**
 * ShortCodes
 *
 * @package WordPress
 * @subpackage SmartStart
 * @since SmartStart 1.0
 */

/* ---------------------------------------------------- */
/*  Grid Layout
/* ---------------------------------------------------- */

/**
 * ShortCode: [row]
 * 
 * This shortcode is used to generate <div class="row"></div>.
 */
function ss_row_shortcode( $atts, $content = null ) {
    return '<div class="row">' . do_shortcode( $content ) . '</div>';
}
add_shortcode('row', 'ss_row_shortcode');

/**
 * ShortCode: [column]
 * 
 * This shortcode is used to generate <div class="col-sm-*"></div>.
 */
function ss_column_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'offset' => 0,
        'column' => 0,
    ), $atts ) );

    return '<div class="col-md-offset-' . $offset . ' col-sm-' . $column . '">' . do_shortcode( $content ) . '</div>';
}
add_shortcode('column', 'ss_column_shortcode');

/* ---------------------------------------------------- */
/*  General
/* ---------------------------------------------------- */

/**
 * ShortCode: [button]
 *
 * This short code is used to generate a button.
 */
function ss_button_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'url'    => '',
        'target' => '_blank',
        'size'   => '',
        'style'  => '',
        'arrow'  => ''
    ), $atts ) );

    $output = '<a class="button ' . esc_attr( $size ) . ' ' . esc_attr( $style ) . '" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
    if( $arrow && $arrow == 'left' ) {
        $output .= '<span class="arrow ' . esc_attr( $arrow ) . '">&laquo;</span> ';
    }
    $output .= $content;

    if( $arrow && $arrow == 'right' ) {
        $output .= ' <span class="arrow">&raquo;</span>';
    }
    $output .= '</a>';

    return $output;
}
add_shortcode('button', 'ss_button_shortcode');

/**
 * ShortCode: [list]
 *
 * This short code is used to generate a list(<ul>).
 */
function ss_list_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'icon'  => '',
        'style' => ''
    ), $atts ) );

    return '<div class="' . esc_attr( $icon ) . ' ' . esc_attr( $style ) . '">' . $content . '</div>';
}
add_shortcode('list', 'ss_list_shortcode');

/* ---------------------------------------------------- */
/*  Template Tags
/* ---------------------------------------------------- */

/**
 * ShortCode: [portfolio]
 *
 * This short code is used to generate portfolio items in projects page.
 */
function ss_portfolio_shortcode( $atts, $content = null ) {
    $atts = extract(shortcode_atts(array(
        'columns'    => ot_get_option(TPLNAME . '_portfolio_layout'),
        'limit'      => -1,
        'categories' => '',
        'pagination' => 'yes'
    ), $atts));

    global $post;
    
    if( $pagination == 'yes' ) {
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    }

    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => esc_attr($limit),
        'order'          => 'DESC',
        'orderby'        => 'date',
        'post_status'    => 'publish',
        'paged'          => isset($paged) ? $paged : 1
    );
    
    if( $categories ) {
        $categories = explode( ',', $categories );
        foreach ( $categories as $i => $category ) {
            $category_slugs[$i] .= get_term( $category, 'portfolio-categories' )->slug;
        }
        $categories = implode( ',', $category_slugs );
        $args = array_merge( $args, array( 'portfolio-categories' => esc_attr( $categories ) ) );
    }
    query_posts( $args );

    if( have_posts() ) :
        // Fix Layout
        $output = '<section id="portfolio-items" class="clearfix" style="margin: 0 '. (esc_attr($columns) == '4' ? -15 : -16) .'px"">';
        $lightbox = ot_get_option(TPLNAME . '_single_project_lightbox');

        if( $lightbox == '1' ) {
            $lightbox_class = ' class="single-image"';
        } else {
            $lightbox_class = null;
        }

        while ( have_posts() ) : the_post();
            // Remove any old data
            $data_category   = null;
            $category_names  = null;

            $categories      = get_the_terms($post->ID, 'portfolio-category');
            if( $categories ) {
                foreach ( $categories as $category ) {
                    $data_category   .= $category->slug . ' ';
                    $category_names  .= $category->name . ' / ';
                }
            }

            $post_thumbnail_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio-' . esc_attr($columns));
            $post_thumbnail_img  = $post_thumbnail_data[0];

            if( $lightbox == '1' ) {
                $permalink = $post_thumbnail_img;
            } else {
                $permalink = get_permalink();
            }

            $output .= '<article class="col-sm-' . esc_attr($columns) . ' portfolio" data-category="' . trim($data_category) . '">';
            $output .= '    <div class="portfolio-container">';
                if( $post_thumbnail_img ) {
                    $output .= '<a href="' . $permalink . '" title="' . get_the_title() . '"' . $lightbox_class . '>';
                    $output .= '    <img src="' . $post_thumbnail_img . '" alt="thumbnail" class="entry-image ' . $post_thumbnail_data['class'] . '">';
                    $output .= '</a>';
                }
                $output .= '<a href="' . get_permalink() . '" class="project-meta">';
                $output .= '    <h5 class="title">' . get_the_title()  . '</h5>';
                $output .= '    <span class="categories">' . substr(trim($category_names), 0, -2) . '</span>';
                $output .= '</a>';
            $output .= '    </div> <!-- .portfolio-container -->';
            $output .= '</article> <!-- .portfolio -->';
        endwhile;

        $output .= '</section><!-- #portfolio-items -->';
        
        if( $pagination == 'yes' ) {
            $output .= ss_paging_nav();
        }
        wp_reset_query();
    endif;

    return $output;
}
add_shortcode('portfolio', 'ss_portfolio_shortcode');

/**
 * ShortCode: [project_carousel]
 * 
 * This short code is used to generate a carousel of projects.
 */
function ss_projects_carousel_shortcode( $atts, $content = null ) {
    $atts = extract(shortcode_atts(array(
        'title'        => __('Latest projects', TPLNAME),
        'limit'        => 8,
        'categories'   => '',
        'auto'         => 0,
        'scroll_count' => '',
    ), $atts));

    global $post;
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => esc_attr( $limit ),
        'order'          => 'DESC',
        'orderby'        => 'date',
        'post_status'    => 'publish'
    );
        
    if( $categories ) {
        $categories = explode( ',', $categories );
        foreach ( $categories as $i => $category ) {
            $category_slugs[$i] .= get_term( $category, 'portfolio-category' )->slug;
        }
        $categories = implode( ',', $category_slugs );
        $args = array_merge( $args, array( 'portfolio-category' => esc_attr( $categories ) ) );
    }
    query_posts( $args );

    if( have_posts() ) {
        $output = '';

        if( !empty( $title ) ) {
            $output .= '<h6 class="section-title">' . esc_attr( $title ) . '</h6>';
        }

        $output .= '<ul class="projects-carousel clearfix" data-auto="' . esc_attr( $auto ) . '" data-scroll_count="' . esc_attr( $scroll_count ) . '">';
            while( have_posts() ):
                the_post();

                // Remove any old data
                $data_categories = null;
                $category_names = null;

                $portfolio_categories = get_the_terms( $post->ID, 'portfolio-category' );
                $post_thumbnail_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'portfolio-' . esc_attr($columns));
                $post_thumbnail_img  = $post_thumbnail_data[0];


                if( $portfolio_categories ) {
                    foreach ( $portfolio_categories as $portfolio_category ) {
                        $data_categories .= $portfolio_category->slug . ' ';
                        $category_names .= $portfolio_category->name . ' / ';
                    }
                }
                
                $output .= '<li>';
                $output .= '    <a href="' . get_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
                if( $post_thumbnail_img ) {
                    $output .= '    <img src="' . $post_thumbnail_img . '" alt="thumbnail" class="entry-image ' . $post_thumbnail_data['class'] . '">';
                }
                $output .= '        <h5 class="title">' . get_the_title( $post->ID ) . '</h5>';
                $output .= '        <span class="categories">' . substr( trim( $category_names ), 0, -2 ) . '</span>';
                $output .= '    </a>';
                $output .= '</li><!-- end project -->';
            endwhile;
            $output .= '</ul><!-- end .projects-carousel -->';
        }
        wp_reset_query();
        return $output;
}
add_shortcode('project_carousel', 'ss_projects_carousel_shortcode');

/* ---------------------------------------------------- */
/*  Misc.
/* ---------------------------------------------------- */

/**
 * ShortCode: [fullwidth_map]
 * 
 * This short code is used to generate full width map in the page.
 */
function ss_fullwidth_map_shortcode( $atts, $content = null ) {
    $map_html = '';

    extract(shortcode_atts(array(
        'provider'  => 'GoogleMap',
        'longitude' => '121.498586',
        'latitude'  => '31.239637',
        'zoom'      => 16,
        'apikey'    => '',
    ), $atts));
?>

    </div> <!-- #main-content -->
    </section> <!-- .row -->
    </div> <!-- .container -->
    <div class="map-container">

    <?php if ( $provider == 'GoogleMap' ): ?>

        <div id="google-map" class="map"></div>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
        <script type="text/javascript">
            (function($) {
                mapObject = new google.maps.Map(document.getElementById('google-map'), {
                    zoom: <?php echo $zoom; ?>,
                    center: new google.maps.LatLng(<?php echo $longitude; ?>, <?php echo $latitude; ?>)
                });
            })(jQuery);
        </script>

    <?php else: ?>

        <div id="amap" class="map"></div>
        <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=<?php echo $apikey; ?>"></script>
        <script type="text/javascript">
            (function($) {
                mapObject = new AMap.Map("amap",{
                    rotateEnable: true,
                    dragEnable: true,
                    zoomEnable: true,
                    view: new AMap.View2D({
                        center: new AMap.LngLat(<?php echo $longitude; ?>, <?php echo $latitude; ?>),
                        zoom: <?php echo $zoom; ?>
                    })
                });
                mapObject.plugin(["AMap.ToolBar", "AMap.OverView", "AMap.Scale"], function() {
                    tool = new AMap.ToolBar({
                        direction: true,
                        ruler: true,
                        autoPosition: true
                    });
                    mapObject.addControl(tool);
                    view = new AMap.OverView();
                    mapObject.addControl(view);
                    scale = new AMap.Scale();
                    mapObject.addControl(scale);
                });
                mapObject.setLang("zh_en");
            })(jQuery);
        </script>

    <?php endif; ?>

    </div> <!-- .map-container -->
    <div class="container">
    <section class="row"> <!-- .row -->
    <div id="main-content" class="col-sm-12">

<?php
    return $map_html;
}
add_shortcode('fullwidth_map', 'ss_fullwidth_map_shortcode');

/**
 * ShortCode: [comment_box]
 * 
 * This short code is used to generate comment box in the page.
 */
function ss_comment_box_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'title'     => 'Let\'s keep in touch',
    ), $atts ) );

    ob_start();
    comments_template();
    $comment_box_html = ob_get_contents();
    ob_end_clean();

    return $comment_box_html;
}
add_shortcode('comment_box', 'ss_comment_box_shortcode');