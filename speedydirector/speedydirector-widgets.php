<?php

class Speedydirector_Featured_Widget extends WP_Widget {
    public function __construct() {
        // widget actual processes
        parent::__construct( 
            'speedydirector_featured_business', 
            'Featured Business', 
            array('description' => __('Displays the Featured Business')) 
        );
    }

    public function form($instance) {
        // outputs the options form on admin
        $title = (isset($instance['title'])) ? $instance['title'] : 'Featured Business'; ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
            name="<?php echo $this->get_field_name('title'); ?>" 
            type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    
    public function widget($args, $instance) {
        // outputs the content of the widget
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if(!empty($title)) echo $before_title . $title . $after_title;
        $args = array(
            'post_type' => 'businesses',
            'posts_per_page' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'business-type',
                    'field' => 'slug',
                    'terms' => 'featured'
                )
            )
        );
        $featuredWidget = new WP_Query($args);
        while($featuredWidget->have_posts()) : $featuredWidget->the_post(); ?>
        <div class="widget_featured">
            <div class="thumb">
                <?php print get_the_post_thumbnail($post->ID); ?>
            </div>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php the_excerpt(); ?>
        </div>
        <?php endwhile;
        wp_reset_postdata();
        echo $after_widget; 
    }
}
register_widget('Speedydirector_Featured_Widget');

?>