<?php
/* Header image, video, gallery (blog, portfolio) */
function anps_header_media($id, $image_class="") { 
    if(has_post_thumbnail($id)) { 
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    else { 
        $header_media = "";
    }
    return $header_media;
}
/* Header image, video, gallery (single blog/portfolio) */
function anps_header_media_single($id, $image_class="") {
    if(has_post_thumbnail($id) && !get_post_meta($id, $key ='gallery_images', $single = true )) { 
        $header_media = get_the_post_thumbnail($id, $image_class);
    }
    elseif(get_post_meta($id, $key ='anps_featured_video', $single = true )) { 
        $header_media = do_shortcode(get_post_meta($id, $key ='anps_featured_video', $single = true ));
    }
    elseif(get_post_meta($id, $key ='gallery_images', $single = true )) { 
        $gallery_images = explode(",",get_post_meta($id, $key ='gallery_images', $single = true )); 
        
        foreach($gallery_images as $key=>$item) {
            if($item == '') {
                unset($gallery_images[$key]);
            }
        }
        $number_images = count($gallery_images);
        $header_media = "";
        $header_media .= "<div id='carousel' class='carousel slide'>";
        if($number_images>"1") {
            $header_media .= "<ol class='carousel-indicators'>";
            for($i=0;$i<count($gallery_images);$i++) {
                if($i==0) {
                    $active_class = "active";
                } else {
                    $active_class = "";
                }
                $header_media .= "<li data-target='#carousel' data-interval='false' data-slide-to='".$i."' class='".$active_class."'></li>";
            }
            $header_media .= "</ol>";
        }
        $header_media .= "<div class='carousel-inner'>";
        $j=0;
        foreach($gallery_images as $item) {
            $image_src = wp_get_attachment_image_src($item, $image_class); 

            $image_title = get_the_title($item); 
            if($j==0) {
                $active_class = " active";
            } else {
                $active_class = "";
            }
            $header_media .= "<div class='item$active_class'>";
            $header_media .= "<img alt='".$image_title."'  src='".$image_src[0]."'>";
            $header_media .= "</div>";
            $j++;
        }
        $header_media .= "</div>";
        if($number_images>"1") {
            $header_media .= "<a class='left carousel-control' href='#carousel' data-slide='prev'>
                                <span class='fa fa-chevron-left'></span>
                              </a>
                              <a class='right carousel-control' href='#carousel' data-slide='next'>
                                <span class='fa fa-chevron-right'></span>
                              </a>";
                      
        }
        $header_media .= "</div>";
    }
    else { 
        $header_media = "";
    }
    return $header_media;
}
function anps_get_header() {
    /* Get fullscreen page option */
    $page_heading_full = get_post_meta(get_queried_object_id(), $key ='anps_page_heading_full', $single = true ); 
    
    //Let's get menu type   
    if (get_option('vertical-menu', "0")== "on" ) {
        $anps_menu_type = "2";
    } else if (is_front_page() == "true" ) {
        $anps_menu_type = get_option('anps_menu_type', '2');
        
    } else {
        $anps_menu_type = "2";
    }

    $anps_full_screen = get_option('anps_full_screen', "");
 
    $menu_type_class = " style-2";
    $header_position_class = " relative";
    $header_bg_style_class = " bg-normal";
    $absoluteheader = "false";
        
    //Header classes and variables 
    if($anps_menu_type == "1" || (isset($page_heading_full)&&$page_heading_full=="on")) {
        $menu_type_class = " style-1";
        $header_position_class = " absolute";
        $header_bg_style_class = " bg-transparent";
        $absoluteheader = "true";
    } elseif($anps_menu_type == "3") {
        $menu_type_class = " style-3";
        $header_position_class = " absolute moveup";
        $header_bg_style_class = " bg-transparent";
        $absoluteheader = "true";
    } elseif($anps_menu_type == "4") {
        $menu_type_class = " style-4";
        $header_position_class = " relative";
        $header_bg_style_class = " bg-normal";
        $absoluteheader = "false";
    } 

    //Top menu style 
    $topmenu_style = get_option('topmenu_style', '1');
   
    //left, right and center menu styles: 
    $menu_left_center_right_class = "";
    $menu_center = get_option('menu_center', "");
    if ($menu_center =="on" && ($anps_menu_type =="2"||$anps_menu_type =="4")) {
        $menu_left_center_right_class=" style-3";
    } 

    //sticky menu
    $sticky_menu = get_option('sticky_menu', "");
    $sticky_menu_class = "";
    if ($sticky_menu=="on") {
        $sticky_menu_class = "sticky";    
    }
    //if coming soon page is enabled
    $coming_soon = get_option('coming_soon', '0');
    if($coming_soon=="0"||is_super_admin()) : 
    ?>


    <?php //search ?>
    <?php if ($anps_menu_type == "1" || $anps_menu_type == "2") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>

    <?php //added option for transparent top bar menu type 1 (24.2.2015)
    if(($anps_menu_type == "1" || (isset($page_heading_full)&&$page_heading_full=="on"))&& (get_option('topmenu_style') == '1')) : ?>
    <div class="transparent top-bar<?php if($topmenu_style=="2") {echo " style-2";} ?>">
        <?php anps_get_top_bar(); ?>
    </div>
    <?php endif; ?>


    <?php //topmenu
    if($anps_menu_type == "2" && (get_option('topmenu_style') == '1') && (!isset($page_heading_full) || $page_heading_full=="")) : ?>
    <div class="top-bar<?php if($topmenu_style=="2") {echo " style-2";} ?>">
        <?php anps_get_top_bar(); ?>
    </div>
    <?php endif; ?>

    <?php // load shortcode from theme options textarea if needed 
    if ($anps_menu_type=="3" || $anps_menu_type=="4") {
        echo do_shortcode($anps_full_screen);
    }
    ?>


    <?php     
    global $anps_media_data;
    $has_sticky_class= "";

    if (isset($anps_media_data['sticky_logo']) && $anps_media_data['sticky_logo'] != "")  {
        $has_sticky_class = " has_sticky";
    } ?>

    <?php  //pushdown class adjusts header to be 60px from the top, so there is a place for an absolute positioned top-bar
    $pushdown = "";
    if($anps_menu_type == "1" && (get_option('topmenu_style') == '1') || (isset($page_heading_full)&&$page_heading_full=="on")) {
        $pushdown = " push-down";
    }; ?>


    <?php $anps_header_styles = esc_attr($sticky_menu_class) . esc_attr($menu_type_class) . esc_attr($header_position_class) . esc_attr($header_bg_style_class) . esc_attr($has_sticky_class) . esc_attr($pushdown);?>

    <?php 
    global $anps_options_data;
    if (isset ($anps_options_data['vertical_menu']) && $anps_options_data['vertical_menu'] == 'on') {
        $anps_header_styles = "vertical-menu";
    }
    ?>

    <?php //search ?>
    <?php if ($anps_menu_type == "4") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>

    <?php $header_style ="";?>
    <?php $header_bg_image = "";
    if (isset($anps_options_data['custom-header-bg-vertical']) && ($anps_options_data['custom-header-bg-vertical'] != "")) 
        {
        $header_bg_image = esc_attr($anps_options_data['custom-header-bg-vertical']); 

        //$header_style = ' style= "background: transparent url('. $header_bg_image .') no-repeat scroll center 0 / cover;"';
        $header_style = ' style= "background: transparent url('. $header_bg_image .') no-repeat scroll center 0 / 100% auto;"';
          
          //var_dump($header_style); Exit;
        }
    ?>     
    <header class="site-header <?php echo $anps_header_styles; ?> " <?php echo $header_style;?> >
    
        <div class="nav-wrap<?php echo esc_attr($menu_left_center_right_class); ?>">
            <div class="container"><?php anps_get_sticky_logo() . anps_get_site_header();?></div>
        </div>  
        <div class="sticky-holder"></div>  

        <?php //vertical menu bottom widget area 
        $vertical_menu = get_option('vertical_menu', '0');
        if( ($vertical_menu == 'on') && (is_active_sidebar( 'vertical-bottom-widget')) ) : ?>
            <div class="vertical-bottom-sidebar">
                <div class="col-md-12">
                    <ul class="vertical-bottom">
                        <?php do_shortcode(dynamic_sidebar( 'vertical-bottom-widget' ));?>
                    </ul>
                </div>
            </div>        
        <?php endif;?>  
  
    </header>
    <?php if ($anps_menu_type == "3") : ?>
    <div class="site-search">
            <?php anps_get_search(); ?>
    </div>
    <?php endif; ?>


    <?php global $anps_options_data, $anps_page_data;
        $disable_single_page = "";
        if(function_exists( 'is_woocommerce' ) && is_woocommerce()) {
            if(is_shop()) {
                $disable_single_page = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='anps_disable_heading', $single = true );
            } elseif(is_product()) {
                $disable_single_page = get_post_meta(get_queried_object_id(), $key ='anps_disable_heading', $single = true );
            }
        } else {
            $disable_single_page = get_post_meta(get_queried_object_id(), $key ='anps_disable_heading', $single = true );
        }
        if(!$disable_single_page=="1" && (!isset($page_heading_full) || $page_heading_full=="")) : 
            if(is_front_page()==false && !isset($anps_options_data['disable_heading'])) : 
                global $anps_media_data;
                $style = "";
                $class = "";
                $single_page_bg = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true );
                if(is_search()) {
                    if($anps_media_data['search_heading_bg']) {
                        $style = ' style="background-image: url('.esc_url($anps_media_data['search_heading_bg']).');"';
                    } else {
                        $class = "style-2";
                    }
                } elseif(function_exists( 'is_woocommerce' ) && is_woocommerce()) {
                    if(is_product()) { 
                        if(!get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true )) {
                            $shop_page_bg = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='heading_bg', $single = true );
                        } else {
                            $shop_page_bg = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true );
                        }
                    } elseif(is_shop()) {
                        $shop_page_bg = get_post_meta(get_option( 'woocommerce_shop_page_id' ), $key ='heading_bg', $single = true );
                    }
                    if(isset($shop_page_bg)) {
                        $style = ' style="background-image: url('.$shop_page_bg.');"'; 
                    }
                    elseif($anps_media_data['heading_bg']) {
                        $style = ' style="background-image: url('.$anps_media_data['heading_bg'].');"';
                    } else {
                        $class = "style-2";
                    }
                } else {
                    if($single_page_bg) {
                        $style = ' style="background-image: url('.esc_url($single_page_bg).');"'; 
                    }
                    elseif($anps_media_data['heading_bg']) {
                        $style = ' style="background-image: url('.esc_url($anps_media_data['heading_bg']).');"';
                    } else {
                        $class = "style-2";
                    }
                } 
                ?>
                <div class='page-heading <?php echo esc_attr($class); ?>'<?php echo $style; ?>>
                    <div class='container'>
                        <?php echo anps_site_title(); ?>
                        <?php if(!isset($anps_options_data['breadcrumbs'])) { echo anps_the_breadcrumb(); } ?>
                    </div>
                </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if(isset($page_heading_full)&&$page_heading_full=="on") : ?>
