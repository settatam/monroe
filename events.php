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
	<body class="events" data-site-url="<?= SITE_URL ?>" data-pagename="events">
	<a href="#" id="saleseventtrigger"></a>
		<div style="display: none;">
		    <div id="saleseventcontent">
		        <img src="http://tollbrothers.com/images/salesevent/nse_roadblock_overlay.jpg" usemap="#salesevent" alt="sales event" /><map name="salesevent"><area id="saleseventlink" shape="rect" coords="169,458,346,484" target="_blank" /><area id="closeoverlay" shape="rect" coords="455,15,488,48" /></map>
		    </div>
		</div>

		<?php include "includes/header.php"; ?>

		<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/events/hero.jpg')">
				<div class="callout"> 
					<h1>Events</h1>
					<p>Lorem ipsum dolor sit amet</p>
				</div>
			</div>
		</div>


		<div class="padded-178">&nbsp;</div>
		<section class="inner-stack clearfix">
			<div class="events-wrapper">
				<div class="clearfix">
					<div class="event-date">
						<div class="date-wrapper"><span class="month">MAY</span> <span class="day">24</span></div>
					</div>
					<div class="event-details">
						<h4>Blood Drawing</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis efficitur placerat nisl, maximus laoreet purus rhoncus vitae. Suspendisse potenti. Integer nunc elit, laoreet sed orci aliquam, luctus sodales mi. Fusce lacinia eros lacus, a fringilla tortor laoreet nec. Integer dictum maximus dapibus. Mauris nec dictum orci. Donec imperdiet leo vel dictum tincidunt. Etiam vitae ullamcorper enim, porttitor laoreet ante.</p>
						<a href="#"> VIEW MORE EVENTS </a>
					</div>
				</div>
				<div class="padded-178"></div>
				<div class="clearfix">
					<div class="event-date">
						<div class="date-wrapper"><span class="month">MAY</span> <span class="day">24</span></div>
					</div>
					<div class="event-details">
						<h4>Blood Drawing</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis efficitur placerat nisl, maximus laoreet purus rhoncus vitae. Suspendisse potenti. Integer nunc elit, laoreet sed orci aliquam, luctus sodales mi. Fusce lacinia eros lacus, a fringilla tortor laoreet nec. Integer dictum maximus dapibus. Mauris nec dictum orci. Donec imperdiet leo vel dictum tincidunt. Etiam vitae ullamcorper enim, porttitor laoreet ante.</p>
						<a href="#"> VIEW MORE EVENTS </a>
					</div>
				</div>
				<div class="padded-178"></div>
				<div class="clearfix">
					<div class="event-date">
						<div class="date-wrapper"><span class="month">MAY</span> <span class="day">24</span></div>
					</div>
					<div class="event-details">
						<h4>Blood Drawing</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis efficitur placerat nisl, maximus laoreet purus rhoncus vitae. Suspendisse potenti. Integer nunc elit, laoreet sed orci aliquam, luctus sodales mi. Fusce lacinia eros lacus, a fringilla tortor laoreet nec. Integer dictum maximus dapibus. Mauris nec dictum orci. Donec imperdiet leo vel dictum tincidunt. Etiam vitae ullamcorper enim, porttitor laoreet ante.</p>
						<a href="#"> VIEW MORE EVENTS </a>
					</div>
				</div>
				<div class="padded-178"></div>
			</div>
			
		</section>
		


	<section class="lead-thru lead-thru-home gradient">
			<div class="intro-header">
					<h2>Stay Informed</h2>
					<h3>Where convenience and tranquility await</h3>
			</div>

			<a class="cta cssAnime" href="<?=SITE_URL?>/lifestyle"> Explore the Homes</a>
	</section>	



		<?php include "includes/footer.php"; ?>

	    <?php include "includes/foot_include.php"; ?>


	</body>
</html>