<?php 
include_once 'classes/Dummy.php';

if (isset($_GET['save_dummy'])) {
        $dummy->save();
}
?>
<script type="text/javascript"> 
    function dummy () {
        var reply = confirm("WARNING: You have already insert dummy content and by inserting it again, you will have duplicate content.\r\n\We recommend doing this ONLY if something went wrong the first time and you have already cleared the content.");         
        return reply;
    }   
</script>
<form action="themes.php?page=theme_options&sub_page=dummy_content&save_dummy" method="post">
    <div class="content-inner envoo-dummy">
        <h3><?php _e("Insert dummy content: posts, pages, categories", 'constructo'); ?></h3>
        <p><?php _e("Importing demo content is the fastest way to get you started. <br/> Please <strong>install all plugins required by the theme</strong> before importing content. If you already have some content on your site, make a backup just in case.", 'constructo'); ?></p>                   
        
        <div class="clear"></div>
        <div class="input">
            <center>          
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/demoimport_screen.jpg" />
                <div class="demotitle"><h4>Classic demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy1" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/demoimport_screen2.jpg" />
                <div class="demotitle"><h4>Woocommerce demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy2" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="clear"></div>
        <div class="input">
            <center>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/import-extravagant.jpg" />
                <div class="demotitle"><h4>Extravagant demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy3" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo-demo-3/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/import-fullscreen.jpg" />
                <div class="demotitle"><h4>Fullscreen demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy4" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo-demo-4/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="clear"></div>
        <div class="input">
            <center>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/import-limitless.jpg" />
                <div class="demotitle"><h4>Limitless demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy5" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo-demo-2/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="input">
            <center>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/demoinstall_5.jpg" />
                <div class="demotitle"><h4>Vertical menu demo</h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy6" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'constructo'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/constructo-demo-5/" target="_blank">launch demo preview</a>
                </div>
            </center>
        </div>
        <div class="absolute fullscreen importspin">
            <div class="table">
                <div class="table-cell center">
                    <div class="messagebox">
                    <i class="fa fa-cog fa-spin" style="font-size:30px;"></i>
                        <h2><strong>Import might take some time, please be patient</strong></h2>
                        
                    </div> 
                </div>
            </div>
        </div>
        
    </div>
</form>