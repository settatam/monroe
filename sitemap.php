<?php 
include "includes/globals.php";
include "includes/TBHLifestyle.php";

$lifestyle = new TBHLifeStyle();
$getdata = $lifestyle->makeRequest();
$connect = $lifestyle->communities();
$communities = $lifestyle->getCommunities();

?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Julington Lakes" data-region="FL" data-jdeRegion="3549">
	    <meta charset="utf-8">
	    <title>Sitemap | Julington Lakes</title>
	    <meta name="google-site-verification" content="Julington Lakes sitemap" />
	    <meta name="description" content="" />
	    <?php include "includes/head_include.php"; ?>
	</head>
	<body class="about contact" data-site-url="<?= SITE_URL ?>"> 

		<?php include "includes/header.php"; ?>

			<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/contact/hero.jpg')">
				<a class="logo" href="<?=SITE_URL?>"></a>
			</div>
		</div>

		<section>
				<div class="intro-header">
					<h2> Sitemap</h2>
				</div>

				<div class="intro-container">
					<div class="text-row">
						<ul>	
							
							<li><a href="<?=SITE_URL?>">Home</a></li>
							<li><a href="<?=SITE_URL?>/lifestyle">Lifestyle</a></li>
							<li><a href="<?=SITE_URL?>/residences">Find A Home</a>
								<ul>
									<?php

									foreach($communities as $collection) { ?>

										<li><a href="<?=SITE_URL?>/residences#<?=$lifestyle->makeArrayKey($collection)?>"><?=$lifestyle->makeName($collection)?> Collection</a></li>

									<? }
									?>

									<li><a href="<?=SITE_URL?>/residences#qdh"> Quick Delivery Homes</li>
								</ul>
							</li>
							<li><a href="<?=SITE_URL?>/amenities">Amenities</a></li>
							<li><a href="<?=SITE_URL?>/directions">Directions</a></li>
							<li><a href="<?=SITE_URL?>/contact">Contact Us</a></li>
							

						</ul>
					</div>
				</div>
		</section>


		<?php include "includes/footer.php"; ?>
	    <?php include "includes/foot_include.php"; ?>

	</body>
</html>