<div class='page-heading'>
    <div class='container'>
        <?php echo anps_site_title(); ?>
        <?php if(!isset($anps_options_data['breadcrumbs'])) { echo anps_the_breadcrumb(); } ?>
    </div>
</div>
</div>
<?php endif; ?>
<?php 
endif;
}

function anps_page_full_screen_style() {
    $full_color_top_bar = get_post_meta(get_queried_object_id(), $key ='anps_full_color_top_bar', $single = true );
    $full_color_title = get_post_meta(get_queried_object_id(), $key ='anps_full_color_title', $single = true );   
    $full_hover_color = get_post_meta(get_queried_object_id(), $key ='anps_full_hover_color', $single = true ); 
    if(!isset($full_color_top_bar) || $full_color_top_bar=="") {
        $top_bar_color = get_option("top_bar_color");
    } else {
        $top_bar_color = $full_color_top_bar;
    }
    if(!isset($full_color_title) || $full_color_title=="") {
        $title_color = get_option("menu_text_color");
    } else {
        $title_color = $full_color_title;
    }
    if(!isset($full_hover_color) || $full_hover_color=="") {
        $hover_color = get_option("hovers_color");
    } else {
        $hover_color = $full_hover_color;
    }
    ?>
<style>
.paralax-header > .page-heading .breadcrumbs li a::after, .paralax-header > .page-heading h1, .paralax-header > .page-heading ul.breadcrumbs, .paralax-header > .page-heading ul.breadcrumbs a, .site-navigation ul > li.menu-item > a
 {color:<?php echo esc_attr($title_color); ?>;}

.transparent.top-bar, .transparent.top-bar a 
{color:<?php echo esc_attr($top_bar_color); ?>;}

.transparent.top-bar a:hover, .paralax-header > .page-heading ul.breadcrumbs a:hover, .site-navigation ul > li.menu-item > a:hover 
 {color:<?php echo esc_attr($hover_color); ?>;}   

@media (min-width: 992px) {
 .nav-wrap:not(.sticky) .fa-search
 {color:<?php echo esc_attr($title_color); ?>;}
}

</style>

<?php
}

function anps_site_title() {
    get_template_part( 'includes/site_title' );
}

function anps_get_sticky_logo() { 
    global $anps_media_data;
    if (isset($anps_media_data['sticky_logo']) && $anps_media_data['sticky_logo'] != "") : ?>
        <div class="logo-wrap table absolute"><a id="sticky-logo" href="<?php echo esc_url(home_url("/")); ?>"><img alt="Site logo" src="<?php echo esc_url($anps_media_data['sticky_logo']); ?>"></a></div>
    <?php endif;
}

/* Breadcrumbs */ 
function anps_the_breadcrumb() {
    global $anps_page_data, $post;
    $return_val = "<ul class='breadcrumbs'>";
    
    $return_val .= '<li><a href="' . home_url() .'">' . __("Home", 'constructo') . '</a></li>';
    if (is_home() && !is_front_page()) { 
        $return_val .= "<li>".get_the_title(get_option('page_for_posts'))."</li>";
    } else {
        if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
            $return_val = "<ul class='breadcrumbs'>";
            ob_start();
            woocommerce_breadcrumb();
            $return_val .= ob_get_clean();
        } elseif (is_category() || is_single()) { 
            if (is_single()) { 
                if (get_post_type() != "portfolio" && get_post_type() != "post") { 
                    $obj = get_post_type_object( get_post_type() );
                    if( $obj->has_archive ) {
                        $return_val .= '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $obj->labels->name . '</a></li>';
                    }
                    $return_val .= '<li>' . get_the_title() . '</li>';
                } else {
                    $custom_breadcrumbs = get_post_meta( get_the_ID(), $key = 'custom_breadcrumbs', $single = true );
                    if($custom_breadcrumbs!="" && $custom_breadcrumbs!="0") { 
                        $return_val .= "<li><a href='".get_permalink($custom_breadcrumbs)."'>".get_the_title($custom_breadcrumbs)."</a></li>";
                    }
                    $return_val .= "<li>".get_the_title()."</li>";
                }
            }
        }
        elseif (is_page()) { 
            if(isset($post->post_parent) && ($post->post_parent!=0 || $post->post_parent!="")) { 
                $parent_id  = $post->post_parent;
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                } 
                for($i=count($breadcrumbs);$i>=0;$i--) {
                    $return_val .= isset($breadcrumbs[$i]) ? $breadcrumbs[$i] : null;
                }
                $return_val .= "<li>".get_the_title()."</li>";
            } else {
                $return_val .= "<li>".get_the_title()."</li>";
            }
        } elseif (is_archive()) {
            if (is_author()) {
                $author = get_the_author_meta('display_name', get_query_var("author"));
                $return_val .= "<li>" . $author ."</li>";
            } elseif(is_tag()) {
                $cat = get_tag(get_queried_object_id());
                $return_val .= "<li>".$cat->name . "</li>";
            } else {
                if( get_post_type() == 'post' ) {
                    $return_val .= "<li>" . __("Archives for", 'constructo') . " " . get_the_date('F') . ' ' . get_the_date('Y')."</li>";
                } else {
                    $obj = get_post_type_object( get_post_type() );
                    if( $obj->has_archive ) {
                        $return_val .= '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $obj->labels->name . '</a></li>';
                    }
                }
                
            }
        } else {
            if (get_search_query() != "") {
            } else {
                if( isset($anps_page_data['error_page']) && $anps_page_data['error_page'] != '' && $anps_page_data['error_page'] != '0' ) {
                    $page = get_page($anps_page_data['error_page']);
                    $return_val .= "<li>" . $page->post_title . "</li>";
                } else {
                    $return_val .= "<li>" . __("Error 404", 'constructo') . "</li>";
                }
            }
        }
    }
    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_woocommerce() ) {
    } elseif (single_cat_title("", false) != "" && !is_tag()) {
        $return_val .= "<li>" . single_cat_title("", false)."</li>";
    }
    $return_val .= "</ul>"; 
    return $return_val;
}
/* search container */
function anps_get_search() {
    ?>
    <div class="container">
        <form role="search" method="get" id="searchform-header" class="searchform-header" action="<?php echo home_url(); ?>">
            <input name="s" type="text" placeholder="<?php _e("type and press &#8216;enter&#8217;", 'constructo'); ?>">
        </form>
	<span class="close">&times;</span>
    </div>
<?php
}
/* top bar menu */
function anps_get_top_bar() { 
    if (is_active_sidebar( 'top-bar-left') || is_active_sidebar( 'top-bar-right') ) {
        echo '<div class="container">';
            echo '<ul class="left">';
                    do_shortcode(dynamic_sidebar( 'top-bar-left' ));
            echo '</ul>';
            echo '<ul class="right">';
                    do_shortcode(dynamic_sidebar( 'top-bar-right' ));
            echo '</ul>';
            echo '<div class="clearfix"></div>';
	echo '</div>';
		}
    ?>
    <span class="close fa fa-chevron-down"></span>
    <?php
}

