<?php 
include_once 'classes/Style.php';
wp_enqueue_script('font_subsets');
/* Save form */
if(isset($_GET['save_style']))
    $style->save();
/* get all fonts */
$fonts = $style->all_fonts(); 
?>
<div class="content">
    <form action="themes.php?page=theme_options&save_style" method="post">
        <div class="content-top">
            <input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php _e("Font family", 'constructo'); ?></h3>
            <h4>Custom font styles</h4>
            <p>If subsets are not active please update google fonts <a href="themes.php?page=theme_options&sub_page=theme_style_google_font">here</a>.</p>
            <div class="input onethird">
                <label for="font_type_1">Font type 1</label>                    
                <select name="font_type_1" id="font_type_1">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) : 
                            $selected = '';
                            if ($font['value'] == get_option('font_type_1', 'Montserrat')) {
                                $selected = 'selected="selected"';     
                                if($name=="Google fonts") {
                                    $subsets = $font['subsets'];
                                } else {
                                    $subsets = "";
                                }
                            }                            
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_1" class="font_subsets">
                    <?php if($subsets) : 
                        $i=0;
                        foreach($subsets as $item) :
                            if(is_array(get_option("font_type_1_subsets"))&&in_array($item, get_option("font_type_1_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_1_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_2"><?php _e("Font type 2", 'constructo'); ?></label>
                <select name="font_type_2" id="font_type_2">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) : 
                            $selected = ''; 
                            if ($font['value'] == get_option('font_type_2', "PT+Sans")) { 
                                $selected = 'selected="selected"';
                                if($name=="Google fonts") {
                                    $subsets2 = $font['subsets'];
                                } else {
                                    $subsets2 = "";
                                }
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?> <?php if(esc_attr($name=="Google fonts")) {echo "data-font='gfonts'";} ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_2" class="font_subsets">
                    <?php if($subsets2) : 
                        $i=0;
                        foreach($subsets2 as $item) :
                            if(is_array(get_option("font_type_2_subsets"))&&in_array($item, get_option("font_type_2_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_2_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_navigation"><?php _e("Navigation font type", 'constructo'); ?></label>
                <select name="font_type_navigation" id="font_type_navigation">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_navigation', 'Montserrat')) {
                                $selected = 'selected="selected"';
                                if($name=="Google fonts") {
                                    $subsets3 = $font['subsets'];
                                } else {
                                    $subsets3 = "";
                                }
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?> <?php if(esc_attr($name=="Google fonts")) {echo "data-font='gfonts'";} ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_navigation" class="font_subsets">
                    <?php if($subsets3) : 
                        $i=0;
                        foreach($subsets3 as $item) :
                            if(is_array(get_option("font_type_navigation_subsets"))&&in_array($item, get_option("font_type_navigation_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_navigation_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="clear"></div>

            <h3><?php _e("Font sizes", 'constructo'); ?></h3>
            <div class="input onequarter">
                <label for="body_font_size"><?php _e("Body Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="body_font_size" value="<?php echo esc_attr(get_option('body_font_size', '14')); ?>" id="body_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="menu_font_size"><?php _e("Menu Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="menu_font_size" value="<?php echo esc_attr(get_option('menu_font_size', '14')); ?>" id="menu_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="h1_font_size"><?php _e("Content Heading 1 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="h1_font_size" value="<?php echo esc_attr(get_option('h1_font_size', '31')); ?>" id="h1_font_size" placeholder="31"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="h2_font_size"><?php _e("Content Heading 2 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="h2_font_size" value="<?php echo esc_attr(get_option('h2_font_size', '24')); ?>" id="h2_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="h3_font_size"><?php _e("Content Heading 3 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="h3_font_size" value="<?php echo esc_attr(get_option('h3_font_size', '21')); ?>" id="h3_font_size" placeholder="21" /><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="h4_font_size"><?php _e("Content Heading 4 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="h4_font_size" value="<?php echo esc_attr(get_option('h4_font_size', '18')); ?>" id="h4_font_size" placeholder="18"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="h5_font_size"><?php _e("Content Heading 5 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="h5_font_size" value="<?php echo esc_attr(get_option('h5_font_size', '16')); ?>" id="h5_font_size" placeholder="16"/><span>px</span>

            </div>
            <div class="input onequarter">
                <label for="page_heading_h1_font_size"><?php _e("Page Heading 1 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="page_heading_h1_font_size" value="<?php echo esc_attr(get_option('page_heading_h1_font_size', '24')); ?>" id="page_heading_h1_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="input onequarter">
                <label for="blog_heading_h1_font_size"><?php _e("Single blog page heading 1 Font Size", 'constructo'); ?></label>
                <input class="size" type="text" name="blog_heading_h1_font_size" value="<?php echo esc_attr(get_option('blog_heading_h1_font_size', '28')); ?>" id="blog_heading_h1_font_size" placeholder="28"/><span>px</span>
            </div>
            <div class="clear"></div>
            <h3><?php _e("Predefined color Scheme", 'constructo'); ?></h3>
            <h4>Choose a predefined colour scheme</h4>
            <p><?php _e("Selecting one of this schemes will import the predefined colors below, which you can then edit as you like.", 'constructo'); ?></p>
            <div class="clear" ></div> 
            <div class="fullwidth" id="predefined_colors">
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="default" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#d54900;"></span><span class="colorspantext">Default</span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="yellow" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#f9e60d;"></span><span class="colorspantext">Yellow</span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="blue" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#3aaedf;"></span><span class="colorspantext">Blue</span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="green" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#43b425;"></span><span class="colorspantext">Green</span></div>
                </label>
                <div class="clear"></div>
            </div>
            <h3><?php _e("Main theme colors", 'constructo'); ?></h3>
            <h4>Set your custom colors</h4>
            <p>Not satisfied with the premade color schemes? Here you can set your custom colors.</p>
            <div class="input onequarter">
                <label for="text_color"><?php _e("Text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('text_color', '#727272')); ?>" readonly style="background: <?php echo esc_attr(get_option('text_color', '#727272')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="text_color" value="<?php echo esc_attr(get_option('text_color', '#727272')); ?>" id="text_color" />
            </div>
            <div class="input onequarter">
                <label for="primary_color"><?php _e("Primary color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('primary_color', '#292929')); ?>" readonly style="background: <?php echo esc_attr(get_option('primary_color', '#292929')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="primary_color" value="<?php echo esc_attr(get_option('primary_color', '#292929')); ?>" id="primary_color" />
            </div>
            <div class="input onequarter">
                <label for="hovers_color"><?php _e("Hovers color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('hovers_color', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('hovers_color', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="hovers_color" value="<?php echo esc_attr(get_option('hovers_color', '#d54900')); ?>" id="hovers_color" />
            </div>
            <div class="input onequarter">
                <label for="menu_text_color"><?php _e("Menu text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="menu_text_color" value="<?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" id="hovers_color" />
            </div>
            <div class="input onequarter">
                <label for="headings_color"><?php _e("Headings color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('headings_color', '#000000')); ?>" readonly style="background: <?php echo esc_attr(get_option('headings_color', '#000000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="headings_color" value="<?php echo esc_attr(get_option('headings_color', '#000000')); ?>" id="headings_color" />
            </div>
            <div class="input onequarter">
                <label for="top_bar_color"><?php _e("Top bar text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" readonly style="background: <?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="top_bar_color" value="<?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" id="top_bar_color" />
            </div>  
            <div class="input onequarter">
                <label for="top_bar_bg_color"><?php _e("Top bar background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" readonly style="background: <?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="top_bar_bg_color" value="<?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" id="top_bar_bg_color" />
            </div>  
            <div class="input onequarter">
                <label for="footer_bg_color"><?php _e("Footer background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('footer_bg_color', '#242424')); ?>" readonly style="background: <?php echo esc_attr(get_option('footer_bg_color', '#242424')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="footer_bg_color" value="<?php echo esc_attr(get_option('footer_bg_color', '#242424')); ?>" id="footer_bg_color" />
            </div>  
            <div class="input onequarter">
                <label for="copyright_footer_bg_color"><?php _e("Copyright footer background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('copyright_footer_bg_color', '#0f0f0f')); ?>" readonly style="background: <?php echo esc_attr(get_option('copyright_footer_bg_color', '#0f0f0f')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="copyright_footer_bg_color" value="<?php echo esc_attr(get_option('copyright_footer_bg_color', '#0f0f0f')); ?>" id="copyright_footer_bg_color" />
            </div>  
            <div class="input onequarter">
                <label for="footer_text_color"><?php _e("Footer text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('footer_text_color', '#d9d9d9')); ?>" readonly style="background: <?php echo esc_attr(get_option('footer_text_color', '#d9d9d9')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="footer_text_color" value="<?php echo esc_attr(get_option('footer_text_color', '#d9d9d9')); ?>" id="footer_text_color" />
            </div>  
            <div class="input onequarter">
                <label for="nav_background_color"><?php _e("Page header background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="nav_background_color" value="<?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" id="nav_background_color" />
            </div>  
            <div class="input onequarter">
                <label for="submenu_background_color"><?php _e("Submenu background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="submenu_background_color" value="<?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" id="submenu_background_color" />
            </div>  
            <div class="input onequarter">
                <label for="submenu_text_color"><?php _e("Submenu text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="submenu_text_color" value="<?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" id="submenu_text_color" />
            </div>         
            <div class="input onequarter">
                <label for="side_submenu_background_color"><?php _e("Side submenu background color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_background_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_background_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_background_color" value="<?php echo esc_attr(get_option('side_submenu_background_color', '#fff')); ?>" id="side_submenu_background_color" />
            </div>  
            <div class="input onequarter">
                <label for="side_submenu_text_color"><?php _e("Side submenu text color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_text_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_text_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_text_color" value="<?php echo esc_attr(get_option('side_submenu_text_color', '#000')); ?>" id="side_submenu_text_color" />
            </div>       
            <div class="input onequarter">
                <label for="side_submenu_text_hover_color"><?php _e("Side submenu text hover color", 'constructo'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_text_hover_color', 'd54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_text_hover_color', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_text_hover_color" value="<?php echo esc_attr(get_option('side_submenu_text_hover_color', '#d54900')); ?>" id="side_submenu_text_hover_color" />
            </div>    
            <div class="clear"></div>
        
        <h3><?php _e("Button styles", 'constructo'); ?></h3>
            <div class="input fullwidth">
                <p>Button styles will refresh after clicking "Save all changes".</p>
                <hr>
                <div class="fullwidth">
                    <h4>Default button</h4>
                    <a class="btn btn-sm" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="default_button_bg"><?php _e("Default button background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_bg', '#292929')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_bg', '#292929')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_bg" value="<?php echo esc_attr(get_option('default_button_bg', '#292929')); ?>" id="default_button_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="default_button_color"><?php _e("Default button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_color" value="<?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" id="default_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="default_button_hover_bg"><?php _e("Default button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_hover_bg', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_hover_bg', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_hover_bg" value="<?php echo esc_attr(get_option('default_button_hover_bg', '#d54900')); ?>" id="default_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="default_button_hover_color"><?php _e("Default button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_hover_color" value="<?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" id="default_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-1", 'constructo');?></h4>
                    <a class="btn btn-sm style-1" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_1_button_bg"><?php _e("button background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_bg', '#292929')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_bg', '#292929')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_bg" value="<?php echo esc_attr(get_option('style_1_button_bg', '#292929')); ?>" id="style_1_button_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_1_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_color" value="<?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" id="style_1_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_1_button_hover_bg"><?php _e("button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_hover_bg', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_hover_bg', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_hover_bg" value="<?php echo esc_attr(get_option('style_1_button_hover_bg', '#d54900')); ?>" id="style_1_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_1_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_hover_color" value="<?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" id="style_1_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-2", 'constructo');?></h4>
                    <a class="btn btn-sm style-2" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_2_button_bg"><?php _e("button background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_bg', '#292929')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_bg', '#292929')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_bg" value="<?php echo esc_attr(get_option('style_2_button_bg', '#292929')); ?>" id="style_2_button_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_2_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_color" value="<?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" id="style_2_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_2_button_hover_bg"><?php _e("button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_hover_bg', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_hover_bg', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_hover_bg" value="<?php echo esc_attr(get_option('style_2_button_hover_bg', '#d54900')); ?>" id="style_2_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_2_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_hover_color" value="<?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" id="style_2_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-3", 'constructo');?></h4>
                    <a class="btn btn-sm style-3" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_3_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_color" value="<?php echo esc_attr(get_option('style_3_button_color', '#000')); ?>" id="style_3_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_3_button_hover_bg"><?php _e("button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_hover_bg', '#fafafa')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_hover_bg', '#fafafa')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_hover_bg" value="<?php echo esc_attr(get_option('style_3_button_hover_bg', '#fafafa')); ?>" id="style_3_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_3_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_hover_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_hover_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_hover_color" value="<?php echo esc_attr(get_option('style_3_button_hover_color', '#000')); ?>" id="style_3_button_hover_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_3_button_border_color"><?php _e("button border color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_border_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_border_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_border_color" value="<?php echo esc_attr(get_option('style_3_button_border_color', '#000')); ?>" id="style_3_button_border_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-4", 'constructo');?></h4>
                    <a class="btn btn-sm style-4" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_4_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_4_button_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_4_button_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_4_button_color" value="<?php echo esc_attr(get_option('style_4_button_color', '#000')); ?>" id="style_4_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_4_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_4_button_hover_color', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_4_button_hover_color', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_4_button_hover_color" value="<?php echo esc_attr(get_option('style_4_button_hover_color', '#d54900')); ?>" id="style_4_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button slider", 'constructo');?></h4>
                    <a class="btn btn-sm slider" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_slider_button_bg"><?php _e("button background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_bg', '#292929')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_bg', '#292929')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_bg" value="<?php echo esc_attr(get_option('style_slider_button_bg', '#292929')); ?>" id="style_slider_button_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_slider_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_color" value="<?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" id="style_slider_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_slider_button_hover_bg"><?php _e("button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_hover_bg', '#d54900')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_hover_bg', '#d54900')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_hover_bg" value="<?php echo esc_attr(get_option('style_slider_button_hover_bg', '#d54900')); ?>" id="style_slider_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_slider_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_hover_color" value="<?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" id="style_slider_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-5", 'constructo');?></h4>
                    <a class="btn btn-sm style-5" href="#">Button</a>
                </div>
                <div class="input onequarter">
                    <label for="style_style_5_button_bg"><?php _e("button background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_bg" value="<?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" id="style_style_5_button_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_style_5_button_color"><?php _e("button color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_color" value="<?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" id="style_style_5_button_color" />
                </div>  
                <div class="input onequarter">
                    <label for="style_style_5_button_hover_bg"><?php _e("button hover background", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_hover_bg" value="<?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" id="style_style_5_button_hover_bg" />
                </div>  
                <div class="input onequarter">
                    <label for="style_style_5_button_hover_color"><?php _e("button hover color", 'constructo'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_hover_color" value="<?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" id="style_style_5_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
        </div>
        <div class="clear"></div>
        <div class="content-top" style="border-style: solid none">
            <input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>">
            <div class="clear"></div>
        </div>
    </form>
    <div class="clear"></div>    
</div>