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
	<body class="living-here" data-site-url="<?= SITE_URL ?>" data-pagename="living-here">
	<a href="#" id="saleseventtrigger"></a>
		<div style="display: none;">
		    <div id="saleseventcontent">
		        <img src="http://tollbrothers.com/images/salesevent/nse_roadblock_overlay.jpg" usemap="#salesevent" alt="sales event" /><map name="salesevent"><area id="saleseventlink" shape="rect" coords="169,458,346,484" target="_blank" /><area id="closeoverlay" shape="rect" coords="455,15,488,48" /></map>
		    </div>
		</div>

		<?php include "includes/header.php"; ?>

		<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/livinghere/hero.jpg')">
				<div class="callout"> 
					<h1>Living Here</h1>
					<p>So much to do, right here at regency at Monroe</p>
				</div>
			</div>
		</div>

		<section class="inner-stack">
			<article>
				<div class="row collapse ">
					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<p>Toll Brothers Active Living® has perfected the 55 and better community lifestyle. Regency at Monroe is the epitome of what makes active adult living so special: a vibrant social scene, the finest resort-like amenities and luxurious, low-maintenance homes.</p>

							<p>Regency at Monroe is known for its sense of community. As a premier golf and tennis resort with a full-time Lifestyle Director and over 50 community clubs and teams, we’re a unique community where life-long friends choose to move here together, or new neighbors become life-long friends.</p>

							<p>Your new home will be backed by the Toll Brothers guarantee of superior craftsmanship and lasting quality. Leave all the heavy lifting to us and enjoy a country club lifestyle in convenient and picturesque central New Jersey.</p>

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
							<div class="pg-bg-container box-352"> 
							<div class="flex-video" style="height: 325px">
								<video id="video-1" width="1000" height="1000" loop="" autoplay="" data-src="http://www.liveatrobertsonranch.com/images/page-imagery/movie-surfer.mp4" poster="http://www.liveatrobertsonranch.com/images/white-poster.jpg" src="http://www.liveatrobertsonranch.com/images/page-imagery/movie-surfer.mp4" style="margin-top: -1px; margin-left: -5px;">
  								</video>
							</div>
							 </div>
						</div>
					</div>
				</div>

				<div class="padded-178"> &nbsp; </div>

				<div class="row collapse ">
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

					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<h4>CLUBHOUSE</h4>
							<p>As a homeowner at Regency at Monroe, you’ll be part of a vibrant and active community. Most of the activities we offer are held in our impressive 40,000-square-foot clubhouse, which is the hub of our social scene. It offers elegant social functions with a formal ballroom, a 4,500 square foot fitness center, tennis and bocce courts, heated outdoor and indoor pools, spa facilities, library and much more. This is a truly grand ballroom where you, your friends or guests can relax, entertain or just have fun.</p>

						</div>
					</div>
				</div>
			</article>
		</section>

		<div class="padded-178">&nbsp;</div>


		<div class="row">
			<div class="img-panel aerial">
			
			</div>
		</div>

	
	<div class="padded-178">&nbsp;</div>

	<section class="inner-stack no-margin">
			<article>
				<div class="row collapse ">
					<div class="large-6 columns display-copy">
						<div class="page-copy">

							<h4>TENNIS PAVILION</h4>

							<p>Our new 2,000 square foot tennis pavilion features 6 lighted tennis courts with a state-of-the-art cushioned surface.</p>

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

				<div class="padded-178"> &nbsp; </div>

				<div class="row collapse">
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

					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<h4>GOLF</h4>
							<p>A challenging but enjoyable course is right here at Regency at Monroe. Play a round with your friends, or just take in the stunning views of our USGA 9-hole executive golf course designed by Arnold Palmer. Our luxurious community also features a driving range, putting green, and a golf pro shop. Whether you’re a golf enthusiast, or casual golfer, Regency at Monroe makes it easy to spend more time on the golf course.</p>

						</div>
					</div>
				</div>
			</article>
		</section>

	<div class="padded-178"> &nbsp; </div>  

	<div class="row">
		<div class="img-panel golfers">
			
		</div>
	</div>

	<div class="padded-178"> &nbsp; </div>  

	<section class="inner-stack no-margin">
			<article>
				<div class="row collapse ">
					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<h4>Camp Regency</h4>
							<p>Remember summers spent at camp, where every day was full of friends, fun and recreation? Our homeowners have endeared us as “Camp Regency” because just like summer camp, Regency at Monroe is a community with year-round entertainment, luxurious amenities and more than 50 clubs and teams. Whether you’re a Classic Auto enthusiast, an actor or someone who loves photography or water volleyball, there’s a club for you. Or better yet, gather your friends with similar interests and form a new club! We also have a full-time Lifestyle Director who keeps our social calendar full of new outings and activities.</p>

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

				<div class="padded-178"> &nbsp; </div>

				<div class="row collapse">
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

					<div class="large-6 columns display-copy">
						<div class="page-copy">
							<h4>Area Attractions</h4>
							<p>Central New Jersey is not only picturesque, it offers convenience and numerous nearby entertainment options. At Regency at Monroe, our Lifestyle Director organizes outings to nearby New York City and Philadelphia as well as events closer to home, such as productions at the PNC Bank Arts Center. We’re also a very short drive to neighboring New Brunswick and Princeton, NJ, which offer musical performances and theatre in historical settings. </p>

						</div>
					</div>
				</div>
			</article>
		</section>  

	<div class="padded-178"> &nbsp; </div>  

	<div class="row">
		<div class="img-panel aerial-2">
			
		</div>
	</div>
	

	<div class="padded-178"> &nbsp; </div> 


	<section class="lead-thru lead-thru-home gradient">
			<div class="intro-header">
					<h2> Explore Our New Home Designs</h2>
					<h3>Where convenience and tranquility await</h3>
			</div>

			<a class="cta cssAnime" href="<?=SITE_URL?>/lifestyle"> Explore the Homes</a>
	</section>	



		<?php include "includes/footer.php"; ?>

	    <?php include "includes/foot_include.php"; ?>

	</body>
</html>