function anps_is_responsive($rtn)  {
    global $anps_options_data;   
    $responsive = "";
    $boxed_backgorund = '';
    $hide_body_class = '';
    if(isset($anps_options_data['preloader']) && $anps_options_data['preloader']=="on") {
        $hide_body_class = ' hide-body';
    }    
    if ( isset($anps_options_data['pattern']) && $anps_options_data['pattern'] && isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == 'on') {
        $boxed_backgorund .= ' pattern-' . $anps_options_data['pattern'];
    }
    if (isset($anps_options_data['responsive'])) $responsive = $anps_options_data['responsive'];
    if ( $responsive != "on" ) {
        if ( $rtn == true ) {
            return " responsive" . $hide_body_class . $boxed_backgorund;
        } else {?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php }
    } else {
        return " responsive-off" . $hide_body_class . $boxed_backgorund;
    }
    
}
function anps_body_style() {
    global $anps_options_data;   
    
    if ( $anps_options_data['pattern'] == '0' ) {
        if(isset($anps_options_data['type']) && $anps_options_data['type'] == "custom color") {
            echo ' style="background-color: ' . esc_attr($anps_options_data['bg_color']) . ';"';
        }else if (isset($anps_options_data['type']) && $anps_options_data['type'] == "stretched") {
            echo ' style="background: url(' . esc_url($anps_options_data['custom_pattern']) . ') center center fixed;background-size: cover;     -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"';
        } else {
            echo ' style="background: url(' . esc_url($anps_options_data['custom_pattern']) . ')"';
        }
    } 
}
function anps_theme_after_styles() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
    
    get_template_part("includes/shortcut_icon");
}
/* Return site logo */
function anps_get_logo() { 
    global $anps_media_data;
    $first_page_logo = get_option('anps_front_logo', '');
    $menu_type = get_option('anps_menu_type');
    $page_heading_full = get_post_meta(get_queried_object_id(), $key ='anps_page_heading_full', $single = true );
    $full_screen_logo = get_post_meta(get_queried_object_id(), $key ='anps_full_screen_logo', $single = true );

    $size_sticky = array(120, 120);
    if( ! $size_sticky ) {
        $size_sticky = array(120, 120);
    }
    $logo_width = 158;
    $logo_height = 33;
    if( $anps_media_data['logo-width'] ) {
        $logo_width = $anps_media_data['logo-width'];
    }
    
    if( $anps_media_data['logo-height'] ) {
        $logo_height = $anps_media_data['logo-height'];
    } 
    if(isset($anps_media_data['auto_adjust_logo']) && $anps_media_data['auto_adjust_logo'] =='on' ) {
        $logo_height = 60;
        $logo_width = "auto";
    } 
    else { $logo_width .='px';
    }
    if(isset($page_heading_full) && $page_heading_full=="on" && isset($full_screen_logo) && $full_screen_logo!="0") : ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($full_screen_logo); ?>"></a>
    <?php else :
    if(($menu_type=='1' || $menu_type=='3') && $first_page_logo && (is_front_page()) && (get_option('vertical-menu', '0') != "on")) : ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($first_page_logo); ?>"></a>
    <?php
    elseif (isset($anps_media_data['logo']) && $anps_media_data['logo'] != "") : ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="<?php echo esc_url($anps_media_data['logo']); ?>"></a>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url("/")); ?>"><img style="width: <?php echo esc_attr($logo_width); ?>; height: <?php echo esc_attr($logo_height); ?>px" alt="Site logo" src="http://anpsthemes.com/constructo/wp-content/uploads/2014/12/constructo-logoV4.png"></a>        
    <?php endif;
    endif;
}
/* Tags and author */
function anps_tagsAndAuthor() {
    ?>
        <div class="tags-author">
    <?php echo __('posted by', 'constructo'); ?> <?php echo get_the_author(); ?>
    <?php
    $posttags = get_the_tags();
    if ($posttags) {
        echo " &nbsp;|&nbsp; ";
        echo __('Taged as', 'constructo') . " - ";
        $first_tag = true;
        foreach ($posttags as $tag) {
            if ( ! $first_tag) {
                echo ', ';
            }
            echo '<a href="' . esc_url(home_url('/')) . 'tag/' . esc_html($tag->slug) . '/">';
            echo esc_html($tag->name);
            echo '</a>';
            $first_tag = false;
        }
    }
    ?>
        </div>
    <?php
}
/* Current page url */
function anps_curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"])) $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") 
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    else 
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    
    return $pageURL;
}
/* Gravatar */
add_filter('avatar_defaults', 'anps_newgravatar');
function anps_newgravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/images/move_default_avatar.jpg';
    $avatar_defaults[$myavatar] = "Anps default avatar";
    return $avatar_defaults;
}
/* Get post thumbnail src */
function anps_get_the_post_thumbnail_src($img) {
    return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}   
function anps_get_menu() {
    $menu_center = get_option('menu_center', '');
    if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
        $menu_center = 'on';
    }

    $menu_description = '';
    $menu_style = get_option('menu_style', '1');
    if( isset($_GET['header']) && $_GET['header'] == 'type-2' ) {
        $menu_style = '2';
    }

    if( $menu_style == '2' ) {
        $menu_description = ' description';
    }
?>
    <nav class="site-navigation<?php echo esc_attr($menu_description); ?>">
    
        <?php //above nav bar 
        $above_nav_bar = get_option('anps_above_nav_bar', '0');
        
        ?>
        <?php global $anps_options_data;?> 
        <?php if( ($above_nav_bar == '1') && (is_active_sidebar( 'above-navigation-bar')) && ($anps_options_data['vertical_menu'] != 'on') ) : ?>
            <div class="above-nav-bar top-bar">
                <div class="col-md-12 no-right-padding">
                    <ul class="right">
                        <?php do_shortcode(dynamic_sidebar( 'above-navigation-bar' ));?>
                    </ul>
                </div>
            </div>        
        <?php endif;?>

        <?php
            $locations = get_theme_mod('nav_menu_locations');

            /* Check if menu is selected */

            $walker = '';
            $menu = '';
            $locations = get_theme_mod('nav_menu_locations');

            if($locations && $locations['primary']) {
                $menu = $locations['primary'];
                if( (isset($_GET['page']) && $_GET['page'] == 'one-page') ) {
                    $menu = 21;
                }
                $walker = new description_walker();
            }

            wp_nav_menu( array(
                'container' => false,
                'menu_class' => '',
                'echo' => true,
                'before' => '',
                'after' => '',
                'link_before' => '',
                'link_after' => '',
                'depth' => 0,
                'walker' => $walker,
                'menu'=>$menu
            ));
        ?>
        <button class="fa fa-search desktop"></button>
    </nav>
    <?php
}
function anps_get_site_header() { 
    $menu_center = get_option('menu_center', '');
    if( isset($_GET['header']) && $_GET['header'] == 'type-3' ) {
        $menu_center = 'on';
    }
    ?>
     <?php
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            
            $shopping_cart_header = get_option('shopping_cart_header','shop_only');
            if (($shopping_cart_header == 'shop_only' &&  is_woocommerce() ) || $shopping_cart_header == 'always' ) {
                anps_woocommerce_header();
            }
        }
    ?>  

    <div class="site-logo retina"><?php anps_get_logo(); ?></div>
    <!-- Search icon next to menu -->
    <button class="fa fa-search mobile"></button>
    <!-- Used for mobile menu -->
    <button class="navbar-toggle" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php anps_get_menu(); ?>

