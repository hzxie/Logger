<?php
/**
 * ShortCodes
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */

/* ---------------------------------------------------- */
/*  Grid Layout
/* ---------------------------------------------------- */

/**
 * ShortCode: [row]
 * 
 * This shortcode is used to generate <div class="row"></div>.
 */
function lgr_row_shortcode( $atts, $content = null ) {
    return '<div class="row-fluid">' . do_shortcode( $content ) . '</div>';
}
add_shortcode('row', 'lgr_row_shortcode');

/**
 * ShortCode: [column]
 * 
 * This shortcode is used to generate <div class="span*"></div>.
 */
function lgr_column_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'offset' => 0,
        'column' => 0,
    ), $atts ) );

    if ( 0 === strpos($content, '</p>') ) { // Fix strange bug: $content starts with '</p>'
        $content = substr($content, 4);
    }
    return '<div class="offset' . $offset . ' span' . $column . '">' . do_shortcode( $content ) . '</div>';
}
add_shortcode('column', 'lgr_column_shortcode');

/* ---------------------------------------------------- */
/*  General
/* ---------------------------------------------------- */

/**
 * ShortCode: [button]
 *
 * This short code is used to generate a button.
 */
function lgr_button_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'url'    => '',
        'target' => '_blank',
        'size'   => '',
        'style'  => '',
        'arrow'  => ''
    ), $atts ) );

    $output = '<a class="btn btn-primary ' . esc_attr( $size ) . ' ' . esc_attr( $style ) . '" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
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
add_shortcode('button', 'lgr_button_shortcode');

/**
 * ShortCode: [list]
 *
 * This short code is used to generate a list(<ul>).
 */
function lgr_list_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'icon'  => '',
        'style' => ''
    ), $atts ) );

    return '<div class="' . esc_attr( $icon ) . ' ' . esc_attr( $style ) . '">' . $content . '</div>';
}
add_shortcode('list', 'lgr_list_shortcode');

/* ---------------------------------------------------- */
/*  Template Tags
/* ---------------------------------------------------- */

/**
 * ShortCode: [portfolio]
 *
 * This short code is used to generate portfolio items in projects page.
 */
function lgr_portfolio_shortcode( $atts, $content = null ) {
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
        foreach ($categories as $i => $category) {
            $category_slugs[$i] .= get_term($category, 'portfolio-categories')->slug;
        }
        $categories = implode( ',', $category_slugs );
        $args       = array_merge( $args, array( 'portfolio-categories' => esc_attr( $categories ) ) );
    }
    query_posts($args);

    $portfolio_categories = get_terms('portfolio-category', array('hide_empty' => false));
?>
    <ul id="portfolio-filter" class="inline">
        <li><a href="<?php echo get_permalink(ot_get_option(TPLNAME . '_portfolio_page')); ?>" data-category="*" class="active"><?php echo __('All', TPLNAME); ?></a></li>
    <?php foreach ( $portfolio_categories as $category ): ?>
        <li><a href="<?php echo get_term_link($category->slug, 'portfolio-category'); ?>" data-category="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></li>
    <?php endforeach; ?>
    </ul> <!-- #portfolio-filter -->
<?php
    if( have_posts() ) :
        $output .= '<div id="portfolio-items" class="clearfix">';
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

            $output .= '<div class="span' . esc_attr($columns) . ' portfolio" data-category="' . trim($data_category) . '">';
            $output .= '<div class="portfolio-container">';
            $output .= '    <div class="portfolio-one">';
                if( $post_thumbnail_img ) {
                    $output .= '<div class="portfolio-header">';
                    $output .= '    <a href="' . $permalink . '" title="' . get_the_title() . '"' . $lightbox_class . '>';
                    $output .= '        <img src="' . $post_thumbnail_img . '" alt="thumbnail" class="entry-image ' . $post_thumbnail_data['class'] . '">';
                    $output .= '    </a>';
                    $output .= '</div> <!-- .portfolio-header -->';
                }
                $output .= '<div class="portfolio-body">';
                $output .= '    <a href="' . get_permalink() . '" class="project-meta">';
                $output .= '        <h5 class="portfolio-name">' . get_the_title()  . '</h5>';
                $output .= '        <p class="portfolio-categories">' . substr(trim($category_names), 0, -2) . '</p>';
                $output .= '    </a>';
                $output .= '</div> <!-- .portfolio-body -->';
            $output .= '    </div> <!-- .portfolio-one -->';
            $output .= '</div> <!-- .portfolio-container -->';
            $output .= '</div> <!-- .portfolio -->';
        endwhile;

        $output .= '</div><!-- #portfolio-items -->';
        
        if( $pagination == 'yes' ) {
            $output .= lgr_paging_nav();
        }
        wp_reset_query();
    endif;

    return $output;
}
add_shortcode('portfolio', 'lgr_portfolio_shortcode');

