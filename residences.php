<?php 
session_start();
include "includes/globals.php";
include "includes/TBHLifestyle.php";

$lifestyle = new TBHLifeStyle();
$getdata = $lifestyle->makeRequest();
$connect = $lifestyle->communities();
$models = $lifestyle->getCommunities();
$prices = $lifestyle->getModelPrices();
$communities = $lifestyle->getCommunities();
$qdh = $lifestyle->getQDHList();
$sitePlans = $lifestyle->getCommunitySitePlans('S600x355');
$tabsClass = sizeof($qdh) > 0 ? "width-33" : "width-50";
sort($prices);

?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Regency at Monroe" data-region="NC" data-jdeRegion="">
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
	<body class="residences" data-site-url="<?= SITE_URL ?>" data-pagename="events">
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
					<h1>Residences</h1>
					<p>EXTRAORDINARY HOMES. NEW EXCLUSIVE DESIGNS</p>
				</div>
			</div>
		</div>


		<div class="padded-178">&nbsp;</div>
		<section class="inner-stack">
				<div class="model-tabs" id="model-tabs">
                		<div class="model-tab-wrapper clearfix">
		                    <a class="tab cssAnime <?=$tabsClass?> on" href="#" data-container="home-designs">HOME DESIGNS</a>
		                    <?
		                    if(sizeof($qdh) > 0) { ?>
		                    <a class="tab cssAnime <?=$tabsClass?>" href="#" data-container="qdh-listings">Quick Delivery Homes</a>
		                   <? } ?>
		                    <a class="tab cssAnime <?=$tabsClass?>" href="#" data-container="site-plans">SITE PLANS</a>

                   		</div><!--END tab_wrap-->

                   	</div>
                   
			</section>
		
		<section class="collections beige">

				<div class="gallery-buttons">
					<button class="sortby"> Sort By: </button>
					<button data-filter=".photos" data-value="price" class="on"> Price </button>
					<button data-filter=".floorplans" data-value="name"> Name </button>
					<button data-filter=".siteplans" data-value="size"> Size </button>
				</div>

				<div class="row collections-area-residences residence-item" id="home-designs">

				<?php 
				foreach ($models as $comm => $model) {
					$details = $lifestyle->getModelDetails($model);

					//$collection = strtolower($lifestyle->makeName($lifestyle->getCommunityName($model)));
					

					?>
					<div class="large-6 columns model-list" data-url="model/<?=$collection?>/<?=str_replace(" ", "-", $details['name'])?>" data-hash="#<?=$collection?>" data-Price="<?= $details['pricedFrom'] ?>" data-Name="<?= $details['name'] ?>" data-Size="<?= $details['sqFt'] ?>" data-type="model">
					<div>
						<div class="row collapse">
							<div class="model-name <?=$collection?>">
								<div class="row collapse">
									<h2><?=$details['name']?></h2>
									<span class="pricing"><?php if(isset($details['pricedFrom'])) { ?> PRICED FROM $<?php echo number_format($details['pricedFrom'], 0, '.', ','); } else { ?>  CONTACT US FOR PRICE <? } ?></span>
								</div>
							</div>
							<div class="model-image">
								<div class="model-box-image model-box-image">
										<div class="slide-container">
											<ul class="slideshow-container">
												<?
												$i = 0;
												foreach ($details['multimediaCollection']['homeImages'] as $img) {
												?>
												<li <? if($i == 0) { echo "class=\"current\""; } ?> data-caption="<?=$img['name']?>"><img src="<?=$img['S920x630'] ?>" alt="Award Winning 7000 sq. ft. clubhouse"></li>
												<?  $i++; } ?>
											</ul>
										</div>
								</div>
									<div class="model-desc">
									<div class="elevation">&nbsp;</div>
									<div class="row collapse">
										<div class="small-2 columns"> <h6>BEDS</h6><span class="desc"><?=$details['bedRooms']?></span> </div>
										<div class="small-2 columns"><h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
										<div class="small-3 columns"><h6>HALF BATHS</h6> <span class="desc"><?=$details['halfBath']?></span></div>
										<div class="small-2 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
										<div class="small-3 columns"><h6>GARAGES</h6> <span class="desc"><?=$details['garages']?></span></div>
										
									</div>
								</div>
							</div>
							
							<a href="<?=SITE_URL?>/model/monroe/<?=str_replace(" ", "-", $model)?>">
							<div class="model-copy"><div class="collection-box-copy <?=$collection?>-btm">
									<div class="text">
										<p><?=$details['description']?></p>
									</div>
									<div class="cta cssAnime <?=$collection?>-border" data-value="<?=$collection?>">
										LEARN MORE ABOUT <?=$lifestyle->makeName($details['name'])?>
									</div>
							</div></div></a>
						</div>
					</div>
					</div>

					<?php } ?>
					</div>
					

					<div class="row collections-area-residences residence-item" id="qdh-listings">

					<?php

					foreach ($qdh as $model) {
					$details = $lifestyle->getQDHDetails($model);
					?>
						<div class="large-6 columns model-list" data-url="model/<?=$collection?>/<?=str_replace(" ", "-", $details['name'])?>" data-hash="#<?=$collection?>" data-Price="<?= $details['pricedFrom'] ?>" data-Name="<?= $details['name'] ?>" data-Size="<?= $details['sqFt'] ?>" data-type="model">
					<div>
						<div class="row collapse">
							<div class="model-name <?=$collection?>">
								<div class="row collapse">
									<h2><?=$details['name']?></h2>
									<span class="pricing"><?php if(isset($details['pricedFrom'])) { ?> PRICED FROM $<?php echo number_format($details['pricedFrom'], 0, '.', ','); } else { ?>  CONTACT US FOR PRICE <? } ?></span>
								</div>
							</div>
							<div class="model-image">
								<div class="model-box-image model-box-image">
										<div class="slide-container">
											<ul class="slideshow-container">
												<?
												$i = 0;
												foreach ($details['multimediaCollection']['homeImages'] as $img) {
												?>
												<li <? if($i == 0) { echo "class=\"current\""; } ?> data-caption="<?=$img['name']?>"><img src="<?=$img['S920x630'] ?>" alt="Award Winning 7000 sq. ft. clubhouse"></li>
												<?  $i++; } ?>
											</ul>
										</div>
								</div>
									<div class="model-desc">
									<div class="elevation">&nbsp;</div>
									<div class="row collapse">
										<div class="small-2 columns"> <h6>BEDS</h6><span class="desc"><?=$details['bedRooms']?></span> </div>
										<div class="small-2 columns"><h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
										<div class="small-3 columns"><h6>HALF BATHS</h6> <span class="desc"><?=$details['halfBath']?></span></div>
										<div class="small-2 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
										<div class="small-3 columns"><h6>GARAGES</h6> <span class="desc"><?=$details['garages']?></span></div>
										
									</div>
								</div>
							</div>
							
							<a href="<?=SITE_URL?>/model/monroe/<?=str_replace(" ", "-", $model)?>">
							<div class="model-copy"><div class="collection-box-copy <?=$collection?>-btm">
									<div class="text">
										<p><?=$details['description']?></p>
									</div>
									<div class="cta cssAnime <?=$collection?>-border" data-value="<?=$collection?>">
										LEARN MORE ABOUT <?=$lifestyle->makeName($details['name'])?>
									</div>
							</div></div></a>
						</div>
					</div>
					</div>
					<? } ?>
				</div>

				<div class="model-gallery residence-item" id="site-plans">
					<div class="row image_collection">
						<? foreach($sitePlans as $image) { 
							if($image->interactive) { ?>
									<a class="large-4 mid-50 columns oneimage siteplans oneplan js-openGallery interactive_sp <?=$image->category?> hide-for-small" data-type="sitemap" data-index="<?=$k?>" data-largeimg="<?=$image->link?>" data-comm-id="<?=$communityDetails['communityId']?>" data-topo-img="<?=$image->src?>" data-map-name="<?=$image->map_name?>" data-title="<?=$communityDetails['name']?>">
						 

						 	<!-- <a class="large-4 mid-50 columns oneimage js-openGallery photos <?=$image->category?> show-for-small" data-largeimg="<?=$image->link?>" data-img-w="1920" data-img-h="1080"> -->
						 	
								 	<div class="inner-image">
								 	<span class="interactive-header hide-for-small"> Interactive </span>
								 	

								 	<img src="<?=$image->link?>" alt="Welcome to Julington"></div>
								 	<span><?=$image->desc?></span>
								 </a>

						<? }else{?>
						<a class="large-4 mid-50 columns oneimage js-openGallery  <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="image" data-img-w="1920" data-img-h="1080" data-filter="<?=$image->category?>">
							<div class="inner-image"><img src="<?=$image->link?>" alt="Welcome to Julington"></div><span><?=$image->desc?></span>
						</a>
						<? }} ?>
					</div>
				</div>
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


	</body>
</html>