<?php }
add_filter("the_content", "anps_the_content_filter");
function anps_the_content_filter($content) {
    // array of custom shortcodes requiring the fix 
    $block = join("|",array("recent_blog","section","contact", "form_item", "services", "service", "tabs", "tab", "accordion", "accordion_item", "progress", "quote", "statement", "color", "google_maps", "vimeo", "youtube", "contact_info", "contact_info_item","logos", "logo", "button", "error_404", "icon", "icon_group", "content_half", "content_third", "content_two_third", "content_quarter", "content_two_quarter", "content_three_quarter", "twitter", "social_icons", "social_icon", "data_tables", "data_thead", "data_tbody", "data_tfoot", "data_row", "data_th", "data_td", "testimonials", "testimonial"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
    return $rep;
 
}
/* Post gallery */

// Add new image sizes
function anps_insert_custom_image_sizes( $image_sizes ) {
  // get the custom image sizes
  global $_wp_additional_image_sizes;
  // if there are none, just return the built-in sizes
  if ( empty( $_wp_additional_image_sizes ) )
    return $image_sizes;

  // add all the custom sizes to the built-in sizes
  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    // take the size ID (e.g., 'my-name'), replace hyphens with spaces,
    // and capitalise the first letter of each word
    if ( !isset($image_sizes[$id]) )
      $image_sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

  return $image_sizes;
}
add_filter( 'image_size_names_choose', 'anps_insert_custom_image_sizes' );


//depreciated, left for reference
//add_filter( 'post_gallery', 'anps_my_post_gallery', 10, 2 );
function anps_my_post_gallery( $output, $attr) {
    global $post, $wp_locale;
    static $instance = 0;
    $instance++;
    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }
    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));
    
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
    if ( empty($attachments) )
        return '';
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $size = 100/$columns;

    $output = '<div class="gallery recent-posts clearfix">'; 
    foreach ( $attachments as $id => $attachment ) {
        $image_full = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'full', false) : wp_get_attachment_image_src($id, 'full', false);
        $image_full = $image_full[0];

        $image_thumb = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_image_src($id, 'post-thumb', false) : wp_get_attachment_image_src($id, 'post-thumb', false);
        $image_thumb = $image_thumb[0];

        $output .= '
            <article class="post col-md-3" style="width: ' . $size . '%;">
                <header>
                    <a rel="lightbox" class="post-hover" href="' . $image_full . '">
                        <img src="' . $image_thumb . '" alt="blog-8m">
                    </a>
                </header>
            </article>';
    }
    $output .= '</div>'; 
    return $output;
}
//get post_type    
function get_current_post_type() {
    if (is_admin()) {
        global $post, $typenow, $current_screen;
        //we have a post so we can just get the post type from that
        if ($post && $post->post_type)
            return $post->post_type;
        //check the global $typenow - set in admin.php
        elseif ($typenow)
            return $typenow;
        //check the global $current_screen object - set in sceen.php
        elseif ($current_screen && $current_screen->post_type)
            return $current_screen->post_type;
        //lastly check the post_type querystring
        elseif (isset($_REQUEST['post_type']))
            return sanitize_key($_REQUEST['post_type']);
        elseif (isset($_REQUEST['post']))
            return get_post_type($_REQUEST['post']);
        //we do not know the post type!
        return null;
    }
}
/* hide sidebar generator on testimonials and portfolio */
if (get_current_post_type() != 'testimonials' && get_current_post_type() != 'portfolio') {
    //add sidebar generator
    include_once 'sidebar_generator.php';
}
/* Admin/backend styles */
add_action('admin_head', 'backend_styles');
function backend_styles() {
    echo '<style type="text/css">
        .mceListBoxMenu {
            height: auto !important;
        }
        .wp_themeSkin .mceListBoxMenu {
            overflow: visible;
            overflow-x: visible;
        }
    </style>';
}
add_action('admin_head', 'show_hidden_customfields');
function show_hidden_customfields() {
    echo "<input type='hidden' value='" . get_template_directory_uri() . "' id='hidden_url'/>";
}
if (!function_exists('anps_admin_header_style')) :
    /*
     * Styles the header image displayed on the Appearance > Header admin panel.
     * Referenced via add_custom_image_header() in widebox_setup().
     */
    function anps_admin_header_style() {
        ?>
        <style type="text/css">
            /* Shows the same border as on front end */
            #headimg {
                border-bottom: 1px solid #000;
                border-top: 4px solid #000;
            }
        </style>
        <?php
    }
endif;
/* Filter wp title */
add_filter('wp_title', 'anps_filter_wp_title', 10, 2);
function anps_filter_wp_title($title, $separator) {
    // Don't affect wp_title() calls in feeds.
    if (is_feed())
        return $title;
    // The $paged global variable contains the page number of a listing of posts.
    // The $page global variable contains the page number of a single post that is paged.
    // We'll display whichever one applies, if we're not looking at the first page.
    global $paged, $page;
    if (is_search()) {
        // If we're a search, let's start over:
        $title = sprintf(__('Search results for %s', 'constructo'), '"' . get_search_query() . '"');
        // Add a page number if we're on page 2 or more:
        if ($paged >= 2)
            $title .= " $separator " . sprintf(__('Page %s', 'constructo'), $paged);
        // Add the site name to the end:
        $title .= " $separator " . get_bloginfo('name', 'display');
        // We're done. Let's send the new title back to wp_title():
        return $title;
    }
    // Otherwise, let's start by adding the site name to the end:
    $title .= get_bloginfo('name', 'display');
    // If we have a site description and we're on the home/front page, add the description:
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title .= " $separator " . $site_description;
    
    // Add a page number if necessary:
    if ($paged >= 2 || $page >= 2)
        $title .= " $separator " . sprintf(__('Page %s', 'constructo'), max($paged, $page));
    // Return the new title to wp_title():
    return $title;
}
/* Page menu show home */
add_filter('wp_page_menu_args', 'anps_page_menu_args');
function anps_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
/* Sets the post excerpt length to 40 characters. */
add_filter('excerpt_length', 'anps_excerpt_length');
function anps_excerpt_length($length) {
    return 40;
}
/* Returns a "Continue Reading" link for excerpts */
function anps_continue_reading_link() {
    return ' <a href="' . get_permalink() . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', 'constructo') . '</a>';
}
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and widebox_continue_reading_link(). */
add_filter('excerpt_more', 'anps_auto_excerpt_more');
function anps_auto_excerpt_more($more) {
    return ' &hellip;' . anps_continue_reading_link();
}
/* Adds a pretty "Continue Reading" link to custom post excerpts. */
add_filter('get_the_excerpt', 'anps_custom_excerpt_more');
function anps_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= anps_continue_reading_link();
    }
    return $output;
}
/* Remove inline styles printed when the gallery shortcode is used. */
add_filter('gallery_style', 'anps_remove_gallery_css');
function anps_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}
/* Prints HTML with meta information for the current post-date/time and author. */
if (!function_exists('widebox_posted_on')) :    
    function widebox_posted_on() {
        printf(__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'constructo'), 'meta-prep meta-prep-author', sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>', get_permalink(), esc_attr(get_the_time()), get_the_date()
                ), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('View all posts by %s', 'constructo'), get_the_author()), get_the_author()
                )
        );
    }
endif;
/* Prints HTML with meta information for the current post (category, tags and permalink).*/
if (!function_exists('widebox_posted_in')) :   
    function widebox_posted_in() {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'constructo');
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'constructo');
        } else {
            $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'constructo');
        }
        // Prints the string, replacing the placeholders.
        printf($posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0'));
    }
endif;
/* After setup theme */
add_action('after_setup_theme', 'anps_setup');
if (!function_exists('anps_setup')):
    function anps_setup() {
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('constructo', get_template_directory() . '/languages');
        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );
        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Primary Navigation', 'constructo'),
        ));
        // This theme allows users to set a custom background
        //add_custom_background();
        // Your changeable header business starts here
        define('HEADER_TEXTCOLOR', '');
        // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
        define('HEADER_IMAGE', '%s/images/headers/path.jpg');
        // The height and width of your custom header. You can hook into the theme's own filters to change these values.
        // Add a filter to widebox_header_image_width and widebox_header_image_height to change these values.
        define('HEADER_IMAGE_WIDTH', apply_filters('widebox_header_image_width', 190));
        define('HEADER_IMAGE_HEIGHT', apply_filters('widebox_header_image_height', 54));
        // We'll be using post thumbnails for custom header images on posts and pages.
        // We want them to be 940 pixels wide by 198 pixels tall.
        // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
        set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);
        // Don't support text inside the header image.
        define('NO_HEADER_TEXT', true);
        // Add a way for the custom header to be styled in the admin panel that controls
        // custom headers. See widebox_admin_header_style(), below.
        //add_custom_image_header( '', 'widebox_admin_header_style' );
        // ... and thus ends the changeable header business.
        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers(array(
            'berries' => array(
                'url' => '%s/images/headers/logo.png',
                'thumbnail_url' => '%s/images/headers/logo.png',
                /* translators: header image description */
                'description' => __('Move default logo', 'constructo')
            )
        ));
        if (!isset($_GET['stylesheet']))
            $_GET['stylesheet'] = '';
        $theme = wp_get_theme($_GET['stylesheet']);
        if (!isset($_GET['activated']))
            $_GET['activated'] = '';
        if ($_GET['activated'] == 'true' && $theme->get_template() == 'widebox132') {
            
            $arr = array(
                    0=>array('label'=>'e-mail', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'email', 'validation'=>'email'),
                    1=>array('label'=>'subject', 'input_type'=>'text', 'is_required'=>'on', 'placeholder'=>'subject', 'validation'=>'none'),
                    2=>array('label'=>'contact number', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'contact number', 'validation'=>'phone'),
                    3=>array('label'=>'lorem ipsum', 'input_type'=>'text', 'is_required'=>'', 'placeholder'=>'lorem ipsum', 'validation'=>'none'),
                    4=>array('label'=>'message', 'input_type'=>'textarea', 'is_required'=>'on', 'placeholder'=>'message', 'validation'=>'none'),
                );
            update_option('anps_contact', $arr);
        } 
    }
