<?php 
include "includes/globals.php";
include "includes/TBHLifestyle.php";

$lifestyle = new TBHLifeStyle();
$getdata = $lifestyle->makeRequest();
$connect = $lifestyle->communities();
$communities = $lifestyle->getCommunities();
$model = $_GET['param2'];
$collection = $_GET['param1'];

$model = $lifestyle->getQDHModel(str_replace("-", " ", $collection));
$details = $lifestyle->getQDHDetails(str_replace("-", " ", $collection));

$modelImages = $lifestyle->getMainModelImages($model, 'S1800x815');
$communityDetails = $lifestyle->getCommunityDetails($lifestyle->getCommunityName($model));

$communityName = $lifestyle->getCommunityName($model);
$allImages = $lifestyle->getAllImagesQDH($model, 'S1800x815', $communityName, true, $details['name']);
$communityModels = $lifestyle->getCommunityModels($communityName);
$communityDetails = $lifestyle->getCommunityDetails($lifestyle->getCommunityName($model));
$allModels = array_values($communityModels);

$model_key = array_search($model, $allModels);
$previousModel = $model_key-1 < 0 ? sizeof($allModels)-1:$model_key-1;
$nextModel = $model_key+1 > sizeof($allModels)-1 ? 0 : $model_key+1;



?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Julington Lakes" data-region="FL" data-jdeRegion="<?=$lifestyle->getJDEnumber()?>">
	    <meta charset="utf-8">
	    <title><?=$details['name']?> - Quick Delivery Home | Julington Lakes</title>
	    <meta name="description" content="With a quick delivery home, you can have your dream home at Julington Lakes without the wait. Learn more about the <?=$details['name']?> today." />
	    <?php include "includes/head_include.php"; ?>
	</head>
	<body class="model" data-site-url="<?= SITE_URL ?>" data-pagename="model"> 

		<?php include "includes/header.php"; ?>

		<div class="hero hide-for-small">
			<div class="pg-bg-container main-image" style="background-image: url('<?=$details['multimediaCollection']['homeImages'][0]['S1920x1080']?>')">
				<a class="logo" href="<?=SITE_URL?>"></a>
					<div class="h1-container">
						<h1>Quick Delivery Home</h1>
					</div>
			</div>
		</div>

		<div class="header-small cssAnime">
			<div class="logo-small"></div>
		</div>



		<section class="collections beige-overlay">



				<div class="row collapse">

					<div class="model-area qdh-model">

					<div class="color-strip heritage"></div>

						<div class="large-6 columns">
							<ul class="breadcrumb">
								<li><a href="<?= SITE_URL ?>/residences">FIND A HOME</a></li>
								<li><a href="<?= SITE_URL ?>/residences#qdh">Quick Delivery Home</a></li>
								<li> <a href="#" class="current"><?=$details['name']?></a></li>
							</ul>

							<div class="model-image pg-bg-container" style="background-image: url('<?=$details['multimediaCollection']['homeImages'][0]['S1920x1080']?>')"></div>						
						
						</div>
						
						<div class="large-6 columns">
						<header>
							<h3>QUICK DELIVERY HOME</h3>
							<h2><?=$details['name']?></h2>
						</header>
						
							<div class="model-desc">
								
								
								<div class="row collapse">
									<div class="small-2 columns"> <h6>PRICED FROM</h6><span class="desc">$<?php echo number_format($details['pricedFrom'], 0, '.', ',');?></span> </div>
									<div class="small-2 columns"> <h6>BEDS</h6><span class="desc"><?=$details['bedRooms']?></span> </div>
									<div class="small-2 columns"> <h6>BATHS</h6><span class="desc"><?=$details['fullBath']?></span> </div>
									<div class="small-2 columns"> <h6>HALF BATHS</h6> <span class="desc"><?=$details['halfBath']?></span></div>
									<div class="small-2 columns"> <h6>SQ. FT.</h6><span class="desc"><?=$details['sqFt']?></span></div>
									<div class="small-2 columns"> <h6>GARAGES</h6> <span class="desc"><?=$details['garages']?></span></div>
									
								</div>

								<div class="model-copy">
									<p><?=$details['description']?></p>
								</div>

								<p class="extra"> <span>Move In: </span> <?=date("m/Y", strtotime($details['dateMove']))?></p>
								<p class="extra"> <span>Address: </span> <?=$details['address']?></p>
								<p class="extra"> <span>Home Site No.</span> <?=$details['lotNumber']?></p>

							</div>
						</div>
					</div>

				</div>
		</section>
		<section class="model-gallery">
			<h1> Media Gallery</h1>
			<div class="gallery-buttons">
				<button data-filter="*" class="on"> All </button> 
				<button data-filter=".photos"> Photos </button>
				<button data-filter=".floorplans"> Floor Plans </button>
				<button data-filter=".sitemaps"> Sitemaps </button>
			</div>
			<div class="row image_collection">
				<?php

					$k=1;
					foreach ($allImages as $image) {
						 
						 if(!$image->interactive && $image->category != "videos") { 

						 	?>

						 	<a class="large-4 mid-50 columns oneimage js-openGallery  <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="image" data-img-w="1920" data-img-h="1080" data-filter="<?=$image->category?>">

						 	<div>

						 	<? }else if(!$image->interactive && $image->category == "videos"){ ?>

						 		

						 		<a class="large-4 mid-50 columns oneimage js-openGallery <?=$image->category?>" data-largeimg="<?=$image->link?>" data-type="video" data-img-w="1920" data-img-h="1080" data-src="https://my.matterport.com/show/?m=<?=$image->src?>">

						 		<div class="inner-image">
						 		<span class="interactive-header hide-for-small"> 3d WalkThrough </span>

		

						 	<? }else if($image->interactive){ 
						 	$k++;
						 	?>
						 	<a class="large-4 mid-50 columns oneimage siteplans oneplan js-openGallery interactive_sp <?=$image->category?> hide-for-small" data-type="sitemap" data-index="<?=$k?>" data-largeimg="<?=$image->link?>" data-comm-id="<?=$communityDetails['communityId']?>" data-topo-img="<?=$image->src?>" data-map-name="<?=$image->map_name?>" data-title="<?=$communityDetails['name']?>">
						 

						 	<!-- <a class="large-4 mid-50 columns oneimage js-openGallery photos <?=$image->category?> show-for-small" data-largeimg="<?=$image->link?>" data-img-w="1920" data-img-h="1080"> -->
						 	
						 	<div class="inner-image">
						 	<span class="interactive-header hide-for-small"> Interactive </span>
						 	<? } ?>

						 	<img src="<?=$image->link?>" alt="Welcome to Julington"></div>
						 	<span><?=$image->desc?></span>
						 </a>


				 <? } ?>

				 <?

				 foreach ($allImages as $image) { ?>

				 	<? if($image->interactive) { ?>

				 	<a class="large-4 mid-50 columns oneimage js-openGallery siteplans show-for-small" data-largeimg="<?=$image->link?>" data-type="image">
				 		<img src="<?=$image->link?>" alt="Welcome to Julington">
				 		<span><?=$image->desc?></span>
				 	</a>
				 
				 <? } } ?>


			</div>

			<div style="clear: both">
				


			</div>
		</section>

		<section class="beige text-normal">
			<div class="intro-header">
					<h2> Request More Info</h2>
					<h3>ABOUT <?=$details['name']?></h3>
			</div>
				<div class="text-row">
				<p>To receive more information about the <?=$details['name']?> at Julington Lakes, provide your information to our Online Concierge below or call  <a href="tel:844-871-7466" class="more-info">844 871 7466.</a></p>
					<form id="model-inquiry" method="POST" target="_blank" action="https://go.tollbrothers.com/GenericWebLead/processlead" class="c">
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
									<input type="text" class="form-control" name="phone" id="phone">
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
	</section>

	<div class="firststeps">
		<a href="https://firststep.tollbrothersinc.com/#/home/0<?=$lifestyle->getJDEnumber()?>" target="_blank">
			<h2>Take the First Step</h2>
			<p> Take the <span>First Step to your Dream Home </span> - please provide your basic information to help us serve you best.</p>
		</a>
		<a href="https://paw.tbimortgage.com/PAWForm/home?state=FL&community=<?=$communityDetails['communityId']?>" target="_blank">
			<h2>Financing Information</h2>
			<p> Learn what it takes to make your dream home a reality – with absolutely no obligation. Complete our online <span>Pre-Application Worksheet.</span></p>
		</a>
	</div>

		<section>

			<div class="lead-thru-model pg-bg-container">

				<div class="large-4 columns"> 
					<div class="inner-lead"><a class="lead-thru-cta" href="<?=SITE_URL?>/model/<?=strtolower($lifestyle->makeName($communityName))?>/<?=$allModels[$previousModel]?>"> VIEW <?=$allModels[$previousModel]?> </a></div>
				</div>
				<div class="large-4 columns"> 
					<h2> View Our Other <br> Home Designs</h2>
				</div>
				<div class="large-4 columns"> 
					<div class="inner-lead"> <a class="lead-thru-cta" href="<?=SITE_URL?>/model/<?=strtolower($lifestyle->makeName($communityName))?>/<?=$allModels[$nextModel]?>"> VIEW <?=$allModels[$nextModel]?> </a></div>
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

	    <?php include "includes/foot_include.php"; ?>

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

	     <?
	    	//output the sitepan data in JS, and include the tb.com scripts
	    	$sp = new sitePlans;
	    	$sp->outputJSdata($communityList);
	    ?>

	</body>

</html>