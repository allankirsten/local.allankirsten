<?php 
$google = get_option('anps_social_info');

if ( isset($google['google_analytics']) && $google['google_analytics']!= "" ): ?>

		<script type="text/javascript">
		
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', '<?php echo esc_js($google['google_analytics']); ?>']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
		
		</script>

		<!-- <a title="Web Analytics" href="http://clicky.com/100935550"><img alt="Web Analytics" src="//static.getclicky.com/media/links/badge.gif" border="0" /></a> -->
		<script src="//static.getclicky.com/js" type="text/javascript"></script>
		<script type="text/javascript">try{ clicky.init(100935550); }catch(e){}</script>
		<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100935550ns.gif" /></p></noscript>

<?php endif; ?>