endif;
/* theme options init */
add_action('admin_init', 'anps_theme_options_init');
function anps_theme_options_init() {
    register_setting('sample_options', 'sample_theme_options');
}
/* If user is admin, he will see theme options */
add_action('admin_menu', 'anps_theme_options_add_page');
function anps_theme_options_add_page() {
    global $current_user; 
    if($current_user->user_level==10) {
        add_theme_page('Theme Options', 'Theme Options', 'read', 'theme_options', 'theme_options_do_page');
    }
}
function theme_options_do_page() {
    include_once "admin_view.php";
}
/* Wp_mail */
function anps_MailFunction(){
    include_once get_template_directory().'/anps-framework/classes/Options.php';
    $anps_social_data = $options->get_social();
    $to = $anps_social_data['email'];    //your e-mail to which the message will be sent
    $from = $anps_social_data['email'];        //e-mail address from which the e-mail will be sent
    $subject_contact_us = 'Someone has sent you a message!';   //subject of the e-mail for the form on contact-us.html
    $subject_follow_us = 'I want to follow you';       //subject of the e-mail for the form on follow-us.html
    $message = '';
    $message .= '<table cellpadding="0" cellspacing="0">';
    foreach ($_POST['form_data'] as $postname => $post) {
        if ($postname != 'envoo-admin-mail' && $postname != "recaptcha_challenge_field" && $postname != "recaptcha_response_field") {
            $message .= "<tr><td style='padding: 5px 20px 5px 5px'><strong>" . urldecode($postname) . ":</strong>" . "</td><td style='padding: 5px; color: #444'>" . $post . "</td></tr>";
        }
    } 
    $message .= '</table>';
    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: info@yourdomain.com' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    wp_mail($to, $subject_contact_us, $message, $headers);
}
add_action('wp_ajax_nopriv_MailFunction', 'anps_MailFunction');
add_action( 'wp_ajax_MailFunction', 'anps_MailFunction' ); 
/* Comments */
function anps_comment($comment, $args, $depth) {
    $email = $comment->comment_author_email;
    $user_id = -1;
    if (email_exists($email)) {
        $user_id = email_exists($email);
    }
    $GLOBALS['comment'] = $comment;
    // time difference
    $today = new DateTime(date("Y-m-d H:i:s"));
    $pastDate = $today->diff(new DateTime(get_comment_date("Y-m-d H:i:s")));
    if($pastDate->y>0) {
        if($pastDate->y=="1") {
            $text = __("year ago", 'constructo');
        } else {
            $text = __("years ago", 'constructo');
        }
        $comment_date = $pastDate->y." ".$text;
    } elseif($pastDate->m>0) {
        if($pastDate->m=="1") {
            $text = __("month ago", 'constructo');
        } else {
            $text = __("months ago", 'constructo');
        }
        $comment_date = $pastDate->m." ".$text;
    } elseif($pastDate->d>0) {
        if($pastDate->d=="1") {
            $text = __("day ago", 'constructo');
        } else {
            $text = __("days ago", 'constructo');
        }
        $comment_date = $pastDate->d." ".$text;
    } elseif($pastDate->h>0) {
        if($pastDate->h=="1") {
            $text = __("hour ago", 'constructo');
        } else {
            $text = __("hours ago", 'constructo');
        }
        $comment_date = $pastDate->h." ".$text;
    } elseif($pastDate->i>0) {
        if($pastDate->i=="1") {
            $text = __("minute ago", 'constructo');
        } else {
            $text = __("minutes ago", 'constructo');
        }
        $comment_date = $pastDate->i." ".$text;
    } elseif($pastDate->s>0) {
        if($pastDate->s=="1") {
            $text = __("second ago", 'constructo');
        } else {
            $text = __("seconds ago", 'constructo');
        }
        $comment_date = $pastDate->s." ".$text;
    } 
    ?>  
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <header>
                <h1><?php comment_author(); ?></h1> 
                <span class="date"><?php echo esc_html($comment_date);?></span>
                <?php echo comment_reply_link(array_merge(array('reply_text' => 'Reply'), array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </header>
            <div class="comment-content"><?php comment_text(); ?></div>
        </article>
    </li>
<?php }
add_filter('comment_reply_link', 'replace_reply_link_class');
function replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link btn", $class);
    return $class;
}
/* Remove Excerpt text */
function sbt_auto_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'sbt_auto_excerpt_more', 20 );
function sbt_custom_excerpt_more( $output ) {
    return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'sbt_custom_excerpt_more', 20 );
function anps_getFooterTwitter() {
    $twitter_user = get_option('footer_twitter_acc', 'twitter');
    $settings = array(
        'oauth_access_token' => "1485322933-3Xfq0A59JkWizyboxRBwCMcnrIKWAmXOkqLG5Lm",
        'oauth_access_token_secret' => "aFuG3JCbHLzelXCGNmr4Tr054GY5wB6p1yLd84xdMuI",
        'consumer_key' => "D3xtlRxe9M909v3mrez3g",
        'consumer_secret' => "09FiAL70fZfvHtdOJViKaKVrPEfpGsVCy0zKK2SH8E"
    );
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $twitter_user . '&count=1';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $twitter_json = $twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest();
    $twitter_json = json_decode($twitter_json, true);
    $twitter_user_url = "https://twitter.com/" . $twitter_user;
    $twitter_text = $twitter_json[0]["text"];
    $twitter_tweet_url = "https://twitter.com/" . $twitter_user . "/status/" . $twitter_json[0]["id_str"];
    ?>
    <div class="twitter-footer"><div class="container"><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-icon"></a><a href="<?php echo esc_url($twitter_user_url); ?>" target="_blank" class="tw-heading"><?php _e("twitter feed", 'constructo'); ?></a><a href="<?php echo esc_url($twitter_tweet_url); ?>" target="_blank" class="tw-content"><?php echo $twitter_text; ?></a></div></div>
    <?php
}
function get_excerpt(){
    $excerpt = get_the_content();
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, 100);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    if( $excerpt != "" ) {
        $excerpt = $excerpt.'...';
    }
    return $excerpt;
}
add_filter('widget_tag_cloud_args','set_cloud_tag_size');
function set_cloud_tag_size($args) {
    $args = array('smallest' => 13, 'largest' => 24);
    return $args;
} 
function anps_boxed() {
    global $anps_options_data;
    if (isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == 'on') {
        return ' boxed';
    }
}

function anps_boxed_or_vertical() {
    global $anps_options_data;
    $anps_classes = "";
    if (isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == 'on') {
        $anps_classes .= ' boxed';
    }
    if (isset($anps_options_data['vertical_menu']) && $anps_options_data['vertical_menu'] == 'on') {
        $anps_classes .= ' vertical-menu';
    }
    return $anps_classes;
}

/* Custom font extenstion */

function anps_getExtCustomFonts($font) {
    $dir = get_template_directory().'/fonts'; 
        if ($handle = opendir($dir)) { 
            $arr = array();
            // Get all files and store it to array
            while(false !== ($entry = readdir($handle))) {
                $explode_font=explode('.',$entry);
                if(strtolower($font)==strtolower($explode_font[0]))
                    $arr[] = $entry;
            }          
            closedir($handle); 
            // Remove . and ..
            unset($arr['.'], $arr['..']); 
            return $arr;
        }
}

/* Load custom font (CSS) */

function anps_custom_font($font) {
    $font_family = esc_attr($font);
    $font_src    = get_template_directory_uri() . '/fonts/' . $font_family . '.eot';
    $font_count  = count( anps_getExtCustomFonts($font) );
    $i           = 0;
    $prefix      = 'url("' . get_template_directory_uri() . '/fonts/';
    $font_srcs   = '';

    foreach(anps_getExtCustomFonts($font) as $item) {
        $explode_item = explode('.', $item);

        $name = $explode_item[0];
        $extension = $explode_item[1];
        $separator = ',';

        if( ++$i == $font_count ) {
            $separator = ';';
        }

        switch( $extension ) {
            case 'eot': $font_srcs .= $prefix . $name . '.eot?#iefix") format("embedded-opentype")' . $separator; break;
            case 'woff': $font_srcs .= $prefix . $name . '.woff") format("woff")' . $separator;  break;
            case 'otf': $font_srcs .= $prefix . $name . '.otf") format("opentype")' . $separator;  break;
            case 'ttf': $font_srcs .= $prefix . $name . '.ttf") format("ttf")' . $separator;  break;
            case 'woff2': $font_srcs .= $prefix . $name . '.woff2") format("woff2")' . $separator;  break;
        }                                     
    } /* end foreach */
    ?>
    @font-face {
        font-family: "<?php echo $font_family; ?>";
        src: url("<?php echo $font_src; ?>");
        src: <?php echo $font_srcs; ?>
    }
    <?php 
}

/* Custom styles */

