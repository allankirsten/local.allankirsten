<?php
/* Get all widgets */
function get_all_widgets() {
    $dir = get_template_directory() . '/anps-framework/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $arr[] = $entry;
        }
        closedir($handle); 
      
        /* Remove widgets, ., .. */
        unset($arr[remove_widget('widgets.php', $arr)], $arr[remove_widget('.', $arr)], $arr[remove_widget('..', $arr)]);
        return $arr;
    }
}
/* Remove widget function */
function remove_widget($name, $arr) {
    return array_search($name, $arr);
}
/* Include all widgets */ 
foreach(get_all_widgets() as $item) {
    $item_file = get_template_directory() . '/anps-framework/widgets/'.$item;
    if( file_exists( $item_file ) ) {
        include_once $item_file;
    }
} 
/** Register sidebars by running widebox_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Sidebar', 'constructo'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'constructo'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Secondary Sidebar', 'constructo'),
        'id' => 'secondary-widget-area',
        'description' => __('Secondary widget area', 'constructo'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Top bar left', 'constructo'),
        'id' => 'top-bar-left',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'constructo'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Top bar right', 'constructo'),
        'id' => 'top-bar-right',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'constructo'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    $above_nav_bar = get_option('anps_above_nav_bar', '0');
    if ($above_nav_bar=='1') { 
        register_sidebar(array(
            'name' => __('Above navigation bar', 'constructo'),
            'id' => 'above-navigation-bar',
            'description' => __('This is a bar above main navigation. Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    //global $anps_options_data;
    //var_dump($anps_options_data);
    //Exit('1');

    if (get_option('vertical_menu', 0 ) == 'on') {
        //var_dump($anps_options_data['vertical_menu']); 
        register_sidebar(array(
            'name' => __('Vertical menu bottom widget', 'constructo'),
            'id' => 'vertical-bottom-widget',
            'description' => __('This widget displays only on desktop mode in vertical menu.', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }    

    $prefooter = get_option('prefooter');
    if($prefooter=="on") {
        $prefooter_columns = get_option('prefooter_style', '4');
        if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'constructo'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'constructo'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        } elseif($prefooter_columns=='3') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'constructo'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'constructo'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter 3', 'constructo'),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif($prefooter_columns=='4' || $prefooter_columns=='0') {
            register_sidebar(array(
                'name' => __('Prefooter 1', 'constructo'),
                'id' => 'prefooter-1',
                'description' => __('Prefooter 1', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 2', 'constructo'),
                'id' => 'prefooter-2',
                'description' => __('Prefooter 2', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter 3', 'constructo'),
                'id' => 'prefooter-3',
                'description' => __('Prefooter 3', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter 4', 'constructo'),
                'id' => 'prefooter-4',
                'description' => __('Prefooter 4', 'constructo'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        }
    }
    $footer_columns = get_option('footer_style', '4');
    if($footer_columns=='2') {
        register_sidebar(array(
            'name' => __('Footer 1', 'constructo'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'constructo'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
    } elseif($footer_columns=='3') {
        register_sidebar(array(
            'name' => __('Footer 1', 'constructo'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'constructo'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', 'constructo'),
            'id' => 'footer-3',
            'description' => __('Footer 3', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='4' || $footer_columns=='0') {
        register_sidebar(array(
            'name' => __('Footer 1', 'constructo'),
            'id' => 'footer-1',
            'description' => __('Footer 1', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 2', 'constructo'),
            'id' => 'footer-2',
            'description' => __('Footer 2', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer 3', 'constructo'),
            'id' => 'footer-3',
            'description' => __('Footer 3', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer 4', 'constructo'),
            'id' => 'footer-4',
            'description' => __('Footer 4', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $copyright_footer = get_option('copyright_footer', '1');
    if($copyright_footer=="1" || $copyright_footer=="0") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', 'constructo'),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($copyright_footer=="2") {
        register_sidebar(array(
            'name' => __('Copyright footer 1', 'constructo'),
            'id' => 'copyright-1',
            'description' => __('Copyright footer 1', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Copyright footer 2', 'constructo'),
            'id' => 'copyright-2',
            'description' => __('Copyright footer 2', 'constructo'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}