<?php 
include "includes/globals.php";
include "includes/TBHLifestyle.php";

$lifestyle = new TBHLifeStyle();
$getdata = $lifestyle->makeRequest();
$connect = $lifestyle->communities();
$communities = $lifestyle->getCommunities();
$model = str_replace("-", " ", $_GET['param2']);
$collection = $_GET['param1'];
$details = $lifestyle->getModelDetails($model);
$modelImages = $lifestyle->getMainModelImages($model, 'S1800x815', $collection);
$allImages = $lifestyle->getAllImages($model, 'S1800x815', $collection);
$communityName = $lifestyle->setCommunityName($collection);
$communityModels = $lifestyle->getCommunityModels($communityName);
$communityDetails = $lifestyle->getCommunityDetails($lifestyle->getCommunityName($model));
$sitePlans = $lifestyle->getCommunitySitePlans('S600x355');
$allModels = array_values($communityModels);

$model_key = array_search($model, $allModels);
$previousModel = $model_key-1 < 0 ? sizeof($allModels)-1:$model_key-1;
$nextModel = $model_key+1 > sizeof($allModels)-1 ? 0 : $model_key+1;

$bedrooms = $details['additionalBedrooms'] > 0 ? $details['bedRooms'] . " - " . ($details['bedRooms'] + $details['additionalBedrooms']) : $details['bedRooms'];
$bathrooms = $details['additionalBath'] > 0 ? $details['fullBath'] . " - " . ($details['fullBath'] + $details['additionalBath']) : $details['fullBath'];
$garages = $details['additionalGarage'] > 0 ? $details['garages'] . " - " . ($details['additionalGarage'] + $details['garages']) : $details['garages'];