function anps_custom_styles() {
    /* Font Default Values */

    $font_1 = "Montserrat";
    $font_2 = 'PT Sans';
    $font_3 = "Montserrat";

    /* Font 1 */

    if( get_option('font_source_1') == 'System fonts' ||
        get_option('font_source_1') == 'Custom fonts' ||
        get_option('font_source_1') == 'Google fonts' ) {

        $font_1 = urldecode(get_option('font_type_1'));
    } 

    if( get_option('font_source_1') == 'Custom fonts' ) {
        anps_custom_font($font_1);
    }

    /* Font 2 */

    if( get_option('font_source_2') == 'System fonts' ||
        get_option('font_source_2') == 'Custom fonts' ||
        get_option('font_source_2') == 'Google fonts' ) {

        $font_2 = urldecode(get_option('font_type_2'));
    }

    if( get_option('font_source_2') == 'Custom fonts' ) {
        anps_custom_font($font_2);
    }

    /* Font 3 (navigation) */

    if( get_option('font_source_navigation') == 'System fonts' ||
        get_option('font_source_navigation') == 'Custom fonts' ||
        get_option('font_source_navigation') == 'Google fonts' ) {

        $font_3 = urldecode(get_option('font_type_navigation'));
    } 

    if( get_option('font_source_navigation') == 'Custom fonts' ) {
        anps_custom_font($font_3);
    }

    /* Main Theme Colors */

    $text_color = get_option('text_color', '#727272');
    $primary_color = get_option('primary_color', '#292929');
    $hovers_color = get_option('hovers_color', '#d54900');
    $menu_text_color = get_option('menu_text_color', '#000000');
    $headings_color = get_option('headings_color', '#000000');
    $footer_bg_color = get_option('footer_bg_color', '#242424');
    $top_bar_color = get_option('top_bar_color', '#c1c1c1');
    $top_bar_bg_color = get_option('top_bar_bg_color', '#f9f9f9');
    $copyright_footer_bg_color  = get_option('copyright_footer_bg_color', '#0f0f0f');
    $nav_background_color = get_option('nav_background_color', '#fff');
    $footer_text_color = get_option('footer_text_color', '#d9d9d9');
    $submenu_background_color = get_option('submenu_background_color', '#fff');
    $submenu_text_color = get_option('submenu_text_color', '#000');
    $side_submenu_background_color = get_option('side_submenu_background_color', '#fff');
    $side_submenu_text_color = get_option('side_submenu_text_color', '#000');
    $side_submenu_text_hover_color = get_option('side_submenu_text_hover_color', '#d54900');

    /* Home Page Colors*/

    $anps_front_text_color = get_option('anps_front_text_color');
    $anps_front_text_hover_color = get_option('anps_front_text_hover_color');
    $anps_front_bg_color = get_option('anps_front_bg_color');
    $anps_front_topbar_color = get_option('anps_front_topbar_color', '#fff');
    $anps_front_topbar_hover_color = get_option('anps_front_topbar_hover_color', '#d54900');

    /* Font Size */ 

    $body_font_size = get_option('body_font_size', '14');
    $menu_font_size = get_option('menu_font_size', '14');
    $h1_font_size = get_option('h1_font_size', '31');
    $h2_font_size = get_option('h2_font_size', '15');
    $h3_font_size = get_option('h3_font_size', '21');
    $h4_font_size = get_option('h4_font_size', '18');
    $h5_font_size = get_option('h5_font_size', '16');
    $page_heading_h1_font_size = get_option('page_heading_h1_font_size', '24');
    $blog_heading_h1_font_size = get_option('blog_heading_h1_font_size', '28');
?>
body,
ol.list > li > *,
.product_meta span span {
  color: <?php echo esc_attr($text_color); ?>;
}

@media (min-width: 992px) {
.responsive .site-navigation li:hover .sub-menu {
    border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>!important;
 }
}

a,
.btn-link,
.icon.style-2 .fa,
.error-404 h2,
.page-heading,
.statement .style-3,
.dropcaps.style-2:first-letter,
.list li:before,
ol.list,
.post.style-2 header > span,
.post.style-2 header .fa,
.page-numbers span,
.team .socialize a,
blockquote.style-2:before,
.panel-group.style-2 .panel-title a:before,
.contact-info .fa,
blockquote.style-1:before,
.comment-list .comment header h1,
.faq .panel-title a.collapsed:before,
.faq .panel-title a:after,
.faq .panel-title a,
.filter button.selected,
.filter:before,
.primary,
.search-posts i,
.counter .counter-number,
#wp-calendar th,
#wp-calendar caption,
.testimonials blockquote p:before,
.testimonials blockquote p:after,
.price,
.widget-price,
.star-rating,
.widget_shopping_cart .quantity,
.tab-pane .commentlist .meta strong, .woocommerce-tabs .commentlist .meta strong,
.widget_recent_comments .recentcomments a {
  color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote p:before,
.testimonials.white blockquote p:after {
  color: #fff;
}

.site-footer,
.site-footer .copyright-footer,
.site-footer .searchform input[type="text"],
.searchform button[type="submit"] {
  color: <?php echo esc_attr($footer_text_color); ?>;
}

.counter .wrapbox {
  border-color:<?php echo esc_attr($primary_color); ?>;
}

.nav .open > a:focus,
body .tp-bullets.simplebullets.round .bullet.selected {
  border-color: <?php echo esc_attr($primary_color); ?>;
}

@media (max-width: 993px) {
 nav.site-navigation.open{
    background-color: <?php echo esc_attr($footer_bg_color); ?>;
  }
}

@media (min-width: 993px) {
 .site-navigation > div > ul > li .sub-menu .sub-menu,
 .site-navigation > ul > li .sub-menu .sub-menu {
    border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>;
  }
}

.carousel-indicators li.active,
.ls-michell .ls-bottom-slidebuttons a.ls-nav-active {
  border-color: <?php echo esc_attr($primary_color); ?> !important;
}

.icon .fa,
.posts div a,
.progress-bar,
.nav-tabs > li.active:after,
.vc_tta-style-anps_tabs .vc_tta-tabs-list > li.vc_active:after,
.menu li.current-menu-ancestor a,
.pricing-table header,
.table thead th,
.mark,
.post .post-meta button,
blockquote.style-2:after,
.panel-title a:before,
.carousel-indicators li,
.carousel-indicators .active,
.ls-michell .ls-bottom-slidebuttons a,
.site-search,
.twitter .carousel-indicators li,
.twitter .carousel-indicators li.active,
#wp-calendar td a,
.top-bar.style-2,
body .tp-bullets.simplebullets.round .bullet,
.onsale,
.plus, .minus,
.widget_price_filter .ui-slider .ui-slider-range,
.woo-header-cart .cart-contents > span,
.form-submit #submit,
.testimonials blockquote header:before,
div.woocommerce-tabs ul.tabs li.active:before ,
mark {
  background-color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote header:before {
   background-color: #fff;
}

@media (max-width: 992px) {
  .navbar-toggle,
  .nav-wrap .fa-search {
    background-color: <?php echo esc_attr($primary_color); ?>;
  }
}

h1, h2, h3, h4, h5, h6,
.nav-tabs > li > a,
.nav-tabs > li.active > a,
.vc_tta-tabs-list > li > a span,
.statement,
.page-heading a,
.page-heading a:after,
p strong,
.dropcaps:first-letter,
.page-numbers a,
.searchform,
.searchform input[type="text"],
.socialize a,
.widget_rss .rss-date,
.widget_rss cite,
.panel-title,
.panel-group.style-2 .panel-title a.collapsed:before,
blockquote.style-1,
.comment-list .comment header,
.faq .panel-title a:before,
.faq .panel-title a.collapsed,
.filter button,
.carousel .carousel-control,
#wp-calendar #today,
.woocommerce-result-count,
input.qty,
.product_meta,
.woocommerce-review-link,
.woocommerce-before-loop .woocommerce-ordering:after,
.widget_price_filter .price_slider_amount .button,
.widget_price_filter .price_label,
.product_list_widget li h4 a,
.shop_table.table thead th,
.shop_table.table tfoot,
.product-single-header .variations label,
.tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta {
  color: <?php echo esc_attr($headings_color); ?>;
}

.ls-michell .ls-nav-next,
.ls-michell .ls-nav-prev {
color:#fff;
}

@media (min-width: 993px) {
  .site-navigation .sub-menu li,
  .site-navigation > div > ul > li > a,
  .site-navigation > div > ul a
  .site-navigation > ul > li > a,
  .site-navigation > ul a {
    color: <?php echo esc_attr($headings_color); ?>;
  }
}

.contact-form input[type="text"]:focus,
.contact-form textarea:focus {
  border-color: <?php echo esc_attr($headings_color); ?> !important;
}

.pricing-table header h2,
.mark.style-2,
.btn.dark,
.twitter .carousel-indicators li,
.added_to_cart,
.price_slider_wrapper .ui-widget-content {
  background-color: <?php echo esc_attr($headings_color); ?>;
}

@media (max-width: 992px) {
  .site-navigation, .site-navigation:after, .site-navigation:before {
    background-color: <?php echo esc_attr($footer_bg_color); ?>;
  }
}

body,
.alert .close,
.post header,
#lang_sel_list a.lang_sel_sel, #lang_sel_list ul a, #lang_sel_list_list ul a:visited,
.widget_icl_lang_sel_widget #lang_sel ul li ul li a, .widget_icl_lang_sel_widget #lang_sel a {
   font-family: <?php echo esc_attr($font_2);?>;
}

h1, h2, h3, h4, h5, h6,
.btn,
.page-heading,
.team em,
blockquote.style-1,
.onsale,
.added_to_cart,
.price,
.widget-price,
.woocommerce-review-link,
.product_meta,
.tab-pane .commentlist .meta, .woocommerce-tabs .commentlist .meta, 
.wpcf7-submit,
button.single_add_to_cart_button {
  font-family: <?php echo esc_attr($font_1); ?>;
}

.nav-tabs > li > a,
.site-navigation > ul a,
.vc_tta-tabs-list > li > a,
.tp-arr-titleholder {
    font-family: <?php echo esc_attr($font_3);?>;
}

.pricing-table header h2,
.pricing-table header .price,
.pricing-table header .currency,
.table thead,
h1.style-3,
h2.style-3,
h3.style-3,
h4.style-3,
h5.style-3,
h6.style-3,
.page-numbers a,
.page-numbers span,
.alert,
.comment-list .comment header,
.woocommerce-result-count,
.product_list_widget li > a,
.product_list_widget li p.total strong,
.cart_list + .total,
.shop_table.table tfoot,
.product-single-header .variations label {
  font-family: <?php echo esc_attr($font_1);?>;
}

.site-search #searchform-header input[type="text"] {
 font-family: <?php echo esc_attr($font_1);?>;
}

/*Top Bar*/

.top-bar, .top-bar.style-2, header.site-header div.top-bar div.container ul li.widget-container ul li a, .top-bar .close, .top-bar .widget_icl_lang_sel_widget #lang_sel ul li ul li a, .top-bar .widget_icl_lang_sel_widget #lang_sel a {
  color: <?php echo esc_attr($top_bar_color); ?>;
}
header.site-header div.top-bar div.container ul li.widget-container ul li a:hover {
 color:  <?php echo esc_attr($hovers_color); ?>;
} 

