<?php 
include "includes/globals.php"; 
?>

<!doctype html>
<html lang="en-US">
	<head data-communityname="Julington Lakes" data-region="FL" data-jdeRegion="3549">
	    <meta charset="utf-8">
	    <title>Privacy | Julington Lakes</title>
	    <meta name="description" content="Julington Lakes privacy" />
	    <?php include "includes/head_include.php"; ?>
	</head>
	<body class="privacy contact" data-site-url="<?= SITE_URL ?>"> 

		<?php include "includes/header.php"; ?>

		<div class="hero">
			<div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/contact/hero.jpg')">
				<a class="logo" href="<?=SITE_URL?>"></a>
			</div>
		</div>

		<section>
				<div class="intro-header">
					<h2> Privacy</h2>
				</div>

				<div class="intro-container">
					<div class="text-row">
						<?=$privacy_data; ?>
					</div>
				</div>
		</section>
		
		<?php include "includes/footer.php"; ?>
	    <?php include "includes/foot_include.php"; ?>

	</body>
</html>