/**
 * ShortCode: [project_carousel]
 * 
 * This short code is used to generate a carousel of projects.
 */
function lgr_projects_carousel_shortcode( $atts, $content = null ) {
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
            $output .= '<h3 class="section-title">' . esc_attr( $title ) . '</h3>';
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
add_shortcode('project_carousel', 'lgr_projects_carousel_shortcode');

/* ---------------------------------------------------- */
/*  Misc.
/* ---------------------------------------------------- */

/**
 * ShortCode: [fullwidth_map]
 * 
 * This short code is used to generate full width map in the page.
 */
function lgr_fullwidth_map_shortcode( $atts, $content = null ) {
    $map_html = '';

    extract(shortcode_atts(array(
        'provider'  => 'GoogleMap',
        'longitude' => '121.498586',
        'latitude'  => '31.239637',
        'zoom'      => 14,
        'apikey'    => '',
    ), $atts));
?>
    </div>
    <div id="map-container">
    <?php if ( $provider == 'GoogleMap' ): ?>

        <div id="google-map" class="map"></div>
        <script type="text/javascript">
           function initMap() {
                map = new google.maps.Map(document.getElementById('google-map'), {
                    center: {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>},
                    zoom: <?php echo $zoom; ?>
                });
            }
        </script>
        <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $apikey; ?>&callback=initMap"></script>

    <?php elseif ( $provider == 'MapBox' ): ?>

        <div id="mapbox" class="map"></div>
        <script src='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css' rel='stylesheet' />
        <script>
            mapboxgl.accessToken = '<?php echo $apikey; ?>';
            var map = new mapboxgl.Map({
                    container: 'mapbox',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [<?php echo $longitude; ?>, <?php echo $latitude; ?>],
                    zoom: <?php echo $zoom; ?>
                });
            var nav = new mapboxgl.NavigationControl(),
                scale = new mapboxgl.ScaleControl({
                    maxWidth: 80,
                    unit: 'imperial'
                });
            map.addControl(nav, 'top-left');
            map.addControl(scale);
            scale.setUnit('metric');
        </script>

    <?php else: ?>

        <div id="amap" class="map"></div>
        <script src="https://webapi.amap.com/loader.js"></script>
        <script type="text/javascript" >
            AMapLoader.load({
                key:'<?php echo $apikey; ?>',
                version:'2.0',
                plugins:['AMap.Scale', 'AMap.ToolBar', 'AMap.ControlBar', 'AMap.HawkEye']
            }).then((AMap)=>{
                var map = new AMap.Map('amap', {
                    resizeEnable: true,
                    zoom: <?php echo $zoom; ?>,
                    center: [<?php echo $longitude; ?>, <?php echo $latitude; ?>],
                    lang: 'en'
                });
                map.addControl(new AMap.Scale())
                map.addControl(new AMap.ToolBar({
                    position: {
                        top: '130px',
                        left: '50px'
                    }
                }))
                map.addControl(new AMap.ControlBar())
                map.addControl(new AMap.HawkEye())
            }).catch((e)=>{
                console.error(e)
            });
        </script>

    <?php endif; ?>
    </div> <!-- #map-container -->
    <div class="entry-body">
<?php
    return $map_html;
}
add_shortcode('fullwidth_map', 'lgr_fullwidth_map_shortcode');

/**
 * ShortCode: [comment_box]
 * 
 * This short code is used to generate comment box in the page.
 */
function lgr_comment_box_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'title'     => 'Let\'s keep in touch',
    ), $atts ) );

    ob_start();
    comments_template();
    $comment_box_html = ob_get_contents();
    ob_end_clean();

    return $comment_box_html;
}
add_shortcode('comment_box', 'lgr_comment_box_shortcode');
