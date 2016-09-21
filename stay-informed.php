<?php 
session_start();
include "includes/globals.php";
include "includes/TBHLifestyle.php";

$lifestyle = new TBHLifeStyle();
$getdata = $lifestyle->makeRequest();
$connect = $lifestyle->communities();
//$communities = $lifestyle->getCommunities();
//$prices = $lifestyle->getModelPrices();
//sort($prices);

?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Regency at Monroe" data-region="NC" data-jdeRegion="<?=$lifestyle->getJDEnumber()?>">
	    <meta charset="utf-8">
	    <title> Regency at Monroe - Living Here </title>
	    <meta name="description" content="Welcome to Regency in Monroe. New community in New Jersey. Find your new home today!"/>
	    <?php include "includes/head_include.php"; ?>

	    <?php

	    if(!$_SESSION['loaded']) { ?>

	    	<link type="text/css" rel="stylesheet" href="http://tollbrothers.com/common/css/toll/toll.salesevent.overlay.css" />
		    <script type="text/javascript" src="https://cdn.tollbrothers.com/common/js/jquery/jquery-1.11.3.min.js"></script> 
		    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.3.20.1/jquery.colorbox-min.js"></script>
			<script type="text/javascript" src="http://tollbrothers.com/common/js/toll/toll.salesevent.overlay-min.js"></script>
		    <script type="text/javascript" src="http://tollbrothers.com/common/js/toll/toll.salesevent.overlay-min.js"></script>


	    <? 

	    	$_SESSION['loaded'] = true;
	    }
	    
	    ?>
	    
	</head>
	<body class="directions" data-site-url="<?= SITE_URL ?>" data-pagename="directions">
	<a href="#" id="saleseventtrigger"></a>
		<div style="display: none;">
		    <div id="saleseventcontent">
		        <img src="http://tollbrothers.com/images/salesevent/nse_roadblock_overlay.jpg" usemap="#salesevent" alt="sales event" /><map name="salesevent"><area id="saleseventlink" shape="rect" coords="169,458,346,484" target="_blank" /><area id="closeoverlay" shape="rect" coords="455,15,488,48" /></map>
		    </div>
		</div>

		<?php include "includes/header.php"; ?>

		<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/contact/hero.jpg')">
				<div class="callout"> 
					<h1>Stay Informed</h1>
					<p>READY TO JOIN THE CLUB?</p>
				</div>
			</div>
		</div>

		<section class="inner-stack">
			<article>
				<div class="row collapse ">
					<div class="large-6 columns display-copy">
						<div class="page-copy">
							
							<p>Use our form below to get in touch with our Online Concierge. We’ll get back to you promptly after receiving your request. Or if you have questions about a specific Regency at Monroe home and would like to speak with us, just provide us with the best phone number to reach you, or call 844-834-5263.</p>
							

							<form id="model-inquiry" method="POST" action="https://go.tollbrothers.com/GenericWebLead/processlead" class="c">
								<div class="row collapse clearfix">
									<div class="large-6 columns">
										<div class="form-group">
											<label for="firstname">First Name <span>*</span></label>
											<input type="text" class="form-control required" id="firstname" name="firstname">
										</div>
									</div>

									<div class="large-6 columns">
										<div class="form-group">
											<label for="lastname">Last Name <span>*</span></label>
											<input type="text" class="form-control required" id="lastname" name="lastname">
										</div>
									</div>

									<div class="large-6 columns">
										<div class="form-group">
											<label for="email">Email <span>*</span></label>
											<input type="text" class="form-control required" id="email" name="email">
										</div>
									</div>

									<div class="large-6 columns">
										<div class="form-group">
											<label for="phone">Phone</label>
											<input type="text" class="form-control" name="homephone" id="phone">
										</div>
									</div>
							</div>

						<input name="formname" type="hidden" value="JLS01" />
						<input name="comm_num" type="hidden" value="<?=$communityDetails['communityId']?>" />
						<input type="hidden" name="comments" value="Interested in: <?=$details['name']?> ">
						<div class="button-row">
							<button class="cta" type="submit">GET MORE INFO</button>

							<span class="privacy"><a href="<?=SITE_URL?>/privacy">We respect your privacy</a></span>
						</div>
							
					</form>

						</div>

						
					</div>
					
					<div class="large-6 columns display-image">
						<div class="row collapse">
							<div class="large-6 columns">
								<div class="pg-bg-container box-260" style="background-image: url('<?=SITE_URL?>/images/home/regency-1.jpg');"> </div>
							</div>
							<div class="large-6 columns">
								<div class="pg-bg-container box-260" style="background-image: url('<?=SITE_URL?>/images/home/regency-2.jpg');"> </div>
							</div>
						</div>

						<div class="row collapse">
							<div class="pg-bg-container box-352" style="background-image: url('<?=SITE_URL?>/images/home/regency-2.jpg');"> </div>
						</div>
					</div>
				</div>

			</article>
		</section>

		<div class="padded-178">&nbsp;</div>


	<section class="lead-thru lead-thru-home gradient">
			<div class="intro-header">
					<h2>Stay Informed</h2>
					<h3>Where convenience and tranquility await</h3>
			</div>

			<a class="cta cssAnime" href="<?=SITE_URL?>/lifestyle"> Explore the Homes</a>
	</section>	



		<?php include "includes/footer.php"; ?>

	    <?php include "includes/foot_include.php"; ?>

	    <script type="text/javascript">
    	mapData = {
	        "long" : -74.394822,
	        "lat" : 40.319473,
	        "markerTitle" : "Regency at Monroe",
	        "markerImage" : {
	            "src" : "//www.tollbrothers.com/tb/images/maps/red_dotlrg.png",
	            "width" : 28, 
	            "height" : 37,
	            "anchorx" : 14,
	            "anchory" : 37
        }
    };
</script>

	</body>
</html>