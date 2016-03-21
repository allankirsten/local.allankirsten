<?php

class AnpsDownload extends WP_Widget {

    public function __construct() {    
        parent::__construct(
            'AnpsDownload', 'AnpsThemes - Download', array('description' => __('Choose a image to show on page', 'constructo'),)
        );
        add_action( 'admin_enqueue_scripts', array( $this, 'anps_enqueue_scripts' ) );
        add_action( 'admin_footer-widgets.php', array( $this, 'anps_print_scripts' ), 9999 );
    }
    
    function anps_enqueue_scripts( $hook_suffix ) {
        wp_enqueue_style('wp-color-picker');        
        wp_enqueue_script('wp-color-picker');
    }
    
    function anps_print_scripts() {
            ?>
            <script>
                    ( function( $ ){
                            function initColorPicker( widget ) {
                                    widget.find( '.anps-color-picker' ).wpColorPicker( {
                                            change: _.throttle( function() { // For Customizer
                                                    $(this).trigger( 'change' );
                                            }, 3000 )
                                    });
                            }

                            function onFormUpdate( event, widget ) {
                                    initColorPicker( widget );
                            }

                            $( document ).on( 'widget-added widget-updated', onFormUpdate );

                            $( document ).ready( function() {
                                    $( '#widgets-right .widget:has(.anps-color-picker)' ).each( function () {
                                            initColorPicker( $( this ) );
                                    } );
                            } );
                    }( jQuery ) );
            </script>
            <?php
    }

