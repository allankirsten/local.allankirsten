 
  <?php 
  $coming_soon = get_option('coming_soon', '0');
  if((!$coming_soon || $coming_soon=="0") || is_super_admin()) {
    get_sidebar( 'footer' );
  }
  ?>
 
  <?php global $anps_parallax_slug;
  if (count($anps_parallax_slug)>0) : ?>
  <script>
      jQuery(function($) {
          <?php for($i=0;$i<count($anps_parallax_slug);$i++) : ?>
              $("#<?php echo esc_js($anps_parallax_slug[$i]); ?>").parallax("50%", 0.6);
          <?php endfor; ?>
      });
  </script>
  <?php endif;?>
  <?php  if(isset($anps_options_data['preloader']) && $anps_options_data['preloader']=="on") : ?>
  <script>
    jQuery(function ($) {
      $("body").queryLoader2({
        backgroundColor: "#fff",
        barColor: "333",
          barHeight: 0,
        percentage: true,
          onComplete : function() {
            $(".site-wrapper, .colorpicker").css("opacity", "1");
          }
      });
    });
  </script>
  <?php endif; ?>
</div>

<div id="scrolltop" class="fixed scrollup"><a href="#"  title="Scroll to top"><i class="fa fa-angle-up"></i></a></div>
<input type="hidden" id="theme-path" value="<?php echo get_template_directory_uri(); ?>" />
<?php wp_footer(); ?>

<!-- <a title="Web Analytics" href="http://clicky.com/100935550"><img alt="Web Analytics" src="//static.getclicky.com/media/links/badge.gif" border="0" /></a> -->
<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(100935550); }catch(e){}</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100935550ns.gif" /></p></noscript>

</body>
</html>