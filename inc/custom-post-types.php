<?php
/**
 * Custom Post Types
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */

/* ---------------------------------------------------------------------- */
/*  Portfolio
/* ---------------------------------------------------------------------- */
/* Register New Post Type: Portfolio */
function ss_register_post_type_portfolio() {
    $labels = array(
        'name'               => __('Portfolio', TPLNAME),
        'singular_name'      => __('Project', TPLNAME),
        'add_new'            => __('Add New', TPLNAME),
        'add_new_item'       => __('Add New Project', TPLNAME),
        'edit_item'          => __('Edit Project', TPLNAME),
        'new_item'           => __('New Project', TPLNAME),
        'view_item'          => __('View Project', TPLNAME),
        'search_items'       => __('Search Projects', TPLNAME),
        'not_found'          => __('No projects found', TPLNAME),
        'not_found_in_trash' => __('No projects found in Trash', TPLNAME),
        'parent_item_colon'  => __('Parent Project:', TPLNAME),
        'menu_name'          => __('Portfolio', TPLNAME),
    );
    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'comments'),
        'taxonomies'          => array('portfolio-category'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => true,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => array('slug' => sanitize_title(ot_get_option(TPLNAME . '_portfolio_slug'))),
        'capability_type'     => 'post',
        'menu_position'       => null,
        'menu_icon'           => '',
    );
    register_post_type('portfolio', apply_filters( 'ss_register_post_type_portfolio', $args ));
} 
add_action('init', 'ss_register_post_type_portfolio');

/* Add Menu Icons for Portfolio in Administration Page */
function add_portfolio_menu_icons(){ ?>
    <style>
        #adminmenu .menu-icon-portfolio div.wp-menu-image:before {
            content: '\f322';
        }
    </style>
<?php
}
add_action( 'admin_head', 'add_portfolio_menu_icons' );

/* Register Categories for Portfolio */
function ss_register_portfolio_categories() {
    $labels = array(
        'name'                      => __('Categories', TPLNAME),
        'singular_name'             => __('Category', TPLNAME),
        'search_items'              => __('Search Categories', TPLNAME),
        'popular_items'             => __('Popular Categories', TPLNAME),
        'all_items'                 => __('All Categories', TPLNAME),
        'parent_item'               => __('Parent Category', TPLNAME),
        'parent_item_colon'         => __('Parent Category:', TPLNAME),
        'edit_item'                 => __('Edit Category', TPLNAME),
        'update_item'               => __('Update Category', TPLNAME),
        'add_new_item'              => __('Add New Category', TPLNAME),
        'new_item_name'             => __('New Category', TPLNAME),
        'separate_items_with_commas'=> __('Separate categories with commas', TPLNAME),
        'add_or_remove_items'       => __('Add or remove Categories', TPLNAME),
        'choose_from_most_used'     => __('Choose from most used Categories', TPLNAME),
        'menu_name'                 => __('Categories', TPLNAME),
    );
    $args = array(
        'labels'                    => $labels,
        'public'                    => true,
        'show_in_nav_menus'         => true,
        'show_ui'                   => true,
        'show_tagcloud'             => false,
        'hierarchical'              => true,
        'rewrite'                   => array('slug' => 'portfolio-category'),
        'query_var'                 => true
    );
    register_taxonomy('portfolio-category', array('portfolio'), apply_filters('ss_register_portfolio_categories', $args));
} 
add_action('init', 'ss_register_portfolio_categories');

/* Setup Columns to Display in Portfolio Administration Page */
function ss_setup_portfolio_columns() {
    $columns = array(
        'cb'                        => '<input type="checkbox" />',
        'thumbnail'                 => __('Thumbnail', TPLNAME),
        'title'                     => __('Name', TPLNAME),
        'portfolio-category'        => __('Categories', TPLNAME),
        'date'                      => __('Date', TPLNAME)
    );
    return $columns;
}
add_action('manage_edit-portfolio_columns', 'ss_setup_portfolio_columns');

/* Custom colums content for 'Portfolio' */
function ss_manage_portfolio_columns($column, $post_id) {
    global $post;

    switch ( $column ) {
        case 'thumbnail':
            echo '<a href="' . get_edit_post_link( $post_id ) . '">' . get_the_post_thumbnail($post_id, array(50, 50), array('title' => get_the_title($post_id))) . '</a>';
            break;
        case 'portfolio-category':
            $terms = get_the_terms( $post_id, 'portfolio-category' );

            if ( empty($terms) )
                break;
                $termsArray = array();

                foreach ( $terms as $term ) {
                    $termsArray[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'portfolio-category' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio-category', 'display' ) )
                    );
                }
                echo join(', ', $termsArray);
            break;
        default:
            break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'ss_manage_portfolio_columns', 10, 2);

/* Fix Highlight Problem in Menu */
function namespace_menu_classes( $classes , $item ){
    if ( get_post_type() == 'portfolio' ) {
        // remove unwanted classes if found
        $classes = str_replace( 'current_page_parent', '', $classes );
        
        // find the url you want and add the class you want
        if ( $item->object_id == ot_get_option(TPLNAME . '_portfolio_page') ) {
            $classes = str_replace( 'menu-item', 'menu-item current_page_parent', $classes );
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'namespace_menu_classes', 10, 2 );