?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Julington Lakes" data-region="FL" data-jdeRegion="<?=$communityDetails['jdeNum']?>">
	    <meta charset="utf-8">
	    <title><?=$details['name']?> Design - <?=$lifestyle->makeName($communityName)?> Collection | Julington Lakes</title>
	    <meta name="description" content="The <?=$details['name']?> home design is a part of the <?=$lifestyle->makeName($communityName)?> collection at Julington Lakes. Come explore all that the <?=$details['name']?> home design has to offer." />
	    <?php include "includes/head_include.php"; ?>
	</head>
	<body class="model" data-site-url="<?= SITE_URL ?>" data-pagename="model"> 

		<?php include "includes/header.php"; ?>

		<div class="hero">
				<div class="slide-container">
					<ul class="slideshow-container">
						<?
							$i = 0;
							foreach ($details['multimediaCollection']['homeImages'] as $img) {
									?>
									<li <? if($i == 0) { echo "class=\"current\""; } ?> data-caption="<?=$img['name']?>"><img src="<?=$img['S1920x1080'] ?>" alt="Award Winning 7000 sq. ft. clubhouse"></li>
									<?  $i++; } ?>
					</ul>
				</div>
			
				<div class="callout"> 
					<h1><?=$model?></h1>
					<div class="row">
									<div class="small-3 columns"> <?php if(isset($details['pricedFrom'])) { ?> <h6>PRICED FROM</h6><span class="desc">$<?php echo number_format($details['pricedFrom'], 0, '.', ','); ?> </span> <? } else { ?>  <span class="no-price">CONTACT US FOR PRICE </span> <? } ?></span> </div>
									<div class="small-15 columns"> <h6>BEDS</h6><span class="desc"><?=$bedrooms?></span> </div>
									<div class="small-15 columns"> <h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
									<div class="small-15 columns"> <h6>1/2 BATHS</h6> <span class="desc"><?=$bathrooms?></span></div>
									<div class="small-15 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
									<div class="small-15 columns"> <h6>GARAGES</h6> <span class="desc"><?=$garages?></span></div>
									<div class="small-15 columns"> <h6>STORIES</h6> <span class="desc"><?=$details['stories']?></span></div>
									
						</div>
				</div>
		</div>

		<div class="header-small cssAnime">
			<div class="logo-small"></div>
		</div>



		<section class="collections inner-stack">

			<div class="text-row">


				<div class="row collapse">

					<div class="model-area">
							<ul class="breadcrumb">
								<li><a href="<?= SITE_URL ?>/residences">RESIDENCES</a></li>
								<li> <a href="#" class="current"><?=$model?></a></li>
							</ul>

							<h4>DESCRIPTION</h4>
						<div class="large-7 columns no-padding">
						

							<div class="model-desc">
								
								
								

								<div class="model-copy">
									
									<p><?=$details['description']?></p>
								</div>

								


							</div>
												
						
						</div>
						
						<div class="large-5 columns">
					
						<div class="row collapse model-extra">
								<?php if($lifestyle->getDYOH($details['name'])) { ?>
									<a class="large-6 columns dyoh" href="https://security.tollbrothers.ml-scp.com/FloorPlan/Details/<?=$lifestyle->getDYOH($details['name'])?>?com=<?=$lifestyle->getJDEnumber()?>" target="_blank">Design Your Own <?=$details['name']?></a>

									<? } ?>

									<?php 
									if(is_array($details['QDHList'])) { ?>
									<a class="large-6 columns qdh-available" href="<?=SITE_URL?>/qdh/<?=str_replace(" ", "-", $details['QDHList'][0]['name'])?>">Quick Delivery Home Available</a>
								
								<? } ?>
						</div>
							
					</div>
					</div>

				</div>

			</div>

			</section>

			<section class="beige">

				<div class="section-1600 clearfix"> 

					<h4>FLOOR PLANS</h4>
					
					<?php

						foreach ($allImages as $image) {
							 
							 if($image->category == "floorplans") { 

							 	?>

							 	<a class="large-6 mid-50 columns oneimage js-openGallery  <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="image" data-img-w="1920" data-img-h="1080" data-filter="<?=$image->category?>">
							 		<img src="<?=$image->link?>" alt="Welcome to Julington">
							 	</a>

							<? }} ?>		
				</div>
		
			</section>
		
		<section class="model-gallery clearfix text-row">
			<h4> Media Gallery</h4>
			
			<div class="row image_collection">
				<?php

					$k=1;
					foreach ($allImages as $image) {
						 
						 if($image->category == "photos") { 

						 	?>

						 	<a class="large-4 mid-50 columns oneimage js-openGallery  <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="image" data-img-w="1920" data-img-h="1080" data-filter="<?=$image->category?>">

						 	<div>
						 	<img src="<?=$image->link?>" alt="Welcome to Regency At Monroe"></div>
						 	<span><?=$image->desc?></span>

						 	<? }else if(!$image->interactive && $image->category == "videos"){ ?>

						 		

						 		<a class="large-4 mid-50 columns oneimage js-openGallery <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="video" data-img-w="1920" data-img-h="1080" data-src="https://my.matterport.com/show/?m=<?=$image->src?>">

						 		<div class="inner-image">
						 		<span class="interactive-header hide-for-small"> 3d WalkThrough </span>
						 		<img src="<?=$image->link?>" alt="Welcome to Regency At Monroe"></div>
						 		<span><?=$image->desc?></span>

		

						 	<? }else if($image->interactive){ 
						 	$k++;
						 	?>
						 	<a class="large-4 mid-50 columns oneimage siteplans oneplan js-openGallery interactive_sp <?=$image->category?> hide-for-small" data-type="sitemap" data-index="<?=$k?>" data-largeimg="<?=$image->link?>" data-comm-id="<?=$communityDetails['communityId']?>" data-topo-img="<?=$image->src?>" data-map-name="<?=$image->map_name?>" data-title="<?=$communityDetails['name']?>">
						 

						 	<!-- <a class="large-4 mid-50 columns oneimage js-openGallery photos <?=$image->category?> show-for-small" data-largeimg="<?=$image->link?>" data-img-w="1920" data-img-h="1080"> -->
						 	
						 	<div class="inner-image">
						 	<span class="interactive-header hide-for-small"> Interactive </span>
						 	<img src="<?=$image->link?>" alt="Welcome to Regency At Monroe"></div>
						 	<span><?=$image->desc?></span>
						 	<? } ?>

						 	
						 </a>


				 <? } ?>

				 <?

				 foreach ($allImages as $image) { ?>

				 	<? if($image->interactive) { ?>

				 	<a class="large-4 mid-50 columns js-openGallery siteplans show-for-small" data-largeimg="<?=$image->link?>" data-type="image">
				 		<img src="<?=$image->link?>" alt="Welcome to Julington">
				 		<span><?=$image->desc?></span>
				 	</a>
				 
				 <? } } ?>


			</div>

			<div style="clear: both">
				


			</div>
		</section>



		<section class="beige clearfix model-gallery">
		<h4>Site Plans</h4>
				<div class="model-gallery residence-item">
					<div class="row image_collection">

						<?php 
						foreach ($sitePlans as $key => $image) {
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

		<section class="text-normal more-info">
			<div class="row text-row">
				<div class="large-6 columns">
					
						<h4> Request More Info ABOUT <?=$details['name']?></h4>
				
					<p>To receive more information about the <?=$details['name']?> at Julington Lakes, provide your information to our Online Concierge below or call <a href="tel:844-871-7466" class="more-info">844 871 7466.</a></p>
				</div>
				<div class="large-6 columns">
					<form id="model-inquiry" method="POST" action="https://go.tollbrothers.com/GenericWebLead/processlead" class="c">
						<div class="row clearfix">
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
	</section>

	

		<section class="lead-thru lead-thru-model gradient">
			<div class="text-row">
				<div class="firststeps text-row">
					<a href="https://firststep.tollbrothersinc.com/#/home/0<?=$lifestyle->getJDEnumber()?>" target="_blank">
						<h4>Take the First Step</h4>
						<p> Take the <span>First Step to your Dream Home </span> - please provide your basic information to help us serve you best.</p>
					</a>
					<a href="https://paw.tbimortgage.com/PAWForm/home?state=FL&community=<?=$communityDetails['communityId']?>" target="_blank">
						<h4>Financing Information</h4>
						<p> Learn what it takes to make your dream home a reality – with absolutely no obligation. Complete our online <span>Pre-Application Worksheet.</span></p>
					</a>
				</div>
			</div>

		</section>	
  

		<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. 
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>

		

		<?php include "includes/footer.php"; ?>
		<div class="backup" style="height: 1px; width: 10px; overflow: hidden">

<?php
					foreach ($allImages as $image) {
						 
						 if(!$image->interactive && $image->category != "videos") { 

						 	?>

						 <img src="<?=$image->link?>" data-largeimg="<?=$image->link?>"/>

						 	<? } ?>
					
				 <? } ?>

				 <?

				 foreach ($communityDetails['multimediaCollection']['sitePlans'] as $sp) { ?>

				 	
				 		<img src="<?=$sp['S1800x815']?>" data-largeimg="<?=$sp['S1800x815']?>">
				 	
				 <? } ?>
				 ?>
</div>

	    <?php include "includes/foot_include.php"; ?>


	     <?
	    	//output the sitepan data in JS, and include the tb.com scripts
	    	$sp = new sitePlans;
	    	$sp->outputJSdata($communityList);
	    ?>

	</body>

</html>