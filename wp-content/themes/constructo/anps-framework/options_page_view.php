<?php
include_once 'classes/Options.php';

$anps_options_data = $options->get_page_data();  
if (isset($_GET['save_page'])) {
    update_option("vertical_menu",$_POST['vertical_menu']);

    update_option("page_sidebar_left", $_POST['page_sidebar_left']);
    update_option("page_sidebar_right", $_POST['page_sidebar_right']);

    update_option("post_sidebar_left", $_POST['post_sidebar_left']);
    update_option("post_sidebar_right", $_POST['post_sidebar_right']);
  $options->save_page();
}
?>
<form action="themes.php?page=theme_options&sub_page=options_page&save_page" method="post">

    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>" /><div class="clear"></div></div>

    <div class="content-inner">
        <!-- Page layout -->
        <h3><?php _e("Page layout:", 'constructo'); ?></h3>
        <p><?php _e("Here you can change all the settings about responsive layout and will your site be boxed (when checked you will have more options).", 'constructo'); ?></p>        
        <div class="info">
            <!-- Hide slider on mobile -->
            <div class="input onoffswitch fullwidth floatleft">
                <?php
                if(!isset($anps_options_data['hide_slider_on_mobile']))
                    $checked='';
                elseif ($anps_options_data['hide_slider_on_mobile'] == '-1')
                    $checked = '';
                elseif ($anps_options_data['hide_slider_on_mobile'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label class="onehalf floatleft" for="hide_slider_on_mobile"><?php _e("Hide slider on mobile", "michell"); ?></label>
                <input type="checkbox" name="hide_slider_on_mobile" class="onoffswitch-checkbox onehalf floatright" id="hide_slider_on_mobile" <?php echo $checked; ?>>
               <label class="onoffswitch-label" for="hide_slider_on_mobile">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- Boxed -->
            <div class="input onoffswitch fullwidth floatleft">
                <?php
                if(!isset($anps_options_data['boxed']))
                    $checked='';
                elseif ($anps_options_data['boxed'] == '-1')
                    $checked = '';
                elseif ($anps_options_data['boxed'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label class="onehalf floatleft" for="boxed"><?php _e("Boxed", 'constructo'); ?></label>
                <input id="is-boxed" class="onoffswitch-checkbox onehalf floatright" style="margin-left: 74px" type="checkbox" name="boxed" <?php echo $checked; ?> />
                <label class="onoffswitch-label" for="is-boxed">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- Pattern -->
            <div <?php if ($checked == "") echo 'style="display:none"'; ?> class="input fullwidth" id="pattern-select-wrapper">
                <label for="pattern"><?php _e("Pattern", 'constructo'); ?></label>
                <div class="admin-patern-radio">
                    <?php for ($i = 0; $i < 10; $i++) :
                        if ($anps_options_data['pattern'] == $i)
                            $checked = 'checked';
                        else
                            $checked = '';
                        ?>
                        <input type="radio" name="pattern" value="<?php echo esc_attr($i); ?>" <?php echo $checked; ?>/>
                    <?php endfor; ?>
                </div>
                <div class="admin-patern-select fullwidth">
                    <?php for ($i = 0; $i < 10; $i++) : ?>
                        <?php if ($anps_options_data['pattern'] == $i): ?>
                            <img id="selected-pattern" src="<?php echo get_stylesheet_directory_uri(); ?>/css/boxed/pattern-<?php echo esc_attr($i); ?>.png" />
                        <?php else: ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/css/boxed/pattern-<?php echo esc_attr($i); ?>.png" />
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div style="clear: both"></div>
            </div>
            <!-- Custom background -->
            <div class="input fullwidth" <?php if (!isset($anps_options_data['boxed']) || $anps_options_data['pattern'] != 0 || $anps_options_data['boxed'] == '-1' || $anps_options_data['boxed'] == '') echo 'style="display: none"'; ?> id="patern-type-wrapper">
                <label for="pattern"><?php _e("Custom background type", 'constructo' ); ?></label>
                <div class="patern-type">
                    <?php $types = array('stretched', 'tilled', 'custom color');
                    foreach ($types as $type) :
                        if(!isset($anps_options_data['type']))
                            $checked='';
                        elseif ($anps_options_data['type'] == $type)
                            $checked = 'checked';
                        else
                            $checked = '';
                        ?>
                    <span class="onethird">
                        <input style="display: inline-block;" type="radio" id="back-type-<?php echo esc_attr($type); ?>" name="type" value="<?php echo esc_attr($type); ?>" <?php echo $checked; ?>/>
                        <label style="font-weight: normal;display: inline; margin: 0; cursor: pointer" for="back-type-<?php echo esc_attr($type); ?>"><?php echo esc_attr($type); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Custom pattern -->
            <div class="input fullwidth"  <?php if ((!isset($anps_options_data['boxed']) || ( isset($anps_options_data['pattern']) && $anps_options_data['pattern'] != 0 ) || (isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == '-1') || (isset($anps_options_data['boxed']) && $anps_options_data['boxed'] == '') || (isset($anps_options_data['type'] ) && ($anps_options_data['type'] != "stretched") && $anps_options_data['type'] != "tilled" ))) echo 'style="display: none"'; ?> id="custom-patern-wrapper">
                <label for="custom_pattern"><?php _e("Custom background image/pattern", 'constructo'); ?></label>
                <input class="wninety" id="custom_pattern" type="text" size="36" name="custom_pattern" value="<?php echo esc_attr($anps_options_data['custom_pattern']); ?>" />
                <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            </div>
            <!-- Custom background color -->

            <div id="custom-background-color-wrapper" class="input" <?php if ((!isset($anps_options_data['boxed']) || $anps_options_data['pattern'] != 0 || $anps_options_data['boxed'] == '-1' || $anps_options_data['boxed'] == '') || (!isset($anps_options_data['type']) || $anps_options_data['type'] != "custom color") ) echo 'style="display: none"'; ?>>
                <label for="bg_color"><?php _e("Custom background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr($anps_options_data['bg_color']); ?>" readonly style="background: <?php echo esc_attr($anps_options_data['bg_color']); ?>" class="color-pick-color"><input class="color-pick" type="text" name="bg_color" value="<?php echo esc_attr($anps_options_data['bg_color']); ?>" id="bg_color" />
            </div>
    </div>
        <div class="clear"></div>
        <!-- Page Sidebars (global settings) -->
        <?php global $wp_registered_sidebars;  ?>

        <h3><?php _e("Page Sidebars", 'constructo'); ?></h3>
        <p><?php _e("This will change the default sidebar value on all pages. It can be changed on each page individually.", 'constructo'); ?></p>

        <!-- Left Sidebar -->
        <div class="input onehalf" style="padding-top: 0;">
            <label for="page-sidebar-left"><?php _e("Left Sidebar", 'constructo'); ?></label>
            <select name="page_sidebar_left" id="page-sidebar-left">
                <option value="0"></option>
            <?php
                global $wp_registered_sidebars;     
                $sidebars = $wp_registered_sidebars;

                if( is_array($sidebars) && !empty($sidebars) ) {
                    foreach( $sidebars as $sidebar ) {
                        if( $anps_options_data['page_sidebar_left'] && $anps_options_data['page_sidebar_left'] == esc_attr($sidebar['name']) ) { 
                            echo '<option value="' . esc_attr($sidebar['name']) . '" selected>' . esc_attr($sidebar['name']) . '</option>';
                        } else {
                            echo '<option value="' . esc_attr($sidebar['name']) . '">' . esc_attr($sidebar['name']) . '</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>

        <!-- Right Sidebar -->
        <div class="input onehalf" style="padding-top: 0;">
            <label for="page-sidebar-right"><?php _e("Right Sidebar", 'constructo'); ?></label>
            <select name="page_sidebar_right" id="page-sidebar-right">
                <option value="0"></option>
            <?php
                global $wp_registered_sidebars;     
                $sidebars = $wp_registered_sidebars;

                if( is_array($sidebars) && !empty($sidebars) ) {
                    foreach( $sidebars as $sidebar ) {
                        if( $anps_options_data['page_sidebar_right'] && $anps_options_data['page_sidebar_right'] == esc_attr($sidebar['name']) ) { 
                            echo '<option value="' . esc_attr($sidebar['name']) . '" selected>' . esc_attr($sidebar['name']) . '</option>';
                        } else {
                            echo '<option value="' . esc_attr($sidebar['name']) . '">' . esc_attr($sidebar['name']) . '</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>

       <div class="clear"></div>
        <!-- Post Sidebars (global settings) -->
        <?php global $wp_registered_sidebars;  ?>

        <h3><?php _e("Post Sidebars", 'constructo'); ?></h3>
        <p><?php _e("This will change the default sidebar value on all posts. It can be changed on each post individually.", 'constructo'); ?></p>

        <!-- Left Sidebar -->
        <div class="input onehalf" style="padding-top: 0;">
            <label for="post-sidebar-left"><?php _e("Left Sidebar", 'constructo'); ?></label>
            <select name="post_sidebar_left" id="post-sidebar-left">
                <option value="0"></option>
            <?php
                global $wp_registered_sidebars;     
                $sidebars = $wp_registered_sidebars;

                if( is_array($sidebars) && !empty($sidebars) ) {
                    foreach( $sidebars as $sidebar ) {
                        if( $anps_options_data['post_sidebar_left'] && $anps_options_data['post_sidebar_left'] == esc_attr($sidebar['name']) ) { 
                            echo '<option value="' . esc_attr($sidebar['name']) . '" selected>' . esc_attr($sidebar['name']) . '</option>';
                        } else {
                            echo '<option value="' . esc_attr($sidebar['name']) . '">' . esc_attr($sidebar['name']) . '</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>

        <!-- Right Sidebar -->
        <div class="input onehalf" style="padding-top: 0;">
            <label for="post-sidebar-right"><?php _e("Right Sidebar", 'constructo'); ?></label>
            <select name="post_sidebar_right" id="post-sidebar-right">
                <option value="0"></option>
            <?php
                global $wp_registered_sidebars;     
                $sidebars = $wp_registered_sidebars;

                if( is_array($sidebars) && !empty($sidebars) ) {
                    foreach( $sidebars as $sidebar ) {
                        if( $anps_options_data['post_sidebar_right'] && $anps_options_data['post_sidebar_right'] == esc_attr($sidebar['name']) ) { 
                            echo '<option value="' . esc_attr($sidebar['name']) . '" selected>' . esc_attr($sidebar['name']) . '</option>';
                        } else {
                            echo '<option value="' . esc_attr($sidebar['name']) . '">' . esc_attr($sidebar['name']) . '</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>


        <div class="clear"></div>
        <h3><?php _e("Heading", 'constructo'); ?></h3>
        <!-- Disable page title, breadcrumbs and background -->
            <div class="input onoffswitch fullwidth floatleft">
                <?php 
                if(!isset($anps_options_data['disable_heading']))
                    $checked='';
                elseif ($anps_options_data['disable_heading'] == '-1')
                    $checked = '';
                elseif ($anps_options_data['disable_heading'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label class="onehalf floatleft" for="disable_heading"><?php _e("Disable page title, breadcrumbs and background", 'constructo'); ?></label>
                <input class="onoffswitch-checkbox onehalf floatright" style="margin-left: 117px" type="checkbox" id="disable_heading" name="disable_heading" <?php echo $checked; ?> />
                <label class="onoffswitch-label" for="disable_heading">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- END Disable page title, breadcrumbs and background --> 
            <!-- Breadcrumbs disable -->
            <div class="input onoffswitch fullwidth floatleft">
                <?php 
                if(!isset($anps_options_data['breadcrumbs']))
                    $checked='';
                elseif ($anps_options_data['breadcrumbs'] == '-1')
                    $checked = '';
                elseif ($anps_options_data['breadcrumbs'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>
                <label class="onehalf floatleft" for="breadcrumbs"><?php _e("Disable breadcrumbs", 'constructo'); ?></label>
                <input class="onoffswitch-checkbox onehalf floatright" style="margin-left: 63px" type="checkbox" id="breadcrumbs" name="breadcrumbs" <?php echo $checked; ?> />
                <label class="onoffswitch-label" for="breadcrumbs">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- END Breadcrumbs disable --> 
            <div class="clear"></div>

        <h3><?php _e("Vertical menu?", 'constructo'); ?></h3>
            <p>This option overrides other menu options</p>
            <div class="clear"></div>
            <div class="input onoffswitch fullwidth floatleft">
                <?php
                if(!isset($anps_options_data['vertical_menu']))
                    $checked='';
                elseif ($anps_options_data['vertical_menu'] == '-1')
                    $checked = '';
                elseif ($anps_options_data['vertical_menu'] == '')
                    $checked = '';
                else
                    $checked = 'checked';
                ?>

               
                <label class="onehalf floatleft" for="vertical_menu"><?php _e("Enable vertical menu?", 'constructo'); ?></label>
                <input class="onoffswitch-checkbox onehalf floatright vertical-menu-switch" style="margin-left: 63px" type="checkbox" id="vertical_menu" name="vertical_menu" <?php echo $checked; ?> />
                <label class="onoffswitch-label" for="vertical_menu">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
  
            <!-- Custom menu background -->
            <div class="input fullwidth" id="custom-header-bg-vertical-wrap">
                <label for="custom-header-bg-vertical"><?php _e("Custom vertical menu background image", 'constructo'); ?></label>
                <input class="wninety" id="custom-header-bg-vertical" type="text" size="36" name="custom-header-bg-vertical" value="<?php if (isset($anps_options_data['custom-header-bg-vertical'])) { echo esc_attr($anps_options_data['custom-header-bg-vertical']); } ?>" />
                <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            </div>

            <!-- END Vertical menu --> 
            <div class="clear"></div>
    
    <h3><?php _e("Mobile layout", 'constructo'); ?></h3>

             <select name="footer_columns">
                    <option value="0">*** Select ***</option>
                    <?php 
                            $pages = array("1"=>"1 column" ,"2"=>"2 columns"); 
                            foreach ($pages as $key=>$item) : 
                                    if (isset($anps_options_data['footer_columns']) && $anps_options_data['footer_columns']==$key) {
                                            $selected = 'selected="selected"';
                                    }
                                    else {         
                                            $selected = '';
                                    }
                    ?>      <option value="<?php echo esc_attr($key); ?>" <?php echo $selected; ?>><?php echo esc_html($item); ?></option>                 
                    <?php endforeach; ?>            
            </select>        
            <div class="clear"></div>

</div>

<div class="content-top" style="border-style: solid none; margin-top: 70px">
    <input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>">
    <div class="clear"></div>
</div>
</form>


<?php
    if (isset($_GET['save_page'])) {
      //update_option("rtl", $_POST['rtl']);
    }
?>