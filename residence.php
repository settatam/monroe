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
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/home/hero.jpg')">
				<div class="callout"> 
					<h1>Directions</h1>
					<p>Come experience our fun-filled country club lifestyle</p>
				</div>
			</div>
		</div>

	<section class="collections beige">

				<div class="gallery-buttons">
					<button class="sortby"> Sort By: </button>
					<button data-filter=".photos" data-value="price" class="on"> Price </button>
					<button data-filter=".floorplans" data-value="name"> Name </button>
					<button data-filter=".siteplans" data-value="size"> Size </button>
				</div>

				<div class="row collections-area-residences" id="model-listings-wrapper">

				<?php 
				foreach ($models as $comm => $model) {
					$collection_array = explode("_", $comm);
					$collection = $collection_array[0];
					$details = $lifestyle->getModelDetailsComm($model, $collection);

					//$collection = strtolower($lifestyle->makeName($lifestyle->getCommunityName($model)));
					

					?>
					<div class="large-6 columns model-list" data-url="model/<?=$collection?>/<?=str_replace(" ", "-", $details['name'])?>" data-hash="#<?=$collection?>" data-Price="<?= $details['pricedFrom'] ?>" data-Name="<?= $details['name'] ?>" data-Size="<?= $details['sqFt'] ?>" data-type="model">
					<a href="<?=SITE_URL?>/model/<?=$collection?>/<?=str_replace(" ", "-", $model)?>">
						<div class="row collapse">
							<div class="model-image">
								<div class="model-box-image model-box-image" style="background-image:url('<?=$details['multimediaCollection']['homeImages'][0]['S920x630'] ?>');">&nbsp;</div>
							</div>
							<div class="model-name <?=$collection?>">
								<div class="row collapse">
									<div class="large-6 columns"> <h2><?=$details['name']?></h2></div>
									<div class="large-6 columns"> <span class="pricing"><?php if(isset($details['pricedFrom'])) { ?> PRICED FROM $<?php echo number_format($details['pricedFrom'], 0, '.', ','); } else { ?>  CONTACT US FOR PRICE <? } ?></span></div>
								</div>
							</div>
							<div class="model-desc <?=$collection?>-light">
								<div class="row collapse">
									<div class="small-2 columns"> <h6>BEDS</h6><span class="desc"><?=$details['bedRooms']?></span> </div>
									<div class="small-2 columns"><h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
									<div class="small-3 columns"><h6>HALF BATHS</h6> <span class="desc"><?=$details['halfBath']?></span></div>
									<div class="small-2 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
									<div class="small-3 columns"><h6>GARAGES</h6> <span class="desc"><?=$details['garages']?></span></div>
									
								</div>
							</div>
							<div class="model-copy"><div class="collection-box-copy <?=$collection?>-btm">
									<div class="text">
										<p><?=$details['description']?></p>
									</div>
									<div class="cta cssAnime <?=$collection?>-border" data-value="<?=$collection?>">
										LEARN MORE ABOUT <?=$lifestyle->makeName($details['name'])?>
									</div>
							</div></div>
						</div>
					</a>
					</div>

					<?php } ?>
					<?php

					foreach ($qdh as $model) {
					$details = $lifestyle->getQDHDetails($model);
					$collection = strtolower($lifestyle->makeName($lifestyle->getCommunityName($model)));
					?>
						<div class="large-6 columns model-list" data-url="qdh/<?=str_replace(" ", "-", $details['name'])?>" data-hash="#qdh" data-Price="<?= $details['pricedFrom'] ?>" data-Name="<?= $details['name'] ?>" data-Size="<?= $details['sqFt'] ?>" data-type="model">
						<a href="<?=SITE_URL?>/qdh/<?=str_replace(" ", "-", $details['name'])?>">
						<div class="row collapse">
							<div class="model-image">
								<div class="model-box-image pg-bg-container" style="background-image:url('<?=$details['multimediaCollection']['homeImages'][0]['S920x630'] ?>');">&nbsp;</div>
							</div>
							<div class="model-name qdh">
								<div class="row collapse">
									<div class="large-6 columns"> <h2><?=$details['name']?></h2></div>
									<div class="large-6 columns"> <span class="pricing"><?php if(isset($details['pricedFrom'])) { ?> PRICED FROM $<?php echo number_format($details['pricedFrom'], 0, '.', ','); } else { ?>  CONTACT US FOR PRICE <? } ?></span></div>
								</div>
							</div>
							<div class="model-desc qdh-light">
								<div class="row collapse">
									<div class="small-2 columns"> <h6>BEDS</h6><span class="desc"><?=$details['bedRooms']?></span> </div>
									<div class="small-2 columns"><h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
									<div class="small-3 columns"><h6>HALF BATHS</h6> <span class="desc"><?=$details['halfBath']?></span></div>
									<div class="small-2 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
									<div class="small-3 columns"><h6>GARAGES</h6> <span class="desc"><?=$details['garages']?></span></div>
									
								</div>
							</div>
							<div class="model-copy"><div class="collection-box-copy qdh-btm">
									<div class="text">
										<p><?=$details['description']?></p>
									</div>
									<div class="cta qdh-border cssAnime" data-value="qdh">
										EXPLORE <?=$lifestyle->makeName($details['name'])?>
									</div>
							</div></div>
						</div>
					</a>
					</div>
					<? } ?>
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