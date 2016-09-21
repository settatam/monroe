    
<!-- DTM -->
<!--<script src="__URL_PROVIDED_FROM_MARKETING_GROUP__"></script>-->

<!-- Optimizely -->
<script src="https://cdn.optimizely.com/js/208922210.js"></script>
    
    
<script type="text/javascript" src="https://cdn.tollbrothers.com/common/js/jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>/js/TweenMax.min.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>/js/3rdparty/isotope.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>/js/3rdparty/photoswipe.min.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>/js/3rdparty/photoswipe-ui-default.min.js"></script>
<script type="text/javascript" src="http://cdn.tollbrothers.com/tb/ws_siteplan/js/toll.ws_site_plan.min.js"></script>

<?php if($buildToggle) { ?>

	<script type="text/javascript" src="/js/scripts.min.js?v=<?=$cacheBusterNumber; ?>"></script>

<?php } else { ?>
	<script type="text/javascript" src="<?= SITE_URL ?>/js/toll.googlemaps.js?v=<?=$cacheBusterNumber?>"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>/js/scripts.js?v=<?=$cacheBusterNumber; ?>"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>/js/slider.js?v=<?=$cacheBusterNumber; ?>"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>/js/siteplans.js?v=<?=$cacheBusterNumber; ?>"></script>
    <script type="text/javascript" src="<?= SITE_URL ?>/js/directions.js?v=<?=$cacheBusterNumber; ?>"></script>
    <script type="text/javascript" src="<?= SITE_URL ?>/js/mediafit.js?v=<?=$cacheBusterNumber; ?>"></script>
<?php } ?>

<!-- passthrough code -->
<script src="https://cdn.tollbrothers.com/common/js/toll/toll.tracklinks-min.js"></script>
<script src="https://go.tollbrothers.com/GenericWebLead/conversion.js"></script>
<!-- end passthrough code -->

<script> 
//load type kit make pages text load better
	try{Typekit.load({ 
		async: true, 
		active: function() {
			$('.pages h1, .text-panel h3, .text-row p, p, nav ul li a, h3, .text-panel h2, .intro-header h3, .text-panel ul, #aboutDiv p').fadeTo(500, 1);
			$('.membership').fadeIn(500);
			var width = $( window ).width();

			if(width > 800) {
				$('li.menu__item a').each(function() {
				$(this).css({'width': $(this).width()-3 + 'px'});
				})
			}

	
			} });
			
			}catch(e)
		{
			alert('not loaded')
		}
</script>

<script type="text/javascript">
// _satellite.pageBottom();
</script>
