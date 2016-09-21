<?php 
include "includes/globals.php"; 
?>


<!doctype html>
<html lang="en-US">
	<head data-communityname="" data-region="" data-jdeRegion="">
	    <meta charset="utf-8">
	    <title>Boiler Plate V2.0 - Site Plans</title>
	    <meta name="google-site-verification" content="" />
	    <meta name="description" content="" />
	    <?php include "includes/head_include.php"; ?>
	</head>
	<body class="siteplans" data-site-url="<?= SITE_URL ?>"> 

		<?php include "includes/header.php"; ?>
		<div class="bodydiv">

			<h3> Site Plan Example </h3>


			<div class="page-margins">


				<div class="siteplan_collectiomn">

				<?php

					foreach ( $communityList as $community) {
						foreach ( $community['sitePlans'] as $sitePlan) {

							$isInteractive = !empty($sitePlan['interactive']) ? true : false;
							$map_name = $isInteractive ? $sitePlan['interactive']["map_name"] :  "" ;
							$topo_map = $isInteractive ? $sitePlan['interactive']["src"] : $sitePlan['base']['S1800x815'];
							$description = !empty($sitePlan['base']['description']) ? $sitePlan['base']['description'] :  $community["name"] . " Siteplan";
							$extraClass = $isInteractive ? " interactive_sp" : ""

				?>

					<div class="oneplan js-openSiteplan<?=$extraClass;?>" data-map-name="<?=$map_name;?>" data-largeimg="<?=$topo_map;?>" data-topo-img="<?=$topo_map;?>" data-comm-id="<?=$community['communityId'];?>">
						<figure>
							<img src="<?=$sitePlan['base']['link']; ?>" alt="<?=$description; ?>" />
							<figcaption><?=$description; ?></figcaption>
						</figure>
						<?php if ($isInteractive) { ?>
							<div class="special-callout">Interactive Site Plan</div>
						<?php } ?>
					</div>



				<?php
						}//end of sitePlans loop
					} //end of communityList loop
				?>


				</div> <!-- //siteplan_collectiomn -->

		    </div>

	    </div>

	    <?php include "includes/photoswipe_dom.php"; ?>
		<?php include "includes/footer.php"; ?>



	    <?php include "includes/foot_include.php"; ?>

	    <?
	    	//output the sitepan data in JS, and include the tb.com scripts
	    	$sp = new sitePlans;
	    	$sp->outputJSdata($communityList);
	    ?>


	</body>
</html>