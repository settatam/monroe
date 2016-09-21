<?php 
include "includes/globals.php"; 
?>


<!doctype html>
<html lang="en-US">
    <head data-communityname="Julington Lakes" data-region="FL" data-jdeRegion="3549">
        <meta charset="utf-8">
        <title>Julington Lakes - Page Not Found</title>
        <meta name="description" content="Julington Lakes" />
        <?php include "includes/head_include.php"; ?>
    </head>
    <body class="legal contact" data-site-url="<?= SITE_URL ?>">

    <?php include "includes/header.php"; ?> 

        <div class="hero">
            <div class="pg-bg-container" style="background-image: url('<?=SITE_URL?>/images/contact/hero.jpg')">
                <a class="logo" href="<?=SITE_URL?>"></a>
            </div>
        </div>

        <section>
                <div class="intro-header">
                    <h2> Page Not Found </h2>
                </div>

                <div class="intro-container">
                    <div class="text-row" style="text-align: center">
                        The page you are looking for was not found. Please <a href="<?=SITE_URL?>" style="color: #857451">return home</a> or wait to be redirected.
                    </div>
                </div>
        </section>


        <?php include "includes/footer.php"; ?>
        <?php include "includes/foot_include.php"; ?>

    </body>

      <script>
            $(document).on('ready', function(){
                setTimeout(function() {
                    location.assign('<?=SITE_URL?>');
                }, 5000)
            })
        </script>
</html>