<?php
/**
 * Widgets
 *
 * @package WordPress
 * @subpackage Logger
 * @since Logger 1.0
 */

/* ---------------------------------------------------- */
/*  Twitter Feed
/* ---------------------------------------------------- */
class LGR_Twitter_Feed_Widget extends WP_Widget {
    
}

/* ---------------------------------------------------- */
/*  Weibo Feed
/* ---------------------------------------------------- */
class LGR_Weibo_Feed_Widget extends WP_Widget {
    
}

/* ---------------------------------------------------- */
/*  Instagram Feed
/* ---------------------------------------------------- */
class LGR_Instagram_Feed_Widget extends WP_Widget {
    
}

/* ---------------------------------------------------- */
/*  Flickr Feed
/* ---------------------------------------------------- */
class LGR_Flickr_Feed_Widget extends WP_Widget {
    
}

/* ---------------------------------------------------- */
/*  Weather Feed
/* ---------------------------------------------------- */
class LGR_Weather_Feed_Widget extends WP_Widget {

}

/* ---------------------------------------------------- */
/*  Contact Info
/* ---------------------------------------------------- */
class LGR_Contact_Info_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            // Base ID
            TPLNAME . '_contact_info',
            // Name
            __('Logger Contact Info', TPLNAME),
            // Args
            array('description' => __('A widget to display contact information. You can set contact information in Theme Options.', TPLNAME ))
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        } 

        $cdetail_address = ot_get_option(TPLNAME . '_cdetail_address'); 
        $cdetail_email   = ot_get_option(TPLNAME . '_cdetail_email'); 
        $cdetail_phone   = ot_get_option(TPLNAME . '_cdetail_phone'); ?>
        <ul class="inline">
            <?php if ( $cdetail_address ): ?>
            <li>
                <span class="cdetail">
                    <i class="fa fa-map-marker"></i> <?php echo $cdetail_address; ?>
                </span>
            </li>
            <?php if ( $cdetail_email ): ?>
            <li>
                <span class="cdetail">
                    <i class="fa fa-envelope"></i> <?php echo $cdetail_email; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if ( $cdetail_phone ): ?>
            <li>
                <span class="cdetail">
                    <i class="fa fa-phone"></i> <?php echo $cdetail_phone; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php endif; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
        } else {
            $title = __('Contact Us', TPLNAME);
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php __('Title:', TPLNAME); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = ( !empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

/* ---------------------------------------------------- */
/*  Social Links
/* ---------------------------------------------------- */
class LGR_Social_Links_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            // Base ID
            TPLNAME . '_social_links',
            // Name
            __('Logger Social Links', TPLNAME),
            // Args
            array('description' => __('A widget to display social links. You can set social links URL in Theme Options.', TPLNAME ))
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        } 

        $social_links = ot_get_option(TPLNAME . '_socialicons'); ?>
        <ul class="inline">
        <?php 
        if ( $social_links ):
            foreach ( $social_links as $social_link ): ?>
            <li>
                <a href="<?php echo $social_link[TPLNAME . '_icons_url']; ?>" 
                   title="<?php echo $social_link['title']; ?>"
                   target="_blank">
                   <i class="fa fa-<?php echo $social_link[TPLNAME . '_icons_service']; ?>"></i>
               </a>
           </li>
        <?php 
            endforeach;
        endif;
        ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if ( isset($instance['title']) ) {
            $title = $instance['title'];
        } else {
            $title = __('Stay Connected', TPLNAME);
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php __('Title:', TPLNAME); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = ( !empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

/* ---------------------------------------------------- */
/*  Register Custom Widgets
/* ---------------------------------------------------- */
add_action( 'widgets_init', function() {
    register_widget('LGR_Contact_Info_Widget');
    register_widget('LGR_Social_Links_Widget');
});

// NOTE: The function above can only used in PHP 5.3+
// If you are using PHP 5.2+, plase use the function below
/*
add_action('widgets_init',
    create_function('', 'return register_widget("Contact_Info_Widget");')
);
*/