<?php
include_once 'classes/Options.php';

$anps_social_data = $options->get_social();
if (isset($_GET['save_social']))
  $options->save_social(); 
?>
<form action="themes.php?page=theme_options&sub_page=options_social_accounts&save_social" method="post">   
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <!-- Social accounts data -->
        <h3><?php _e("Analytics:", 'constructo'); ?></h3>

        <p><?php _e("Here you can set up google analytics account.", 'constructo'); ?></p>
        <!-- Google analytics -->
        <div class="input fullwidth">
            <label for="google_analytics">Google analytics</label>
            <input type="text" name="google_analytics" value="<?php echo esc_attr($anps_social_data['google_analytics']); ?>" />
        </div>

    </div>

    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php _e("Save all changes", 'constructo'); ?>">
        <div class="clear"></div>
    </div>
</form>