.top-bar, .top-bar.style-2, .transparent.top-bar.open > .container, .top-bar .widget_icl_lang_sel_widget #lang_sel ul li ul li a, .top-bar .widget_icl_lang_sel_widget #lang_sel a  {
  background: <?php echo esc_attr($top_bar_bg_color); ?>;
}

/* footer */

.site-footer {
  background: <?php echo esc_attr($footer_bg_color); ?>;
}
.site-footer .copyright-footer {
  background: <?php echo esc_attr($copyright_footer_bg_color); ?>;
}

/*testimonials*/

.testimonials blockquote p {
  border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>;
}
.testimonials.white blockquote p {
  border-bottom: 1px solid #fff;
}

div.testimonials blockquote.item.active p,
.testimonials blockquote cite {
color: <?php echo esc_attr($primary_color); ?>;
}

div.testimonials.white blockquote.item.active p,
div.testimonials.white blockquote.item.active cite a,
div.testimonials.white blockquote.item.active cite, .wpb_content_element .widget .tagcloud a {
    color: #fff;
}

.a:hover,
.site-header a:hover,
.icon a:hover h2,
.nav-tabs > li > a:hover,
.top-bar a:hover,
.page-heading a:hover,
.menu a:hover,
.table tbody tr:hover td,
.page-numbers a:hover,
.widget-categories a:hover,
.product-categories a:hover,
.widget_archive a:hover,
.widget_categories a:hover,
.widget_recent_entries a:hover,
.socialize a:hover,
.faq .panel-title a.collapsed:hover,
.carousel .carousel-control:hover,
a:hover h1, a:hover h2, a:hover h3, a:hover h4, a:hover h5,
.site-footer a:hover,
.ls-michell .ls-nav-next:hover,
.ls-michell .ls-nav-prev:hover,
.site-navigation > ul > li.megamenu .sub-menu .container > li a:hover,
body .tp-leftarrow.default:hover,
body .tp-rightarrow.default:hover,
.product_list_widget li h4 a:hover,
.cart-contents:hover i,
.nav-wrap .fa-search:hover,
.home .nav-wrap .fa-search:hover,
.home .nav-wrap.sticky .fa-search:hover,
.icon.style-2 a:hover .fa,
.team .socialize a:hover,
.recentblog header a:hover h2,
.site-navigation > ul a:hover,
.site-navigation > div > ul > li.current_page_item > a,
.site-navigation > ul > li.current_page_item > a,
.home .site-navigation > ul > li.current-menu-item.current_page_item > a,
.scrollup a:hover,
.site-navigation.open .menu-item a:hover,
.hovercolor, i.hovercolor, .post.style-2 header i.hovercolor.fa,
article.post-sticky header:before,
.wpb_content_element .widget a:hover,
.star-rating,
.responsive .site-navigation .sub-menu a:hover,
.menu .current_page_item > a {
  color: <?php echo esc_attr($hovers_color); ?>;
}

.filter button.selected {
  color: <?php echo esc_attr($hovers_color); ?>!important;
}

.scrollup a:hover {
  border-color: <?php echo esc_attr($hovers_color); ?>;
}

.tagcloud a:hover,
.twitter .carousel-indicators li:hover,
.added_to_cart:hover,
.icon a:hover .fa,
.posts div a:hover,
#wp-calendar td a:hover,
.plus:hover, .minus:hover,
.widget_price_filter .price_slider_amount .button:hover,
.form-submit #submit:hover,
.anps_download > a span.anps_download_icon,
.onsale,
.woo-header-cart .cart-contents > span {
  background-color: <?php echo esc_attr($hovers_color); ?>;
}

body {
  font-size: <?php echo esc_attr($body_font_size); ?>px;
}

h1, .h1 {
  font-size: <?php echo esc_attr($h1_font_size); ?>px;
}
h2, .h2 {
  font-size: <?php echo esc_attr($h2_font_size); ?>px;
}
h3, .h3 {
  font-size: <?php echo esc_attr($h3_font_size); ?>px;
}
h4, .h4 {
  font-size: <?php echo esc_attr($h4_font_size); ?>px;
}
h5, .h5 {
  font-size: <?php echo esc_attr($h5_font_size); ?>px;
}
.page-heading h1 {
  font-size: <?php echo esc_attr($page_heading_h1_font_size); ?>px;
  line-height: 34px;
}

.site-navigation ul > li.menu-item > a {
  color: <?php echo esc_attr($menu_text_color); ?>;
  font-size: <?php echo esc_attr($menu_font_size); ?>px;
}

@media (min-width: 993px) {
    .home .nav-wrap.sticky .fa-search {
      color: <?php echo esc_attr($menu_text_color); ?>;
    }
}

@media (min-width: 993px) {
  .nav-wrap.sticky .site-navigation ul > li.menu-item > a {
    color: <?php echo esc_attr($menu_text_color); ?>;
  }

  .home .site-navigation > ul > li.menu-item > a, .home .nav-wrap .fa-search, body.home.boxed .nav-wrap .fa-search  {
    color: <?php echo esc_attr($anps_front_text_color); ?>;
  }

  .home .site-navigation ul > li.menu-item > a:hover, .home .site-navigation ul > li.current_page_item > a, .home .nav-wrap .fa-search:hover, .home .site-navigation > ul > li.current-menu-item.current_page_item > a {
    color:  <?php echo esc_attr($anps_front_text_hover_color); ?>;
  }
}

.site-navigation ul > li.menu-item > a:hover, .site-navigation ul > li.current_page_item > a, .nav-wrap.sticky .site-navigation ul > li.menu-item > a:hover, .nav-wrap.sticky .site-navigation ul > li.current-menu-item > a {
  color:  <?php echo esc_attr($hovers_color); ?>;
}

.nav-wrap, header.site-header.sticky.style-1.bg-transparent div.nav-wrap.sticky {
 background: <?php echo esc_attr($nav_background_color); ?>;
}

.home .nav-wrap {
  background: <?php echo esc_attr($anps_front_bg_color); ?>;
}

article.post-sticky header .stickymark i.nav_background_color {
  color: <?php echo esc_attr($nav_background_color); ?>;
}

.triangle-topleft.hovercolor {
  border-top: 60px solid <?php echo esc_attr($hovers_color); ?>;
}

h1.single-blog, article.post h1.single-blog {
  font-size: <?php echo esc_attr($blog_heading_h1_font_size); ?>px;
}

.home div.site-wrapper div.transparent.top-bar, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel {
   color: <?php echo esc_attr($anps_front_topbar_color); ?>;
}

.home div.site-wrapper div.transparent.top-bar a:hover, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel:hover {
   color: <?php echo esc_attr($anps_front_topbar_hover_color); ?>;
}

aside.sidebar ul.menu ul.sub-menu > li > a, aside.sidebar ul.menu > li.current-menu-ancestor > a {
  background: <?php echo esc_attr($side_submenu_background_color); ?>;
  color: <?php echo esc_attr($side_submenu_text_color); ?>;
}

aside.sidebar ul.menu ul.sub-menu > li > a:hover, aside.sidebar ul.menu li.current_page_item > a, aside.sidebar ul.menu ul.sub-menu > li.current_page_item > a, aside.sidebar ul.menu > li.current-menu-ancestor > a:hover {
  color: <?php echo esc_attr($side_submenu_text_hover_color); ?>;
}

<?php
  global $anps_options_data;
  if( isset($anps_options_data['hide_slider_on_mobile']) && $anps_options_data['hide_slider_on_mobile'] == 'on' ):
?>

@media (max-width: 786px) {
    .wpb_layerslider_element, .wpb_revslider_element {
        display: none;
    }
}

<?php endif; ?>


@media (max-width: 786px) {
    .home div.site-wrapper div.transparent.top-bar, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel {
      color: <?php echo esc_attr($top_bar_color); ?>;
    }
}

<?php