    function form($instance) {       
        $instance = wp_parse_args((array) $instance, array('title' => '', 'file' => '', 'file_title' => '', 'icon'=>'', 'icon_color'=>'', 'bg_color'=>'', 'file_external'=>''));

        $file = $instance['file'];
        $file_external = $instance['file_external'];
        $title = $instance['title'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        $icon_color = $instance['icon_color'];
        $bg_color = $instance['bg_color'];
        ?>
        <!-- Widget title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title", 'constructo'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <!-- File title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_title')); ?>"><?php _e("File title", 'constructo'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_title')); ?>" name="<?php echo esc_attr($this->get_field_name('file_title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_title']); ?>" />
        </p>
        <!-- File -->
        <p>
            <?php $files = get_children('post_type=attachment'); ?>
            <label for="<?php echo esc_attr($this->get_field_id('file')); ?>"><?php _e("File", 'constructo'); ?></label><br />
            <select id="<?php echo esc_attr($this->get_field_id('file')); ?>" name="<?php echo esc_attr($this->get_field_name('file')); ?>">
                <option value=""><?php _e("Select a file", 'constructo'); ?></option>
                <?php foreach ($files as $item) : ?>
                    <option <?php if ($item->guid == $file) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item->guid); ?>"><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
            </select>        
        </p>
        <!-- Icon -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php _e("Icon", 'constructo'); ?></label><br />
            <select class="anps_select2 addsel fontawesome" id="<?php echo esc_attr($this->get_field_id('icon')); ?>" name="<?php echo esc_attr($this->get_field_name('icon')); ?>" style="font-family: FontAwesome;">
                <option value=""><?php _e("Select an icon", 'constructo'); ?></option>         
                <?php foreach ($this->font_awesome() as $value=>$item) : ?>
                    <option <?php if ($item == $icon) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item); ?>"><?php echo $value; ?></option>
            <?php endforeach; ?>
            </select>
                <script>
                        jQuery(function($){     
                            jQuery('.widget-liquid-right .anps_select2.addsel').select2({
                                    containerCssClass: 'anps_select2',
                                    dropdownCssClass: 'anps_select2'
                                });
                            jQuery('.widget-liquid-right .anps_select2.addsel').removeClass('addsel');
                        })
                </script> 
        </p>
        <!-- Icon color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon_color')); ?>"><?php _e("Icon color", 'constructo'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('icon_color'); ?>" name="<?php echo $this->get_field_name('icon_color'); ?>" type="text" value="<?php echo esc_attr($instance['icon_color']); ?>" />
        </p>
        <!-- Background color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('bg_color')); ?>"><?php _e("Background color", 'constructo'); ?></label><br />
            <input class="anps-color-picker" id="<?php echo $this->get_field_id('bg_color'); ?>" name="<?php echo $this->get_field_name('bg_color'); ?>" type="text" value="<?php echo esc_attr($instance['bg_color']); ?>" />
        </p>
        <!-- File external -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_external')); ?>"><?php _e("File external", 'constructo'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_external')); ?>" name="<?php echo esc_attr($this->get_field_name('file_external')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_external']); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['file'] = $new_instance['file'];
        $instance['file_external'] = $new_instance['file_external'];
        $instance['title'] = $new_instance['title'];
        $instance['file_title'] = $new_instance['file_title'];
        $instance['icon'] = $new_instance['icon'];
        $instance['icon_color'] = $new_instance['icon_color'];
        $instance['bg_color'] = $new_instance['bg_color'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        $file = $instance['file'];
        $file_external = $instance['file_external'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        $icon_color = $instance['icon_color'];
        $bg_color = $instance['bg_color'];
        if($file) {
            $file_url = $file;
        } elseif($file_external) {
            $file_url = $file_external;
        } else {
            $file_url = "#";
        }
        echo $before_widget;
        ?>

        <?php if($title) : ?>
            <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
            <div class="anps_download">
                <a href="<?php echo esc_url($file_url); ?>" target="_blank">
                    <span class="anps_download_icon" style="background-color: <?php echo esc_attr($bg_color); ?>"><i class="fa fa-<?php echo esc_attr($icon); ?>" style="color: <?php echo esc_attr($icon_color); ?>"></i></span>
                    <span class="download-title"><?php echo esc_html($file_title); ?></span>
                    <div class="clearfix"></div>
                </a>
            </div>
        <?php
        echo $after_widget;
    }
    
    function font_awesome() {
        $icon_array = array(
                html_entity_decode("&#xf042; ") . __("adjust", 'constructo')=>"adjust",
                html_entity_decode("&#xf170; ") . __("adn", 'constructo')=>"adn",
                html_entity_decode("&#xf037; ") . __("align-center", 'constructo')=>"align-center",
                html_entity_decode("&#xf039; ") . __("align-justify", 'constructo')=>"align-justify",
                html_entity_decode("&#xf036; ") . __("align-left", 'constructo')=>"align-left",
                html_entity_decode("&#xf038; ") . __("align-right", 'constructo')=>"align-right",
                html_entity_decode("&#xf0f9; ") . __("ambulance", 'constructo')=>"ambulance",
                html_entity_decode("&#xf13d; ") . __("anchor", 'constructo')=>"anchor",
                html_entity_decode("&#xf17b; ") . __("android", 'constructo')=>"android",
                html_entity_decode("&#xf209; ") . __("angellist", 'constructo')=>"angellist",
                html_entity_decode("&#xf103; ") . __("angle-double-down", 'constructo')=>"angle-double-down",
                html_entity_decode("&#xf100; ") . __("angle-double-left", 'constructo')=>"angle-double-left",
                html_entity_decode("&#xf101; ") . __("angle-double-right", 'constructo')=>"angle-double-right",
                html_entity_decode("&#xf102; ") . __("angle-double-up", 'constructo')=>"angle-double-up",
                html_entity_decode("&#xf107; ") . __("angle-down", 'constructo')=>"angle-down",
                html_entity_decode("&#xf104; ") . __("angle-left", 'constructo')=>"angle-left",
                html_entity_decode("&#xf105; ") . __("angle-right", 'constructo')=>"angle-right",
                html_entity_decode("&#xf106; ") . __("angle-up", 'constructo')=>"angle-up",
                html_entity_decode("&#xf179; ") . __("apple", 'constructo')=>"apple",
                html_entity_decode("&#xf187; ") . __("archive", 'constructo')=>"archive",
                html_entity_decode("&#xf1fe; ") . __("area-chart", 'constructo')=>"area-chart",
                html_entity_decode("&#xf0ab; ") . __("arrow-circle-down", 'constructo')=>"arrow-circle-down",
                html_entity_decode("&#xf0a8; ") . __("arrow-circle-left", 'constructo')=>"arrow-circle-left",
                html_entity_decode("&#xf01a; ") . __("arrow-circle-o-down", 'constructo')=>"arrow-circle-o-down",
                html_entity_decode("&#xf190; ") . __("arrow-circle-o-left", 'constructo')=>"arrow-circle-o-left",
                html_entity_decode("&#xf18e; ") . __("arrow-circle-o-right", 'constructo')=>"arrow-circle-o-right",
                html_entity_decode("&#xf01b; ") . __("arrow-circle-o-up", 'constructo')=>"arrow-circle-o-up",
                html_entity_decode("&#xf0a9; ") . __("arrow-circle-right", 'constructo')=>"arrow-circle-right",
                html_entity_decode("&#xf0aa; ") . __("arrow-circle-up", 'constructo')=>"arrow-circle-up",
                html_entity_decode("&#xf063; ") . __("arrow-down", 'constructo')=>"arrow-down",
                html_entity_decode("&#xf060; ") . __("arrow-left", 'constructo')=>"arrow-left",
                html_entity_decode("&#xf061; ") . __("arrow-right", 'constructo')=>"arrow-right",
                html_entity_decode("&#xf062; ") . __("arrow-up", 'constructo')=>"arrow-up",
                html_entity_decode("&#xf047; ") . __("arrows", 'constructo')=>"arrows",
                html_entity_decode("&#xf0b2; ") . __("arrows-alt", 'constructo')=>"arrows-alt",
                html_entity_decode("&#xf07e; ") . __("arrows-h", 'constructo')=>"arrows-h",
                html_entity_decode("&#xf07d; ") . __("arrows-v", 'constructo')=>"arrows-v",
                html_entity_decode("&#xf069; ") . __("asterisk", 'constructo')=>"asterisk",
                html_entity_decode("&#xf1fa; ") . __("at", 'constructo')=>"at",
                html_entity_decode("&#xf1b9; ") . __("automobile (alias)", 'constructo')=>"automobile (alias)",
                html_entity_decode("&#xf04a; ") . __("backward", 'constructo')=>"backward",
                html_entity_decode("&#xf05e; ") . __("ban", 'constructo')=>"ban",
                html_entity_decode("&#xf19c; ") . __("bank (alias)", 'constructo')=>"bank (alias)",
                html_entity_decode("&#xf080; ") . __("bar-chart", 'constructo')=>"bar-chart",
                html_entity_decode("&#xf080; ") . __("bar-chart-o (alias)", 'constructo')=>"bar-chart-o (alias)",
                html_entity_decode("&#xf02a; ") . __("barcode", 'constructo')=>"barcode",
                html_entity_decode("&#xf0c9; ") . __("bars", 'constructo')=>"bars",
                html_entity_decode("&#xf236; ") . __("bed", 'constructo')=>"bed",
                html_entity_decode("&#xf0fc; ") . __("beer", 'constructo')=>"beer",
                html_entity_decode("&#xf1b4; ") . __("behance", 'constructo')=>"behance",
                html_entity_decode("&#xf1b5; ") . __("behance-square", 'constructo')=>"behance-square",
                html_entity_decode("&#xf0f3; ") . __("bell", 'constructo')=>"bell",
                html_entity_decode("&#xf0a2; ") . __("bell-o", 'constructo')=>"bell-o",
                html_entity_decode("&#xf1f6; ") . __("bell-slash", 'constructo')=>"bell-slash",
                html_entity_decode("&#xf1f7; ") . __("bell-slash-o", 'constructo')=>"bell-slash-o",
                html_entity_decode("&#xf206; ") . __("bicycle", 'constructo')=>"bicycle",
                html_entity_decode("&#xf1e5; ") . __("binoculars", 'constructo')=>"binoculars",
                html_entity_decode("&#xf1fd; ") . __("birthday-cake", 'constructo')=>"birthday-cake",
                html_entity_decode("&#xf171; ") . __("bitbucket", 'constructo')=>"bitbucket",
                html_entity_decode("&#xf172; ") . __("bitbucket-square", 'constructo')=>"bitbucket-square",
                html_entity_decode("&#xf15a; ") . __("bitcoin (alias)", 'constructo')=>"bitcoin (alias)",
                html_entity_decode("&#xf032; ") . __("bold", 'constructo')=>"bold",
                html_entity_decode("&#xf0e7; ") . __("bolt", 'constructo')=>"bolt",
                html_entity_decode("&#xf1e2; ") . __("bomb", 'constructo')=>"bomb",
                html_entity_decode("&#xf02d; ") . __("book", 'constructo')=>"book",
                html_entity_decode("&#xf02e; ") . __("bookmark", 'constructo')=>"bookmark",
                html_entity_decode("&#xf097; ") . __("bookmark-o", 'constructo')=>"bookmark-o",
                html_entity_decode("&#xf0b1; ") . __("briefcase", 'constructo')=>"briefcase",
                html_entity_decode("&#xf15a; ") . __("btc", 'constructo')=>"btc",
                html_entity_decode("&#xf188; ") . __("bug", 'constructo')=>"bug",
                html_entity_decode("&#xf1ad; ") . __("building", 'constructo')=>"building",
                html_entity_decode("&#xf0f7; ") . __("building-o", 'constructo')=>"building-o",
                html_entity_decode("&#xf0a1; ") . __("bullhorn", 'constructo')=>"bullhorn",
                html_entity_decode("&#xf140; ") . __("bullseye", 'constructo')=>"bullseye",
                html_entity_decode("&#xf207; ") . __("bus", 'constructo')=>"bus",
                html_entity_decode("&#xf20d; ") . __("buysellads", 'constructo')=>"buysellads",
                html_entity_decode("&#xf1ba; ") . __("cab (alias)", 'constructo')=>"cab (alias)",
                html_entity_decode("&#xf1ec; ") . __("calculator", 'constructo')=>"calculator",
                html_entity_decode("&#xf073; ") . __("calendar", 'constructo')=>"calendar",
                html_entity_decode("&#xf133; ") . __("calendar-o", 'constructo')=>"calendar-o",
                html_entity_decode("&#xf030; ") . __("camera", 'constructo')=>"camera",
                html_entity_decode("&#xf083; ") . __("camera-retro", 'constructo')=>"camera-retro",
                html_entity_decode("&#xf1b9; ") . __("car", 'constructo')=>"car",
                html_entity_decode("&#xf0d7; ") . __("caret-down", 'constructo')=>"caret-down",
                html_entity_decode("&#xf0d9; ") . __("caret-left", 'constructo')=>"caret-left",
                html_entity_decode("&#xf0da; ") . __("caret-right", 'constructo')=>"caret-right",
                html_entity_decode("&#xf150; ") . __("caret-square-o-down", 'constructo')=>"caret-square-o-down",
                html_entity_decode("&#xf191; ") . __("caret-square-o-left", 'constructo')=>"caret-square-o-left",
                html_entity_decode("&#xf152; ") . __("caret-square-o-right", 'constructo')=>"caret-square-o-right",
                html_entity_decode("&#xf151; ") . __("caret-square-o-up", 'constructo')=>"caret-square-o-up",
                html_entity_decode("&#xf0d8; ") . __("caret-up", 'constructo')=>"caret-up",
                html_entity_decode("&#xf218; ") . __("cart-arrow-down", 'constructo')=>"cart-arrow-down",
                html_entity_decode("&#xf217; ") . __("cart-plus", 'constructo')=>"cart-plus",
                html_entity_decode("&#xf20a; ") . __("cc", 'constructo')=>"cc",
                html_entity_decode("&#xf1f3; ") . __("cc-amex", 'constructo')=>"cc-amex",
                html_entity_decode("&#xf1f2; ") . __("cc-discover", 'constructo')=>"cc-discover",
                html_entity_decode("&#xf1f1; ") . __("cc-mastercard", 'constructo')=>"cc-mastercard",
                html_entity_decode("&#xf1f4; ") . __("cc-paypal", 'constructo')=>"cc-paypal",
                html_entity_decode("&#xf1f5; ") . __("cc-stripe", 'constructo')=>"cc-stripe",
                html_entity_decode("&#xf1f0; ") . __("cc-visa", 'constructo')=>"cc-visa",
                html_entity_decode("&#xf0a3; ") . __("certificate", 'constructo')=>"certificate",
                html_entity_decode("&#xf0c1; ") . __("chain (alias)", 'constructo')=>"chain (alias)",
                html_entity_decode("&#xf127; ") . __("chain-broken", 'constructo')=>"chain-broken",
                html_entity_decode("&#xf00c; ") . __("check", 'constructo')=>"check",
                html_entity_decode("&#xf058; ") . __("check-circle", 'constructo')=>"check-circle",
                html_entity_decode("&#xf05d; ") . __("check-circle-o", 'constructo')=>"check-circle-o",
                html_entity_decode("&#xf14a; ") . __("check-square", 'constructo')=>"check-square",
                html_entity_decode("&#xf046; ") . __("check-square-o", 'constructo')=>"check-square-o",
                html_entity_decode("&#xf13a; ") . __("chevron-circle-down", 'constructo')=>"chevron-circle-down",
                html_entity_decode("&#xf137; ") . __("chevron-circle-left", 'constructo')=>"chevron-circle-left",
                html_entity_decode("&#xf138; ") . __("chevron-circle-right", 'constructo')=>"chevron-circle-right",
                html_entity_decode("&#xf139; ") . __("chevron-circle-up", 'constructo')=>"chevron-circle-up",
                html_entity_decode("&#xf078; ") . __("chevron-down", 'constructo')=>"chevron-down",
                html_entity_decode("&#xf053; ") . __("chevron-left", 'constructo')=>"chevron-left",
                html_entity_decode("&#xf054; ") . __("chevron-right", 'constructo')=>"chevron-right",
                html_entity_decode("&#xf077; ") . __("chevron-up", 'constructo')=>"chevron-up",
                html_entity_decode("&#xf1ae; ") . __("child", 'constructo')=>"child",
                html_entity_decode("&#xf111; ") . __("circle", 'constructo')=>"circle",
                html_entity_decode("&#xf10c; ") . __("circle-o", 'constructo')=>"circle-o",
                html_entity_decode("&#xf1ce; ") . __("circle-o-notch", 'constructo')=>"circle-o-notch",
                html_entity_decode("&#xf1db; ") . __("circle-thin", 'constructo')=>"circle-thin",
                html_entity_decode("&#xf0ea; ") . __("clipboard", 'constructo')=>"clipboard",
                html_entity_decode("&#xf017; ") . __("clock-o", 'constructo')=>"clock-o",
                html_entity_decode("&#xf00d; ") . __("close (alias)", 'constructo')=>"close (alias)",
                html_entity_decode("&#xf0c2; ") . __("cloud", 'constructo')=>"cloud",
                html_entity_decode("&#xf0ed; ") . __("cloud-download", 'constructo')=>"cloud-download",
                html_entity_decode("&#xf0ee; ") . __("cloud-upload", 'constructo')=>"cloud-upload",
                html_entity_decode("&#xf157; ") . __("cny (alias)", 'constructo')=>"cny (alias)",
                html_entity_decode("&#xf121; ") . __("code", 'constructo')=>"code",
                html_entity_decode("&#xf126; ") . __("code-fork", 'constructo')=>"code-fork",
                html_entity_decode("&#xf1cb; ") . __("codepen", 'constructo')=>"codepen",
                html_entity_decode("&#xf0f4; ") . __("coffee", 'constructo')=>"coffee",
                html_entity_decode("&#xf013; ") . __("cog", 'constructo')=>"cog",
                html_entity_decode("&#xf085; ") . __("cogs", 'constructo')=>"cogs",
                html_entity_decode("&#xf0db; ") . __("columns", 'constructo')=>"columns",
                html_entity_decode("&#xf075; ") . __("comment", 'constructo')=>"comment",
                html_entity_decode("&#xf0e5; ") . __("comment-o", 'constructo')=>"comment-o",
                html_entity_decode("&#xf086; ") . __("comments", 'constructo')=>"comments",
                html_entity_decode("&#xf0e6; ") . __("comments-o", 'constructo')=>"comments-o",
                html_entity_decode("&#xf14e; ") . __("compass", 'constructo')=>"compass",
                html_entity_decode("&#xf066; ") . __("compress", 'constructo')=>"compress",
                html_entity_decode("&#xf20e; ") . __("connectdevelop", 'constructo')=>"connectdevelop",
                html_entity_decode("&#xf0c5; ") . __("copy (alias)", 'constructo')=>"copy (alias)",
                html_entity_decode("&#xf1f9; ") . __("copyright", 'constructo')=>"copyright",
                html_entity_decode("&#xf09d; ") . __("credit-card", 'constructo')=>"credit-card",
                html_entity_decode("&#xf125; ") . __("crop", 'constructo')=>"crop",
                html_entity_decode("&#xf05b; ") . __("crosshairs", 'constructo')=>"crosshairs",
                html_entity_decode("&#xf13c; ") . __("css3", 'constructo')=>"css3",
                html_entity_decode("&#xf1b2; ") . __("cube", 'constructo')=>"cube",
                html_entity_decode("&#xf1b3; ") . __("cubes", 'constructo')=>"cubes",
                html_entity_decode("&#xf0c4; ") . __("cut (alias)", 'constructo')=>"cut (alias)",
                html_entity_decode("&#xf0f5; ") . __("cutlery", 'constructo')=>"cutlery",
                html_entity_decode("&#xf0e4; ") . __("dashboard (alias)", 'constructo')=>"dashboard (alias)",
                html_entity_decode("&#xf210; ") . __("dashcube", 'constructo')=>"dashcube",
                html_entity_decode("&#xf1c0; ") . __("database", 'constructo')=>"database",
                html_entity_decode("&#xf03b; ") . __("dedent (alias)", 'constructo')=>"dedent (alias)",
                html_entity_decode("&#xf1a5; ") . __("delicious", 'constructo')=>"delicious",
                html_entity_decode("&#xf108; ") . __("desktop", 'constructo')=>"desktop",
                html_entity_decode("&#xf1bd; ") . __("deviantart", 'constructo')=>"deviantart",
                html_entity_decode("&#xf219; ") . __("diamond", 'constructo')=>"diamond",
                html_entity_decode("&#xf1a6; ") . __("digg", 'constructo')=>"digg",
                html_entity_decode("&#xf155; ") . __("dollar (alias)", 'constructo')=>"dollar (alias)",
                html_entity_decode("&#xf192; ") . __("dot-circle-o", 'constructo')=>"dot-circle-o",
                html_entity_decode("&#xf019; ") . __("download", 'constructo')=>"download",
                html_entity_decode("&#xf17d; ") . __("dribbble", 'constructo')=>"dribbble",
                html_entity_decode("&#xf16b; ") . __("dropbox", 'constructo')=>"dropbox",
                html_entity_decode("&#xf1a9; ") . __("drupal", 'constructo')=>"drupal",
                html_entity_decode("&#xf044; ") . __("edit (alias)", 'constructo')=>"edit (alias)",
                html_entity_decode("&#xf052; ") . __("eject", 'constructo')=>"eject",
                html_entity_decode("&#xf141; ") . __("ellipsis-h", 'constructo')=>"ellipsis-h",
                html_entity_decode("&#xf142; ") . __("ellipsis-v", 'constructo')=>"ellipsis-v",
                html_entity_decode("&#xf1d1; ") . __("empire", 'constructo')=>"empire",
                html_entity_decode("&#xf0e0; ") . __("envelope", 'constructo')=>"envelope",
                html_entity_decode("&#xf003; ") . __("envelope-o", 'constructo')=>"envelope-o",
                html_entity_decode("&#xf199; ") . __("envelope-square", 'constructo')=>"envelope-square",
                html_entity_decode("&#xf12d; ") . __("eraser", 'constructo')=>"eraser",
                html_entity_decode("&#xf153; ") . __("eur", 'constructo')=>"eur",
                html_entity_decode("&#xf153; ") . __("euro (alias)", 'constructo')=>"euro (alias)",
                html_entity_decode("&#xf0ec; ") . __("exchange", 'constructo')=>"exchange",
                html_entity_decode("&#xf12a; ") . __("exclamation", 'constructo')=>"exclamation",
                html_entity_decode("&#xf06a; ") . __("exclamation-circle", 'constructo')=>"exclamation-circle",
                html_entity_decode("&#xf071; ") . __("exclamation-triangle", 'constructo')=>"exclamation-triangle",
                html_entity_decode("&#xf065; ") . __("expand", 'constructo')=>"expand",
                html_entity_decode("&#xf08e; ") . __("external-link", 'constructo')=>"external-link",
                html_entity_decode("&#xf14c; ") . __("external-link-square", 'constructo')=>"external-link-square",
                html_entity_decode("&#xf06e; ") . __("eye", 'constructo')=>"eye",
                html_entity_decode("&#xf070; ") . __("eye-slash", 'constructo')=>"eye-slash",
                html_entity_decode("&#xf1fb; ") . __("eyedropper", 'constructo')=>"eyedropper",
                html_entity_decode("&#xf09a; ") . __("facebook", 'constructo')=>"facebook",
                html_entity_decode("&#xf09a; ") . __("facebook-f (alias)", 'constructo')=>"facebook-f (alias)",
                html_entity_decode("&#xf230; ") . __("facebook-official", 'constructo')=>"facebook-official",
                html_entity_decode("&#xf082; ") . __("facebook-square", 'constructo')=>"facebook-square",
                html_entity_decode("&#xf049; ") . __("fast-backward", 'constructo')=>"fast-backward",
                html_entity_decode("&#xf050; ") . __("fast-forward", 'constructo')=>"fast-forward",
                html_entity_decode("&#xf1ac; ") . __("fax", 'constructo')=>"fax",
                html_entity_decode("&#xf182; ") . __("female", 'constructo')=>"female",
                html_entity_decode("&#xf0fb; ") . __("fighter-jet", 'constructo')=>"fighter-jet",
                html_entity_decode("&#xf15b; ") . __("file", 'constructo')=>"file",
                html_entity_decode("&#xf1c6; ") . __("file-archive-o", 'constructo')=>"file-archive-o",
                html_entity_decode("&#xf1c7; ") . __("file-audio-o", 'constructo')=>"file-audio-o",
                html_entity_decode("&#xf1c9; ") . __("file-code-o", 'constructo')=>"file-code-o",
                html_entity_decode("&#xf1c3; ") . __("file-excel-o", 'constructo')=>"file-excel-o",
                html_entity_decode("&#xf1c5; ") . __("file-image-o", 'constructo')=>"file-image-o",
                html_entity_decode("&#xf1c8; ") . __("file-movie-o (alias)", 'constructo')=>"file-movie-o (alias)",
                html_entity_decode("&#xf016; ") . __("file-o", 'constructo')=>"file-o",
                html_entity_decode("&#xf1c1; ") . __("file-pdf-o", 'constructo')=>"file-pdf-o",
                html_entity_decode("&#xf1c5; ") . __("file-photo-o (alias)", 'constructo')=>"file-photo-o (alias)",
                html_entity_decode("&#xf1c5; ") . __("file-picture-o (alias)", 'constructo')=>"file-picture-o (alias)",
                html_entity_decode("&#xf1c4; ") . __("file-powerpoint-o", 'constructo')=>"file-powerpoint-o",
                html_entity_decode("&#xf1c7; ") . __("file-sound-o (alias)", 'constructo')=>"file-sound-o (alias)",
                html_entity_decode("&#xf15c; ") . __("file-text", 'constructo')=>"file-text",
                html_entity_decode("&#xf0f6; ") . __("file-text-o", 'constructo')=>"file-text-o",
                html_entity_decode("&#xf1c8; ") . __("file-video-o", 'constructo')=>"file-video-o",
                html_entity_decode("&#xf1c2; ") . __("file-word-o", 'constructo')=>"file-word-o",
                html_entity_decode("&#xf1c6; ") . __("file-zip-o (alias)", 'constructo')=>"file-zip-o (alias)",
                html_entity_decode("&#xf0c5; ") . __("files-o", 'constructo')=>"files-o",
                html_entity_decode("&#xf008; ") . __("film", 'constructo')=>"film",
                html_entity_decode("&#xf0b0; ") . __("filter", 'constructo')=>"filter",
                html_entity_decode("&#xf06d; ") . __("fire", 'constructo')=>"fire",
                html_entity_decode("&#xf134; ") . __("fire-extinguisher", 'constructo')=>"fire-extinguisher",
                html_entity_decode("&#xf024; ") . __("flag", 'constructo')=>"flag",
                html_entity_decode("&#xf11e; ") . __("flag-checkered", 'constructo')=>"flag-checkered",
                html_entity_decode("&#xf11d; ") . __("flag-o", 'constructo')=>"flag-o",
                html_entity_decode("&#xf0e7; ") . __("flash (alias)", 'constructo')=>"flash (alias)",
                html_entity_decode("&#xf0c3; ") . __("flask", 'constructo')=>"flask",
                html_entity_decode("&#xf16e; ") . __("flickr", 'constructo')=>"flickr",
                html_entity_decode("&#xf0c7; ") . __("floppy-o", 'constructo')=>"floppy-o",
                html_entity_decode("&#xf07b; ") . __("folder", 'constructo')=>"folder",
                html_entity_decode("&#xf114; ") . __("folder-o", 'constructo')=>"folder-o",
                html_entity_decode("&#xf07c; ") . __("folder-open", 'constructo')=>"folder-open",
                html_entity_decode("&#xf115; ") . __("folder-open-o", 'constructo')=>"folder-open-o",
                html_entity_decode("&#xf031; ") . __("font", 'constructo')=>"font",
                html_entity_decode("&#xf211; ") . __("forumbee", 'constructo')=>"forumbee",
                html_entity_decode("&#xf04e; ") . __("forward", 'constructo')=>"forward",
                html_entity_decode("&#xf180; ") . __("foursquare", 'constructo')=>"foursquare",
                html_entity_decode("&#xf119; ") . __("frown-o", 'constructo')=>"frown-o",
                html_entity_decode("&#xf1e3; ") . __("futbol-o", 'constructo')=>"futbol-o",
                html_entity_decode("&#xf11b; ") . __("gamepad", 'constructo')=>"gamepad",
                html_entity_decode("&#xf0e3; ") . __("gavel", 'constructo')=>"gavel",
                html_entity_decode("&#xf154; ") . __("gbp", 'constructo')=>"gbp",
                html_entity_decode("&#xf1d1; ") . __("ge (alias)", 'constructo')=>"ge (alias)",
                html_entity_decode("&#xf013; ") . __("gear (alias)", 'constructo')=>"gear (alias)",
                html_entity_decode("&#xf085; ") . __("gears (alias)", 'constructo')=>"gears (alias)",
                html_entity_decode("&#xf1db; ") . __("genderless (alias)", 'constructo')=>"genderless (alias)",
                html_entity_decode("&#xf06b; ") . __("gift", 'constructo')=>"gift",
                html_entity_decode("&#xf1d3; ") . __("git", 'constructo')=>"git",
                html_entity_decode("&#xf1d2; ") . __("git-square", 'constructo')=>"git-square",
                html_entity_decode("&#xf09b; ") . __("github", 'constructo')=>"github",
                html_entity_decode("&#xf113; ") . __("github-alt", 'constructo')=>"github-alt",
                html_entity_decode("&#xf092; ") . __("github-square", 'constructo')=>"github-square",
                html_entity_decode("&#xf184; ") . __("gittip (alias)", 'constructo')=>"gittip (alias)",
                html_entity_decode("&#xf000; ") . __("glass", 'constructo')=>"glass",
                html_entity_decode("&#xf0ac; ") . __("globe", 'constructo')=>"globe",
                html_entity_decode("&#xf1a0; ") . __("google", 'constructo')=>"google",
                html_entity_decode("&#xf0d5; ") . __("google-plus", 'constructo')=>"google-plus",
                html_entity_decode("&#xf0d4; ") . __("google-plus-square", 'constructo')=>"google-plus-square",
                html_entity_decode("&#xf1ee; ") . __("google-wallet", 'constructo')=>"google-wallet",
                html_entity_decode("&#xf19d; ") . __("graduation-cap", 'constructo')=>"graduation-cap",
                html_entity_decode("&#xf184; ") . __("gratipay", 'constructo')=>"gratipay",
                html_entity_decode("&#xf0c0; ") . __("group (alias)", 'constructo')=>"group (alias)",
                html_entity_decode("&#xf0fd; ") . __("h-square", 'constructo')=>"h-square",
                html_entity_decode("&#xf1d4; ") . __("hacker-news", 'constructo')=>"hacker-news",
                html_entity_decode("&#xf0a7; ") . __("hand-o-down", 'constructo')=>"hand-o-down",
                html_entity_decode("&#xf0a5; ") . __("hand-o-left", 'constructo')=>"hand-o-left",
                html_entity_decode("&#xf0a4; ") . __("hand-o-right", 'constructo')=>"hand-o-right",
                html_entity_decode("&#xf0a6; ") . __("hand-o-up", 'constructo')=>"hand-o-up",
                html_entity_decode("&#xf0a0; ") . __("hdd-o", 'constructo')=>"hdd-o",
                html_entity_decode("&#xf1dc; ") . __("header", 'constructo')=>"header",
                html_entity_decode("&#xf025; ") . __("headphones", 'constructo')=>"headphones",
                html_entity_decode("&#xf004; ") . __("heart", 'constructo')=>"heart",
                html_entity_decode("&#xf08a; ") . __("heart-o", 'constructo')=>"heart-o",
                html_entity_decode("&#xf21e; ") . __("heartbeat", 'constructo')=>"heartbeat",
                html_entity_decode("&#xf1da; ") . __("history", 'constructo')=>"history",
                html_entity_decode("&#xf015; ") . __("home", 'constructo')=>"home",
                html_entity_decode("&#xf0f8; ") . __("hospital-o", 'constructo')=>"hospital-o",
                html_entity_decode("&#xf236; ") . __("hotel (alias)", 'constructo')=>"hotel (alias)",
                html_entity_decode("&#xf13b; ") . __("html5", 'constructo')=>"html5",
                html_entity_decode("&#xf20b; ") . __("ils", 'constructo')=>"ils",
                html_entity_decode("&#xf03e; ") . __("image (alias)", 'constructo')=>"image (alias)",
                html_entity_decode("&#xf01c; ") . __("inbox", 'constructo')=>"inbox",
                html_entity_decode("&#xf03c; ") . __("indent", 'constructo')=>"indent",
                html_entity_decode("&#xf129; ") . __("info", 'constructo')=>"info",
                html_entity_decode("&#xf05a; ") . __("info-circle", 'constructo')=>"info-circle",
                html_entity_decode("&#xf156; ") . __("inr", 'constructo')=>"inr",
                html_entity_decode("&#xf16d; ") . __("instagram", 'constructo')=>"instagram",
                html_entity_decode("&#xf19c; ") . __("institution (alias)", 'constructo')=>"institution (alias)",
                html_entity_decode("&#xf208; ") . __("ioxhost", 'constructo')=>"ioxhost",
                html_entity_decode("&#xf033; ") . __("italic", 'constructo')=>"italic",
                html_entity_decode("&#xf1aa; ") . __("joomla", 'constructo')=>"joomla",
                html_entity_decode("&#xf157; ") . __("jpy", 'constructo')=>"jpy",
                html_entity_decode("&#xf1cc; ") . __("jsfiddle", 'constructo')=>"jsfiddle",
                html_entity_decode("&#xf084; ") . __("key", 'constructo')=>"key",
                html_entity_decode("&#xf11c; ") . __("keyboard-o", 'constructo')=>"keyboard-o",
                html_entity_decode("&#xf159; ") . __("krw", 'constructo')=>"krw",
                html_entity_decode("&#xf1ab; ") . __("language", 'constructo')=>"language",
                html_entity_decode("&#xf109; ") . __("laptop", 'constructo')=>"laptop",
                html_entity_decode("&#xf202; ") . __("lastfm", 'constructo')=>"lastfm",
                html_entity_decode("&#xf203; ") . __("lastfm-square", 'constructo')=>"lastfm-square",
                html_entity_decode("&#xf06c; ") . __("leaf", 'constructo')=>"leaf",
                html_entity_decode("&#xf212; ") . __("leanpub", 'constructo')=>"leanpub",
                html_entity_decode("&#xf0e3; ") . __("legal (alias)", 'constructo')=>"legal (alias)",
                html_entity_decode("&#xf094; ") . __("lemon-o", 'constructo')=>"lemon-o",
                html_entity_decode("&#xf149; ") . __("level-down", 'constructo')=>"level-down",
                html_entity_decode("&#xf148; ") . __("level-up", 'constructo')=>"level-up",
                html_entity_decode("&#xf1cd; ") . __("life-bouy (alias)", 'constructo')=>"life-bouy (alias)",
                html_entity_decode("&#xf1cd; ") . __("life-buoy (alias)", 'constructo')=>"life-buoy (alias)",
                html_entity_decode("&#xf1cd; ") . __("life-ring", 'constructo')=>"life-ring",
                html_entity_decode("&#xf1cd; ") . __("life-saver (alias)", 'constructo')=>"life-saver (alias)",
                html_entity_decode("&#xf0eb; ") . __("lightbulb-o", 'constructo')=>"lightbulb-o",
                html_entity_decode("&#xf201; ") . __("line-chart", 'constructo')=>"line-chart",
                html_entity_decode("&#xf0c1; ") . __("link", 'constructo')=>"link",
                html_entity_decode("&#xf0e1; ") . __("linkedin", 'constructo')=>"linkedin",
                html_entity_decode("&#xf08c; ") . __("linkedin-square", 'constructo')=>"linkedin-square",
                html_entity_decode("&#xf17c; ") . __("linux", 'constructo')=>"linux",
                html_entity_decode("&#xf03a; ") . __("list", 'constructo')=>"list",
                html_entity_decode("&#xf022; ") . __("list-alt", 'constructo')=>"list-alt",
                html_entity_decode("&#xf0cb; ") . __("list-ol", 'constructo')=>"list-ol",
                html_entity_decode("&#xf0ca; ") . __("list-ul", 'constructo')=>"list-ul",
                html_entity_decode("&#xf124; ") . __("location-arrow", 'constructo')=>"location-arrow",
                html_entity_decode("&#xf023; ") . __("lock", 'constructo')=>"lock",
                html_entity_decode("&#xf175; ") . __("long-arrow-down", 'constructo')=>"long-arrow-down",
                html_entity_decode("&#xf177; ") . __("long-arrow-left", 'constructo')=>"long-arrow-left",
                html_entity_decode("&#xf178; ") . __("long-arrow-right", 'constructo')=>"long-arrow-right",
                html_entity_decode("&#xf176; ") . __("long-arrow-up", 'constructo')=>"long-arrow-up",
                html_entity_decode("&#xf0d0; ") . __("magic", 'constructo')=>"magic",
                html_entity_decode("&#xf076; ") . __("magnet", 'constructo')=>"magnet",
                html_entity_decode("&#xf064; ") . __("mail-forward (alias)", 'constructo')=>"mail-forward (alias)",
                html_entity_decode("&#xf112; ") . __("mail-reply (alias)", 'constructo')=>"mail-reply (alias)",
                html_entity_decode("&#xf122; ") . __("mail-reply-all (alias)", 'constructo')=>"mail-reply-all (alias)",
                html_entity_decode("&#xf183; ") . __("male", 'constructo')=>"male",
                html_entity_decode("&#xf041; ") . __("map-marker", 'constructo')=>"map-marker",
                html_entity_decode("&#xf222; ") . __("mars", 'constructo')=>"mars",
                html_entity_decode("&#xf227; ") . __("mars-double", 'constructo')=>"mars-double",
                html_entity_decode("&#xf229; ") . __("mars-stroke", 'constructo')=>"mars-stroke",
                html_entity_decode("&#xf22b; ") . __("mars-stroke-h", 'constructo')=>"mars-stroke-h",
                html_entity_decode("&#xf22a; ") . __("mars-stroke-v", 'constructo')=>"mars-stroke-v",
                html_entity_decode("&#xf136; ") . __("maxcdn", 'constructo')=>"maxcdn",
                html_entity_decode("&#xf20c; ") . __("meanpath", 'constructo')=>"meanpath",
                html_entity_decode("&#xf23a; ") . __("medium", 'constructo')=>"medium",
                html_entity_decode("&#xf0fa; ") . __("medkit", 'constructo')=>"medkit",
                html_entity_decode("&#xf11a; ") . __("meh-o", 'constructo')=>"meh-o",
                html_entity_decode("&#xf223; ") . __("mercury", 'constructo')=>"mercury",
                html_entity_decode("&#xf130; ") . __("microphone", 'constructo')=>"microphone",
                html_entity_decode("&#xf131; ") . __("microphone-slash", 'constructo')=>"microphone-slash",
                html_entity_decode("&#xf068; ") . __("minus", 'constructo')=>"minus",
                html_entity_decode("&#xf056; ") . __("minus-circle", 'constructo')=>"minus-circle",
                html_entity_decode("&#xf146; ") . __("minus-square", 'constructo')=>"minus-square",
                html_entity_decode("&#xf147; ") . __("minus-square-o", 'constructo')=>"minus-square-o",
                html_entity_decode("&#xf10b; ") . __("mobile", 'constructo')=>"mobile",
                html_entity_decode("&#xf10b; ") . __("mobile-phone (alias)", 'constructo')=>"mobile-phone (alias)",
                html_entity_decode("&#xf0d6; ") . __("money", 'constructo')=>"money",
                html_entity_decode("&#xf186; ") . __("moon-o", 'constructo')=>"moon-o",
                html_entity_decode("&#xf19d; ") . __("mortar-board (alias)", 'constructo')=>"mortar-board (alias)",
                html_entity_decode("&#xf21c; ") . __("motorcycle", 'constructo')=>"motorcycle",
                html_entity_decode("&#xf001; ") . __("music", 'constructo')=>"music",
                html_entity_decode("&#xf0c9; ") . __("navicon (alias)", 'constructo')=>"navicon (alias)",
                html_entity_decode("&#xf22c; ") . __("neuter", 'constructo')=>"neuter",
                html_entity_decode("&#xf1ea; ") . __("newspaper-o", 'constructo')=>"newspaper-o",
                html_entity_decode("&#xf19b; ") . __("openid", 'constructo')=>"openid",
                html_entity_decode("&#xf03b; ") . __("outdent", 'constructo')=>"outdent",
                html_entity_decode("&#xf18c; ") . __("pagelines", 'constructo')=>"pagelines",
                html_entity_decode("&#xf1fc; ") . __("paint-brush", 'constructo')=>"paint-brush",
                html_entity_decode("&#xf1d8; ") . __("paper-plane", 'constructo')=>"paper-plane",
                html_entity_decode("&#xf1d9; ") . __("paper-plane-o", 'constructo')=>"paper-plane-o",
                html_entity_decode("&#xf0c6; ") . __("paperclip", 'constructo')=>"paperclip",
                html_entity_decode("&#xf1dd; ") . __("paragraph", 'constructo')=>"paragraph",
                html_entity_decode("&#xf0ea; ") . __("paste (alias)", 'constructo')=>"paste (alias)",
                html_entity_decode("&#xf04c; ") . __("pause", 'constructo')=>"pause",
                html_entity_decode("&#xf1b0; ") . __("paw", 'constructo')=>"paw",
                html_entity_decode("&#xf1ed; ") . __("paypal", 'constructo')=>"paypal",
                html_entity_decode("&#xf040; ") . __("pencil", 'constructo')=>"pencil",
                html_entity_decode("&#xf14b; ") . __("pencil-square", 'constructo')=>"pencil-square",
                html_entity_decode("&#xf044; ") . __("pencil-square-o", 'constructo')=>"pencil-square-o",
                html_entity_decode("&#xf095; ") . __("phone", 'constructo')=>"phone",
                html_entity_decode("&#xf098; ") . __("phone-square", 'constructo')=>"phone-square",
                html_entity_decode("&#xf03e; ") . __("photo (alias)", 'constructo')=>"photo (alias)",
                html_entity_decode("&#xf03e; ") . __("picture-o", 'constructo')=>"picture-o",
                html_entity_decode("&#xf200; ") . __("pie-chart", 'constructo')=>"pie-chart",
                html_entity_decode("&#xf1a7; ") . __("pied-piper", 'constructo')=>"pied-piper",
                html_entity_decode("&#xf1a8; ") . __("pied-piper-alt", 'constructo')=>"pied-piper-alt",
                html_entity_decode("&#xf0d2; ") . __("pinterest", 'constructo')=>"pinterest",
                html_entity_decode("&#xf231; ") . __("pinterest-p", 'constructo')=>"pinterest-p",
                html_entity_decode("&#xf0d3; ") . __("pinterest-square", 'constructo')=>"pinterest-square",
                html_entity_decode("&#xf072; ") . __("plane", 'constructo')=>"plane",
                html_entity_decode("&#xf04b; ") . __("play", 'constructo')=>"play",
                html_entity_decode("&#xf144; ") . __("play-circle", 'constructo')=>"play-circle",
                html_entity_decode("&#xf01d; ") . __("play-circle-o", 'constructo')=>"play-circle-o",
                html_entity_decode("&#xf1e6; ") . __("plug", 'constructo')=>"plug",
                html_entity_decode("&#xf067; ") . __("plus", 'constructo')=>"plus",
                html_entity_decode("&#xf055; ") . __("plus-circle", 'constructo')=>"plus-circle",
                html_entity_decode("&#xf0fe; ") . __("plus-square", 'constructo')=>"plus-square",
                html_entity_decode("&#xf196; ") . __("plus-square-o", 'constructo')=>"plus-square-o",
                html_entity_decode("&#xf011; ") . __("power-off", 'constructo')=>"power-off",
                html_entity_decode("&#xf02f; ") . __("print", 'constructo')=>"print",
                html_entity_decode("&#xf12e; ") . __("puzzle-piece", 'constructo')=>"puzzle-piece",
                html_entity_decode("&#xf1d6; ") . __("qq", 'constructo')=>"qq",
                html_entity_decode("&#xf029; ") . __("qrcode", 'constructo')=>"qrcode",
                html_entity_decode("&#xf128; ") . __("question", 'constructo')=>"question",
                html_entity_decode("&#xf059; ") . __("question-circle", 'constructo')=>"question-circle",
                html_entity_decode("&#xf10d; ") . __("quote-left", 'constructo')=>"quote-left",
                html_entity_decode("&#xf10e; ") . __("quote-right", 'constructo')=>"quote-right",
                html_entity_decode("&#xf1d0; ") . __("ra (alias)", 'constructo')=>"ra (alias)",
                html_entity_decode("&#xf074; ") . __("random", 'constructo')=>"random",
                html_entity_decode("&#xf1d0; ") . __("rebel", 'constructo')=>"rebel",
                html_entity_decode("&#xf1b8; ") . __("recycle", 'constructo')=>"recycle",
                html_entity_decode("&#xf1a1; ") . __("reddit", 'constructo')=>"reddit",
                html_entity_decode("&#xf1a2; ") . __("reddit-square", 'constructo')=>"reddit-square",
                html_entity_decode("&#xf021; ") . __("refresh", 'constructo')=>"refresh",
                html_entity_decode("&#xf00d; ") . __("remove (alias)", 'constructo')=>"remove (alias)",
                html_entity_decode("&#xf18b; ") . __("renren", 'constructo')=>"renren",
                html_entity_decode("&#xf0c9; ") . __("reorder (alias)", 'constructo')=>"reorder (alias)",
                html_entity_decode("&#xf01e; ") . __("repeat", 'constructo')=>"repeat",
                html_entity_decode("&#xf112; ") . __("reply", 'constructo')=>"reply",
                html_entity_decode("&#xf122; ") . __("reply-all", 'constructo')=>"reply-all",
                html_entity_decode("&#xf079; ") . __("retweet", 'constructo')=>"retweet",
                html_entity_decode("&#xf157; ") . __("rmb (alias)", 'constructo')=>"rmb (alias)",
                html_entity_decode("&#xf018; ") . __("road", 'constructo')=>"road",
                html_entity_decode("&#xf135; ") . __("rocket", 'constructo')=>"rocket",
                html_entity_decode("&#xf0e2; ") . __("rotate-left (alias)", 'constructo')=>"rotate-left (alias)",
                html_entity_decode("&#xf01e; ") . __("rotate-right (alias)", 'constructo')=>"rotate-right (alias)",
                html_entity_decode("&#xf158; ") . __("rouble (alias)", 'constructo')=>"rouble (alias)",
                html_entity_decode("&#xf09e; ") . __("rss", 'constructo')=>"rss",
                html_entity_decode("&#xf143; ") . __("rss-square", 'constructo')=>"rss-square",
                html_entity_decode("&#xf158; ") . __("rub", 'constructo')=>"rub",
                html_entity_decode("&#xf158; ") . __("ruble (alias)", 'constructo')=>"ruble (alias)",
                html_entity_decode("&#xf156; ") . __("rupee (alias)", 'constructo')=>"rupee (alias)",
                html_entity_decode("&#xf0c7; ") . __("save (alias)", 'constructo')=>"save (alias)",
                html_entity_decode("&#xf0c4; ") . __("scissors", 'constructo')=>"scissors",
                html_entity_decode("&#xf002; ") . __("search", 'constructo')=>"search",
                html_entity_decode("&#xf010; ") . __("search-minus", 'constructo')=>"search-minus",
                html_entity_decode("&#xf00e; ") . __("search-plus", 'constructo')=>"search-plus",
                html_entity_decode("&#xf213; ") . __("sellsy", 'constructo')=>"sellsy",
                html_entity_decode("&#xf1d8; ") . __("send (alias)", 'constructo')=>"send (alias)",
                html_entity_decode("&#xf1d9; ") . __("send-o (alias)", 'constructo')=>"send-o (alias)",
                html_entity_decode("&#xf233; ") . __("server", 'constructo')=>"server",
                html_entity_decode("&#xf064; ") . __("share", 'constructo')=>"share",
                html_entity_decode("&#xf1e0; ") . __("share-alt", 'constructo')=>"share-alt",
                html_entity_decode("&#xf1e1; ") . __("share-alt-square", 'constructo')=>"share-alt-square",
                html_entity_decode("&#xf14d; ") . __("share-square", 'constructo')=>"share-square",
                html_entity_decode("&#xf045; ") . __("share-square-o", 'constructo')=>"share-square-o",
                html_entity_decode("&#xf20b; ") . __("shekel (alias)", 'constructo')=>"shekel (alias)",
                html_entity_decode("&#xf20b; ") . __("sheqel (alias)", 'constructo')=>"sheqel (alias)",
                html_entity_decode("&#xf132; ") . __("shield", 'constructo')=>"shield",
                html_entity_decode("&#xf21a; ") . __("ship", 'constructo')=>"ship",
                html_entity_decode("&#xf214; ") . __("shirtsinbulk", 'constructo')=>"shirtsinbulk",
                html_entity_decode("&#xf07a; ") . __("shopping-cart", 'constructo')=>"shopping-cart",
                html_entity_decode("&#xf090; ") . __("sign-in", 'constructo')=>"sign-in",
                html_entity_decode("&#xf08b; ") . __("sign-out", 'constructo')=>"sign-out",
                html_entity_decode("&#xf012; ") . __("signal", 'constructo')=>"signal",
                html_entity_decode("&#xf215; ") . __("simplybuilt", 'constructo')=>"simplybuilt",
                html_entity_decode("&#xf0e8; ") . __("sitemap", 'constructo')=>"sitemap",
                html_entity_decode("&#xf216; ") . __("skyatlas", 'constructo')=>"skyatlas",
                html_entity_decode("&#xf17e; ") . __("skype", 'constructo')=>"skype",
                html_entity_decode("&#xf198; ") . __("slack", 'constructo')=>"slack",
                html_entity_decode("&#xf1de; ") . __("sliders", 'constructo')=>"sliders",
                html_entity_decode("&#xf1e7; ") . __("slideshare", 'constructo')=>"slideshare",
                html_entity_decode("&#xf118; ") . __("smile-o", 'constructo')=>"smile-o",
                html_entity_decode("&#xf1e3; ") . __("soccer-ball-o (alias)", 'constructo')=>"soccer-ball-o (alias)",
                html_entity_decode("&#xf0dc; ") . __("sort", 'constructo')=>"sort",
                html_entity_decode("&#xf15d; ") . __("sort-alpha-asc", 'constructo')=>"sort-alpha-asc",
                html_entity_decode("&#xf15e; ") . __("sort-alpha-desc", 'constructo')=>"sort-alpha-desc",
                html_entity_decode("&#xf160; ") . __("sort-amount-asc", 'constructo')=>"sort-amount-asc",
                html_entity_decode("&#xf161; ") . __("sort-amount-desc", 'constructo')=>"sort-amount-desc",
                html_entity_decode("&#xf0de; ") . __("sort-asc", 'constructo')=>"sort-asc",
                html_entity_decode("&#xf0dd; ") . __("sort-desc", 'constructo')=>"sort-desc",
                html_entity_decode("&#xf0dd; ") . __("sort-down (alias)", 'constructo')=>"sort-down (alias)",
                html_entity_decode("&#xf162; ") . __("sort-numeric-asc", 'constructo')=>"sort-numeric-asc",
                html_entity_decode("&#xf163; ") . __("sort-numeric-desc", 'constructo')=>"sort-numeric-desc",
                html_entity_decode("&#xf0de; ") . __("sort-up (alias)", 'constructo')=>"sort-up (alias)",
                html_entity_decode("&#xf1be; ") . __("soundcloud", 'constructo')=>"soundcloud",
                html_entity_decode("&#xf197; ") . __("space-shuttle", 'constructo')=>"space-shuttle",
                html_entity_decode("&#xf110; ") . __("spinner", 'constructo')=>"spinner",
                html_entity_decode("&#xf1b1; ") . __("spoon", 'constructo')=>"spoon",
                html_entity_decode("&#xf1bc; ") . __("spotify", 'constructo')=>"spotify",
                html_entity_decode("&#xf0c8; ") . __("square", 'constructo')=>"square",
                html_entity_decode("&#xf096; ") . __("square-o", 'constructo')=>"square-o",
                html_entity_decode("&#xf18d; ") . __("stack-exchange", 'constructo')=>"stack-exchange",
                html_entity_decode("&#xf16c; ") . __("stack-overflow", 'constructo')=>"stack-overflow",
                html_entity_decode("&#xf005; ") . __("star", 'constructo')=>"star",
                html_entity_decode("&#xf089; ") . __("star-half", 'constructo')=>"star-half",
                html_entity_decode("&#xf123; ") . __("star-half-empty (alias)", 'constructo')=>"star-half-empty (alias)",
                html_entity_decode("&#xf123; ") . __("star-half-full (alias)", 'constructo')=>"star-half-full (alias)",
                html_entity_decode("&#xf123; ") . __("star-half-o", 'constructo')=>"star-half-o",
                html_entity_decode("&#xf006; ") . __("star-o", 'constructo')=>"star-o",
                html_entity_decode("&#xf1b6; ") . __("steam", 'constructo')=>"steam",
                html_entity_decode("&#xf1b7; ") . __("steam-square", 'constructo')=>"steam-square",
                html_entity_decode("&#xf048; ") . __("step-backward", 'constructo')=>"step-backward",
                html_entity_decode("&#xf051; ") . __("step-forward", 'constructo')=>"step-forward",
                html_entity_decode("&#xf0f1; ") . __("stethoscope", 'constructo')=>"stethoscope",
                html_entity_decode("&#xf04d; ") . __("stop", 'constructo')=>"stop",
                html_entity_decode("&#xf21d; ") . __("street-view", 'constructo')=>"street-view",
                html_entity_decode("&#xf0cc; ") . __("strikethrough", 'constructo')=>"strikethrough",
                html_entity_decode("&#xf1a4; ") . __("stumbleupon", 'constructo')=>"stumbleupon",
                html_entity_decode("&#xf1a3; ") . __("stumbleupon-circle", 'constructo')=>"stumbleupon-circle",
                html_entity_decode("&#xf12c; ") . __("subscript", 'constructo')=>"subscript",
                html_entity_decode("&#xf239; ") . __("subway", 'constructo')=>"subway",
                html_entity_decode("&#xf0f2; ") . __("suitcase", 'constructo')=>"suitcase",
                html_entity_decode("&#xf185; ") . __("sun-o", 'constructo')=>"sun-o",
                html_entity_decode("&#xf12b; ") . __("superscript", 'constructo')=>"superscript",
                html_entity_decode("&#xf1cd; ") . __("support (alias)", 'constructo')=>"support (alias)",
                html_entity_decode("&#xf0ce; ") . __("table", 'constructo')=>"table",
                html_entity_decode("&#xf10a; ") . __("tablet", 'constructo')=>"tablet",
                html_entity_decode("&#xf0e4; ") . __("tachometer", 'constructo')=>"tachometer",
                html_entity_decode("&#xf02b; ") . __("tag", 'constructo')=>"tag",
                html_entity_decode("&#xf02c; ") . __("tags", 'constructo')=>"tags",
                html_entity_decode("&#xf0ae; ") . __("tasks", 'constructo')=>"tasks",
                html_entity_decode("&#xf1ba; ") . __("taxi", 'constructo')=>"taxi",
                html_entity_decode("&#xf1d5; ") . __("tencent-weibo", 'constructo')=>"tencent-weibo",
                html_entity_decode("&#xf120; ") . __("terminal", 'constructo')=>"terminal",
                html_entity_decode("&#xf034; ") . __("text-height", 'constructo')=>"text-height",
                html_entity_decode("&#xf035; ") . __("text-width", 'constructo')=>"text-width",
                html_entity_decode("&#xf00a; ") . __("th", 'constructo')=>"th",
                html_entity_decode("&#xf009; ") . __("th-large", 'constructo')=>"th-large",
                html_entity_decode("&#xf00b; ") . __("th-list", 'constructo')=>"th-list",
                html_entity_decode("&#xf08d; ") . __("thumb-tack", 'constructo')=>"thumb-tack",
                html_entity_decode("&#xf165; ") . __("thumbs-down", 'constructo')=>"thumbs-down",
                html_entity_decode("&#xf088; ") . __("thumbs-o-down", 'constructo')=>"thumbs-o-down",
                html_entity_decode("&#xf087; ") . __("thumbs-o-up", 'constructo')=>"thumbs-o-up",
                html_entity_decode("&#xf164; ") . __("thumbs-up", 'constructo')=>"thumbs-up",
                html_entity_decode("&#xf145; ") . __("ticket", 'constructo')=>"ticket",
                html_entity_decode("&#xf00d; ") . __("times", 'constructo')=>"times",
                html_entity_decode("&#xf057; ") . __("times-circle", 'constructo')=>"times-circle",
                html_entity_decode("&#xf05c; ") . __("times-circle-o", 'constructo')=>"times-circle-o",
                html_entity_decode("&#xf043; ") . __("tint", 'constructo')=>"tint",
                html_entity_decode("&#xf150; ") . __("toggle-down (alias)", 'constructo')=>"toggle-down (alias)",
                html_entity_decode("&#xf191; ") . __("toggle-left (alias)", 'constructo')=>"toggle-left (alias)",
                html_entity_decode("&#xf204; ") . __("toggle-off", 'constructo')=>"toggle-off",
                html_entity_decode("&#xf205; ") . __("toggle-on", 'constructo')=>"toggle-on",
                html_entity_decode("&#xf152; ") . __("toggle-right (alias)", 'constructo')=>"toggle-right (alias)",
                html_entity_decode("&#xf151; ") . __("toggle-up (alias)", 'constructo')=>"toggle-up (alias)",
                html_entity_decode("&#xf238; ") . __("train", 'constructo')=>"train",
                html_entity_decode("&#xf224; ") . __("transgender", 'constructo')=>"transgender",
                html_entity_decode("&#xf225; ") . __("transgender-alt", 'constructo')=>"transgender-alt",
                html_entity_decode("&#xf1f8; ") . __("trash", 'constructo')=>"trash",
                html_entity_decode("&#xf014; ") . __("trash-o", 'constructo')=>"trash-o",
                html_entity_decode("&#xf1bb; ") . __("tree", 'constructo')=>"tree",
                html_entity_decode("&#xf181; ") . __("trello", 'constructo')=>"trello",
                html_entity_decode("&#xf091; ") . __("trophy", 'constructo')=>"trophy",
                html_entity_decode("&#xf0d1; ") . __("truck", 'constructo')=>"truck",
                html_entity_decode("&#xf195; ") . __("try", 'constructo')=>"try",
                html_entity_decode("&#xf1e4; ") . __("tty", 'constructo')=>"tty",
                html_entity_decode("&#xf173; ") . __("tumblr", 'constructo')=>"tumblr",
                html_entity_decode("&#xf174; ") . __("tumblr-square", 'constructo')=>"tumblr-square",
                html_entity_decode("&#xf195; ") . __("turkish-lira (alias)", 'constructo')=>"turkish-lira (alias)",
                html_entity_decode("&#xf1e8; ") . __("twitch", 'constructo')=>"twitch",
                html_entity_decode("&#xf099; ") . __("twitter", 'constructo')=>"twitter",
                html_entity_decode("&#xf081; ") . __("twitter-square", 'constructo')=>"twitter-square",
                html_entity_decode("&#xf0e9; ") . __("umbrella", 'constructo')=>"umbrella",
                html_entity_decode("&#xf0cd; ") . __("underline", 'constructo')=>"underline",
                html_entity_decode("&#xf0e2; ") . __("undo", 'constructo')=>"undo",
                html_entity_decode("&#xf19c; ") . __("university", 'constructo')=>"university",
                html_entity_decode("&#xf127; ") . __("unlink (alias)", 'constructo')=>"unlink (alias)",
                html_entity_decode("&#xf09c; ") . __("unlock", 'constructo')=>"unlock",
                html_entity_decode("&#xf13e; ") . __("unlock-alt", 'constructo')=>"unlock-alt",
                html_entity_decode("&#xf0dc; ") . __("unsorted (alias)", 'constructo')=>"unsorted (alias)",
                html_entity_decode("&#xf093; ") . __("upload", 'constructo')=>"upload",
                html_entity_decode("&#xf155; ") . __("usd", 'constructo')=>"usd",
                html_entity_decode("&#xf007; ") . __("user", 'constructo')=>"user",
                html_entity_decode("&#xf0f0; ") . __("user-md", 'constructo')=>"user-md",
                html_entity_decode("&#xf234; ") . __("user-plus", 'constructo')=>"user-plus",
                html_entity_decode("&#xf21b; ") . __("user-secret", 'constructo')=>"user-secret",
                html_entity_decode("&#xf235; ") . __("user-times", 'constructo')=>"user-times",
                html_entity_decode("&#xf0c0; ") . __("users", 'constructo')=>"users",
                html_entity_decode("&#xf221; ") . __("venus", 'constructo')=>"venus",
                html_entity_decode("&#xf226; ") . __("venus-double", 'constructo')=>"venus-double",
                html_entity_decode("&#xf228; ") . __("venus-mars", 'constructo')=>"venus-mars",
                html_entity_decode("&#xf237; ") . __("viacoin", 'constructo')=>"viacoin",
                html_entity_decode("&#xf03d; ") . __("video-camera", 'constructo')=>"video-camera",
                html_entity_decode("&#xf194; ") . __("vimeo-square", 'constructo')=>"vimeo-square",
                html_entity_decode("&#xf1ca; ") . __("vine", 'constructo')=>"vine",
                html_entity_decode("&#xf189; ") . __("vk", 'constructo')=>"vk",
                html_entity_decode("&#xf027; ") . __("volume-down", 'constructo')=>"volume-down",
                html_entity_decode("&#xf026; ") . __("volume-off", 'constructo')=>"volume-off",
                html_entity_decode("&#xf028; ") . __("volume-up", 'constructo')=>"volume-up",
                html_entity_decode("&#xf071; ") . __("warning (alias)", 'constructo')=>"warning (alias)",
                html_entity_decode("&#xf1d7; ") . __("wechat (alias)", 'constructo')=>"wechat (alias)",
                html_entity_decode("&#xf18a; ") . __("weibo", 'constructo')=>"weibo",
                html_entity_decode("&#xf1d7; ") . __("weixin", 'constructo')=>"weixin",
                html_entity_decode("&#xf232; ") . __("whatsapp", 'constructo')=>"whatsapp",
                html_entity_decode("&#xf193; ") . __("wheelchair", 'constructo')=>"wheelchair",
                html_entity_decode("&#xf1eb; ") . __("wifi", 'constructo')=>"wifi",
                html_entity_decode("&#xf17a; ") . __("windows", 'constructo')=>"windows",
                html_entity_decode("&#xf159; ") . __("won (alias)", 'constructo')=>"won (alias)",
                html_entity_decode("&#xf19a; ") . __("wordpress", 'constructo')=>"wordpress",
                html_entity_decode("&#xf0ad; ") . __("wrench", 'constructo')=>"wrench",
                html_entity_decode("&#xf168; ") . __("xing", 'constructo')=>"xing",
                html_entity_decode("&#xf169; ") . __("xing-square", 'constructo')=>"xing-square",
                html_entity_decode("&#xf19e; ") . __("yahoo", 'constructo')=>"yahoo",
                html_entity_decode("&#xf1e9; ") . __("yelp", 'constructo')=>"yelp",
                html_entity_decode("&#xf157; ") . __("yen (alias)", 'constructo')=>"yen (alias)",
                html_entity_decode("&#xf167; ") . __("youtube", 'constructo')=>"youtube",
                html_entity_decode("&#xf16a; ") . __("youtube-play", 'constructo')=>"youtube-play",
                html_entity_decode("&#xf166; ") . __("youtube-square", 'constructo')=>"youtube-square",
                //4.4 update
                html_entity_decode("&#xf26e; ") . __(" 500px", 'constructo')=>"500px",
                html_entity_decode("&#xf243; ") . __(" battery-quarter ", 'constructo')=>"battery-quarter ",
                html_entity_decode("&#xf244; ") . __(" battery-empty ", 'constructo')=>" battery-empty ",
                html_entity_decode("&#xf241; ") . __(" battery-three-quarters", 'constructo')=>" battery-three-quarters",
                html_entity_decode("&#xf271; ") . __(" calendar-plus-o ", 'constructo')=>" calendar-plus-o ",
                html_entity_decode("&#xf268; ") . __(" chrome", 'constructo')=>" chrome",
                html_entity_decode("&#xf26d; ") . __(" contao", 'constructo')=>" contao",
                html_entity_decode("&#xf280; ") . __(" fonticons ", 'constructo')=>" fonticons ",
                html_entity_decode("&#xf261; ") . __(" gg-circle ", 'constructo')=>" gg-circle ",
                html_entity_decode("&#xf25b; ") . __(" peace ", 'constructo')=>" peace ",
                html_entity_decode("&#xf259; ") . __(" spock ", 'constructo')=>" spock ",
                html_entity_decode("&#xf252; ") . __(" hourglass ", 'constructo')=>" hourglass ",
                html_entity_decode("&#xf250; ") . __(" hourglass-o ", 'constructo')=>" hourglass-o ",
                html_entity_decode("&#xf275; ") . __(" industry", 'constructo')=>" industry",
                html_entity_decode("&#xf276; ") . __(" map-pin ", 'constructo')=>" map-pin ",
                html_entity_decode("&#xf248; ") . __(" ungroup ", 'constructo')=>" ungroup ",
                html_entity_decode("&#xf249; ") . __(" sticky-note ", 'constructo')=>" sticky-note ",
                html_entity_decode("&#xf23b; ") . __(" Y-combinator-o", 'constructo')=>" Y-combinator-o",
                html_entity_decode("&#xf262; ") . __(" tripadvisor ", 'constructo')=>" tripadvisor ",
                html_entity_decode("&#xf26a; ") . __(" opera ", 'constructo')=>" opera ",
                html_entity_decode("&#xf270; ") . __(" amazon", 'constructo')=>" amazon",
                html_entity_decode("&#xf242; ") . __(" battery-half", 'constructo')=>" battery-half",
                html_entity_decode("&#xf240; ") . __(" battery-full", 'constructo')=>" battery-full",
                html_entity_decode("&#xf27e; ") . __(" black-tie ", 'constructo')=>" black-tie ",
                html_entity_decode("&#xf273; ") . __(" calendar-times-o", 'constructo')=>" calendar-times-o",
                html_entity_decode("&#xf24d; ") . __(" clone ", 'constructo')=>" clone ",
                html_entity_decode("&#xf25e; ") . __(" creative-commons", 'constructo')=>" creative-commons",
                html_entity_decode("&#xf22d; ") . __(" genderless", 'constructo')=>" genderless",
                html_entity_decode("&#xf255; ") . __(" hand-rock-o ", 'constructo')=>" hand-rock-o ",
                html_entity_decode("&#xf25a; ") . __(" hand-pointer-o  ", 'constructo')=>" hand-pointer-o  ",
                html_entity_decode("&#xf256; ") . __(" hand-paper-o", 'constructo')=>" hand-paper-o",
                html_entity_decode("&#xf253; ") . __(" hourglass-end ", 'constructo')=>" hourglass-end ",
                html_entity_decode("&#xf251; ") . __(" hourglass-start ", 'constructo')=>" hourglass-start ",
                html_entity_decode("&#xf26b; ") . __(" internet-explorer ", 'constructo')=>" internet-explorer ",
                html_entity_decode("&#xf277; ") . __(" map-signs ", 'constructo')=>" map-signs ",
                html_entity_decode("&#xf263; ") . __(" odnoklassniki ", 'constructo')=>" odnoklassniki ",
                html_entity_decode("&#xf23c; ") . __(" optin-monster ", 'constructo')=>" optin-monster ",
                html_entity_decode("&#xf24a; ") . __(" sticky-note-o ", 'constructo')=>" sticky-note-o ",
                html_entity_decode("&#xf26c; ") . __(" television", 'constructo')=>" television",
                html_entity_decode("&#xf23b; ") . __(" y-combinator", 'constructo')=>" y-combinator",
                html_entity_decode("&#xf24e; ") . __(" balance-scale ", 'constructo')=>" balance-scale ",
                html_entity_decode("&#xf241; ") . __(" battery-three-quarters", 'constructo')=>" battery-three-quarters",
                html_entity_decode("&#xf242; ") . __(" battery-half", 'constructo')=>" battery-half",
                html_entity_decode("&#xf274; ") . __(" calendar-check-o", 'constructo')=>" calendar-check-o",
                html_entity_decode("&#xf24c; ") . __(" Cc-diners-club", 'constructo')=>" Cc-diners-club",
                html_entity_decode("&#xf27a; ") . __(" commenting", 'constructo')=>" commenting",
                html_entity_decode("&#xf23e; ") . __(" expeditedssl", 'constructo')=>" expeditedssl",
                html_entity_decode("&#xf265; ") . __(" get-pocket", 'constructo')=>" get-pocket",
                html_entity_decode("&#xf258; ") . __(" hand-lizard-o ", 'constructo')=>" hand-lizard-o ",
                html_entity_decode("&#xf255; ") . __(" hand-rock-o ", 'constructo')=>" hand-rock-o ",
                html_entity_decode("&#xf254; ") . __(" hourglass ", 'constructo')=>" hourglass ",
                html_entity_decode("&#xf253; ") . __(" hourglass-end ", 'constructo')=>" hourglass-end ",
                html_entity_decode("&#xf27c; ") . __(" houzz ", 'constructo')=>" houzz ",
                html_entity_decode("&#xf279; ") . __(" map ", 'constructo')=>" map ",
                html_entity_decode("&#xf245; ") . __(" mouse-pointer ", 'constructo')=>" mouse-pointer ",
                html_entity_decode("&#xf264; ") . __(" odnoklassniki-square", 'constructo')=>" odnoklassniki-square",
                html_entity_decode("&#xf25d; ") . __(" registered", 'constructo')=>" registered",
                html_entity_decode("&#xf26c; ") . __(" television", 'constructo')=>" television",
                html_entity_decode("&#xf27d; ") . __(" vimeo ", 'constructo')=>" vimeo ",
                html_entity_decode("&#xf244; ") . __(" battery-empty ", 'constructo')=>" battery-empty ",
                html_entity_decode("&#xf240; ") . __(" battery-full", 'constructo')=>" battery-full",
                html_entity_decode("&#xf243; ") . __(" battery-quarter ", 'constructo')=>" battery-quarter ",
                html_entity_decode("&#xf272; ") . __(" calendar-minus-o", 'constructo')=>" calendar-minus-o",
                html_entity_decode("&#xf24b; ") . __(" cc-jcb", 'constructo')=>" cc-jcb",
                html_entity_decode("&#xf27b; ") . __(" commenting-o", 'constructo')=>" commenting-o",
                html_entity_decode("&#xf269; ") . __(" firefox ", 'constructo')=>" firefox ",
                html_entity_decode("&#xf260; ") . __(" gg", 'constructo')=>" gg",
                html_entity_decode("&#xf256; ") . __(" hand-paper-o  ", 'constructo')=>" hand-paper-o  ",
                html_entity_decode("&#xf257; ") . __(" hand-scissors-o ", 'constructo')=>" hand-scissors-o ",
                html_entity_decode("&#xf251; ") . __(" hourglass-start ", 'constructo')=>" hourglass-start ",
                html_entity_decode("&#xf252; ") . __(" hourglass-half", 'constructo')=>" hourglass-half",
                html_entity_decode("&#xf246; ") . __(" i-cursor", 'constructo')=>" i-cursor",
                html_entity_decode("&#xf278; ") . __(" map-o ", 'constructo')=>" map-o ",
                html_entity_decode("&#xf247; ") . __(" object-group", 'constructo')=>" object-group",
                html_entity_decode("&#xf23d; ") . __(" opencart", 'constructo')=>" opencart",
                html_entity_decode("&#xf267; ") . __(" safari", 'constructo')=>" safari",
                html_entity_decode("&#xf25c; ") . __(" trademark ", 'constructo')=>" trademark ",
                html_entity_decode("&#xf266; ") . __(" wikipedia-w ", 'constructo')=>" wikipedia-w ");


        return $icon_array;
    }
}

add_action( 'widgets_init', create_function('', 'return register_widget("AnpsDownload");') );