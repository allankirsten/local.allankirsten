<?php 
global $anps_options_data; 
$page_heading_full = get_post_meta(get_queried_object_id(), $key ='anps_page_heading_full', $single = true );
?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php anps_is_responsive(false); ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php anps_theme_styles(); ?>
	<?php anps_theme_after_styles(); ?>
        <?php if(isset($page_heading_full)&&$page_heading_full=="on") { add_action("wp_head", 'anps_page_full_screen_style', 1000); } ?> 
        <?php wp_head(); ?>
    <!-- Facebook -->
    <meta property="og:title" content="Allan Kirsten Portfolio" />
    <meta property="og:site_name" content="Allan Kirsten Portfolio"/>
    <meta property="og:description" content="Seleção de trabalhos de UX/UI design, direção de arte e criação" />
    <meta property="og:url" content="http://www.allankirsten.net" />
    <meta property="og:image" content="http://allankirsten.net/facebook/allankirsten.jpg" />
    <link rel="image_src" href="http://allankirsten.net/facebook/allankirsten.jpg"/ >        
</head>
<body <?php body_class(anps_is_responsive(true) . anps_boxed_or_vertical());?><?php anps_body_style();?>>
    <?php 
    $coming_soon = get_option('coming_soon', '0'); 
    if($coming_soon=="0"||is_super_admin()) : ?> 
	<div class="site-wrapper <?php if(get_option('anps_vc_legacy', "0")=="on") {echo "legacy";} ?>">
            <?php if(isset($page_heading_full)&&$page_heading_full=="on") : ?>
            <?php $heading_value = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true ); ?>
            <div class="paralax-header parallax-window" data-type="background" data-speed="2" style="background-image: url(<?php echo esc_url($heading_value); ?>);">
            

            <?php endif; ?>
    <?php endif; ?>
		<?php anps_get_header(); ?>