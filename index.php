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
	    <title> Regency at Monroe</title>
	    <meta name="google-site-verification" content="08okVkqg3-GBaHMKxiB9UybI9tNwI6NJMkUoWYZ7fj4" />
	    <meta name="description" content="Julington Lakes is an exciting new luxury home community with award-winning new homes for sale in St. Johns County, Florida. Find your new home today!"/>
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
	<body class="home" data-site-url="<?= SITE_URL ?>" data-pagename="home"> 
	<a href="#" id="saleseventtrigger"></a>
		<div style="display: none;">
		    <div id="saleseventcontent">
		        <img src="http://tollbrothers.com/images/salesevent/nse_roadblock_overlay.jpg" usemap="#salesevent" alt="sales event" /><map name="salesevent"><area id="saleseventlink" shape="rect" coords="169,458,346,484" target="_blank" /><area id="closeoverlay" shape="rect" coords="455,15,488,48" /></map>
		    </div>
		</div>

		<?php include "includes/header.php"; ?>

		<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/home/hero.jpg')">
				<div class="callout"> 
					<h1>Regency at Monroe</h1>
					<p>Be part of something truly special</p>
				</div>
			</div>
		</div>

		<section class="inner-stack">
			<article>
				<div class="row collapse ">
					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<p>Welcome to Regency at Monroe by Toll Brothers Active Living®. We’re an active adult community in Monroe Township, New Jersey where luxurious homes, resort-style amenities and low-maintenance living create an exclusive country club lifestyle. We’re proud of our reputation as a vibrant, active community. And you’ll be proud to be part of it.</p>

							<p>Regency at Monroe is the only new home active-adult community in Central New Jersey with a USGA 9-hole golf course, 40,000 square foot community clubhouse, and luxury homes with personalized options.</p>

							<p>As one of the largest active adult communities in the region, every day offers a new adventure, without ever leaving our gated community. Spend your time doing the things you love while we take care of lawn care and snow removal. </p>

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


		<div class="row">
			<div class="img-panel margin-200">
			<div class="callout-general"> 
					<h2>Discover</h2>
					<h3> OUR HOMES </h3>
					<p>Enjoy a resort-style country club lifestyle with fabulous amenities, including a 40,000 square foot clubhouse with state-of-the-art fitness center, tennis, swimming, and a 9-hole Arnold Palmer-designed executive golf course.</p>
				</div>
			
			</div>
		</div>

	
	<div class="padded-178">&nbsp;</div>
	<section class="lead-thru lead-thru-home gradient">
			<div class="intro-header">
					<h2> Stay Informed</h2>
					<h3>Where convenience and tranquility await</h3>
			</div>

			<a class="cta cssAnime" href="<?=SITE_URL?>/lifestyle"> Get More Information</a>
		</section>	    

		<?php include "includes/footer.php"; ?>

	    <?php include "includes/foot_include.php"; ?>

	</body>
</html>