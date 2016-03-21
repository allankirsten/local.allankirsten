<?php
class Testimonial {
    public function __construct() {
        $this->register_post_type();
        register_taxonomy('testimonial_category', 'testimonials', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));
    }
    
    private function register_post_type() {
        $args = array(
          'labels' => array(
              'name' =>'Testimonials',
              'singular_name' => 'Testimonial',
              'add_new' => 'Add new',
              'add_new_item' => 'Add new item',
              'edit_item' => 'Edit item',
              'new_item' => 'New item',
              'view_item' => 'View testimonials',
              'search_items' => 'Search testimonials',
              'not_found' => 'No tesimonials found'
          ),
            'query_var' => 'testimonials',
            'rewrite' => array(
                'slug' => 'testimonials'
            ),
            'public' => true,
            'supports' => array(
                            'title',
                            'editor',
                            'categories'
            )
        );
        
       register_post_type('testimonials', $args);
    }
}