//set header dimensions
if( isset($anps_media_data['logo-height'])):

    if ( isset($anps_media_data['auto_adjust_logo']) &&  $anps_media_data['auto_adjust_logo']=='on' ) {
        $nav_top_heading = '0';
    } else {
        $nav_top_heading = ceil((($anps_media_data['logo-height']) - '72' + '23') / '2');
    }
?>

@media (min-width: 993px) {
.site-navigation {
  padding-top:0;
  padding-top: <?php echo $nav_top_heading; ?>px;
}

.nav-wrap .fa-search {
  padding-top:0;
}

.nav-wrap.sticky .site-navigation  {
  padding-top:0;
}

.nav-wrap.style-3 .site-navigation, .nav-wrap.style-3 .fa-search  {
 padding-top: 0;
}

}
@media (max-width: 992px) {
.home .nav-wrap .fa-search, .home .nav-wrap .fa-search:hover, body.home.boxed .nav-wrap .fa-search, .site-navigation ul > li.menu-item > a, .home .nav-wrap.sticky .fa-search {
  color: #fff
}
}


<?php endif;?>

<?php
//display search icon in menu?
$search_icon = get_option('search_icon', '1');
if (!$search_icon == '1') : ?>

.site-navigation .fa-search, .fa-search.desktop, body.vertical-menu header.site-header.vertical-menu .fa-search.desktop  {
display:none;
}

.responsive .site-navigation > ul > li:last-child:after {
    border-right: none!important;
}
  
<?php endif; ?>

<?php $search_icon_mobile = get_option('search_icon_mobile', '1');
if (!$search_icon_mobile == '1') : ?>
.nav-wrap > .container > button.fa-search.mobile {
  display:none!important;
}
<?php endif; ?>
@media (min-width: 993px) {
  .responsive .site-navigation .sub-menu {
    background:<?php echo esc_attr($submenu_background_color); ?>;
  }
    .responsive .site-navigation .sub-menu a {
    color: <?php echo esc_attr($submenu_text_color); ?>;
  }
}

<?php
if ( isset($anps_media_data['auto_adjust_logo']) && $anps_media_data['auto_adjust_logo'] =='on' ) :?>
@media (max-width: 400px) {
    .nav-wrap .site-logo a img {
        height: 60px!important;
        width: auto;
        max-width: 175px;
    }
}
<?php endif; ?>

<?php 
echo get_option("anps_custom_css", "");
}

/* Custom styles for buttons */

function anps_custom_styles_buttons() {
   /*buttons*/
    $default_button_bg = get_option('default_button_bg', '#292929');
    $default_button_color = get_option('default_button_color', '#fff');
    $default_button_hover_bg = get_option('default_button_hover_bg', '#d54900');
    $default_button_hover_color = get_option('default_button_hover_color', '#fff');

    $style_1_button_bg = get_option('style_1_button_bg', '#292929');
    $style_1_button_color = get_option('style_1_button_color', '#fff');
    $style_1_button_hover_bg = get_option('style_1_button_hover_bg', '#d54900');
    $style_1_button_hover_color = get_option('style_1_button_hover_color', '#fff');


    $style_slider_button_bg = get_option('style_slider_button_bg', '#292929');
    $style_slider_button_color = get_option('style_slider_button_color', '#fff');
    $style_slider_button_hover_bg = get_option('style_slider_button_hover_bg', '#d54900');
    $style_slider_button_hover_color = get_option('style_slider_button_hover_color', '#fff');

    $style_2_button_bg = get_option('style_2_button_bg', '#292929');
    $style_2_button_color = get_option('style_2_button_color', '#fff');
    $style_2_button_hover_bg = get_option('style_2_button_hover_bg', '#d54900');
    $style_2_button_hover_color = get_option('style_2_button_hover_color', '#fff');

    $style_3_button_color = get_option('style_3_button_color', '#000');
    $style_3_button_hover_bg = get_option('style_3_button_hover_bg', '#fafafa');
    $style_3_button_hover_color = get_option('style_3_button_hover_color', '#000');
    $style_3_button_border_color = get_option('style_3_button_border_color', '#000');

    $style_4_button_color = get_option('style_4_button_color', '#000');
    $style_4_button_hover_color = get_option('style_4_button_hover_color', '#d54900');

    $style_style_5_button_bg = get_option('style_style_5_button_bg', '#c3c3c3');
    $style_style_5_button_color = get_option('style_style_5_button_color', '#fff');
    $style_style_5_button_hover_bg = get_option('style_style_5_button_hover_bg', '#737373');
    $style_style_5_button_hover_color = get_option('style_style_5_button_hover_color', '#fff'); ?>

    /*buttons*/

    .btn, .wpcf7-submit, button.single_add_to_cart_button {
        -moz-user-select: none;
        background-image: none;
        border: 0;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-weight: normal;
        line-height: 1.5;
        margin-bottom: 0;
        text-align: center;
        text-transform: uppercase;
        text-decoration:none;
        transition: background-color 0.2s ease 0s;
        vertical-align: middle;
        white-space: nowrap;
    }

    .btn.btn-sm, .wpcf7-submit {
        padding: 11px 17px;
        font-size: 14px;
    }

    .btn, .wpcf7-submit, button.single_add_to_cart_button {
      border-radius: 0;
      border-radius: 4px;
      background-color: <?php echo esc_attr($default_button_bg); ?>;
      color: <?php echo esc_attr($default_button_color); ?>;
    }
    .btn:hover, .btn:active, .btn:focus, .wpcf7-submit:hover, .wpcf7-submit:active, .wpcf7-submit:focus, button.single_add_to_cart_button:hover, button.single_add_to_cart_button:active, button.single_add_to_cart_button:focus {
      background-color: <?php echo esc_attr($default_button_hover_bg); ?>;
      color: <?php echo esc_attr($default_button_hover_color); ?>;
      border:0;
    }

    .btn.style-1, .vc_btn.style-1   { 
      border-radius: 4px;
      background-color: <?php echo esc_attr($style_1_button_bg); ?>;
      color: <?php echo esc_attr($style_1_button_color); ?>!important;
    }
    .btn.style-1:hover, .btn.style-1:active, .btn.style-1:focus, .vc_btn.style-1:hover, .vc_btn.style-1:active, .vc_btn.style-1:focus  {
      background-color: <?php echo esc_attr($style_1_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_1_button_hover_color); ?>!important;
    }

    .btn.slider  { 
      border-radius: 4px;
      background-color: <?php echo esc_attr($style_slider_button_bg); ?>;
      color: <?php echo esc_attr($style_slider_button_color); ?>;
    }
    .btn.slider:hover, .btn.slider:active, .btn.slider:focus  {
      background-color: <?php echo esc_attr($style_slider_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_slider_button_hover_color); ?>;
    }

    .btn.style-2, .vc_btn.style-2  {
      border-radius: 4px;
      border: 2px solid <?php echo esc_attr($style_2_button_bg); ?>;
      background-color: <?php echo esc_attr($style_2_button_bg); ?>;
      color: <?php echo esc_attr($style_2_button_color); ?>!important;
    }

    .btn.style-2:hover, .btn.style-2:active, .btn.style-2:focus, .vc_btn.style-2:hover, .vc_btn.style-2:active, .vc_btn.style-2:focus   {
      background-color: <?php echo esc_attr($style_2_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_2_button_hover_color); ?>!important;
      border-color: <?php echo esc_attr($style_2_button_bg); ?>;
      border: 2px solid <?php echo esc_attr($style_2_button_bg); ?>;
    }

    .btn.style-3, .vc_btn.style-3  {
      border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;;
      border-radius: 4px;
      background-color: transparent;
      color: <?php echo esc_attr($style_3_button_color); ?>!important;
    }
    .btn.style-3:hover, .btn.style-3:active, .btn.style-3:focus, .vc_btn.style-3:hover, .vc_btn.style-3:active, .vc_btn.style-3:focus  {
      border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;
      background-color: <?php echo esc_attr($style_3_button_hover_bg); ?>;
      color: <?php echo esc_attr($style_3_button_hover_color); ?>!important;
    }

    .btn.style-4, .vc_btn.style-4   {
      padding-left: 0;
      background-color: transparent;
      color: <?php echo esc_attr($style_4_button_color); ?>!important;
      border: none;
    }

    .btn.style-4:hover, .btn.style-4:active, .btn.style-4:focus, .vc_btn.style-4:hover, .vc_btn.style-4:active, .vc_btn.style-4:focus   {
      padding-left: 0;
      background: none;
      color: <?php echo esc_attr($style_4_button_hover_color); ?>!important;
      border: none;
      border-color: transparent;
      outline: none;
    }

    .btn.style-5, .vc_btn.style-5   {
      background-color: <?php echo esc_attr($style_style_5_button_bg); ?>!important;
      color: <?php echo esc_attr($style_style_5_button_color); ?>!important;
      border: none;
    }

    .btn.style-5:hover, .btn.style-5:active, .btn.style-5:focus, .vc_btn.style-5:hover, .vc_btn.style-5:active, .vc_btn.style-5:focus   {
      background-color: <?php echo esc_attr($style_style_5_button_hover_bg); ?>!important;
      color: <?php echo esc_attr($style_style_5_button_hover_color); ?>!important;
    } 
    <?php
}