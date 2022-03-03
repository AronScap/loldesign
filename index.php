<?php 

require __DIR__.'/vendor/autoload.php';
use \App\Classes\Url;

$title = "LOL Design Challenge";
$description = "LOL Design Challenge - Aron Scapinello Selhorst"
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title ?></title>
 
    <meta name="title" content="<?php echo $title ?>">
    <meta name="description" content="<?php echo $description ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $title ?>">
    <meta property="og:description" content="<?php echo $description ?>">
    
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo $title ?>">
    <meta property="twitter:description" content="<?php echo $description ?>">
    
    <link rel="stylesheet" href="<?php echo URL::getBase() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo URL::getBase() ?>assets/css/animate.css" />
    <link rel="stylesheet" href="<?php echo URL::getBase() ?>assets/css/lineicons.css" />
    <link rel="stylesheet" href="<?php echo URL::getBase() ?>assets/css/ud-styles.css" />
  </head>
  <body>
    <header class="ud-header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">
              <button class="navbar-toggler">
                <span class="toggler-icon"> </span>
                <span class="toggler-icon"> </span>
                <span class="toggler-icon"> </span>
              </button>
              <div class="navbar-collapse">
                <ul id="nav" class="navbar-nav mx-auto">
                  <li class="nav-item"><a class="ud-menu-scroll" href="<?php echo URL::getBase() ?>">Home</a></li>
                  <li class="nav-item"><a class="ud-menu-scroll" href="<?php echo URL::getBase() ?>#calculate">Calculate</a></li>
                  <li class="nav-item"><a class="ud-menu-scroll" target="_blank" href="https://www.facebook.com/aron.scapinello.58"><i class="lni lni-facebook-filled"></i></a></li>
                  <li class="nav-item"><a class="ud-menu-scroll" target="_blank" href="https://github.com/AronScap"><i class="lni lni-github"></i></a></li>
                  <li class="nav-item"><a class="ud-menu-scroll" target="_blank" href="https://www.linkedin.com/in/aron-scapinello-selhorst-62b905200/"><i class="lni lni-linkedin-original"></i></a></li>
                </ul>
              </div>
 
            </nav>
          </div>
        </div>
      </div>
    </header>
    <?php
        $modulo = Url::getURL( 0 );
        if( $modulo == null )$modulo = "home";
        if( file_exists( "pages/" . $modulo . ".php" ) ) include "pages/" . $modulo . ".php";
        else include "pages/404.php";
    ?>        
    <footer class="ud-footer wow fadeInUp" data-wow-delay=".15s">
      <div class="ud-footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <ul class="ud-footer-bottom-left">
                <li><a href="<?php echo URL::getBase() ?>">LOL DESIGN</a></li>
                <li><a target="_blank" href="https://www.facebook.com/aron.scapinello.58"><i class="lni lni-facebook-filled"></i></a></li>
                <li><a target="_blank" href="https://github.com/AronScap"><i class="lni lni-github"></i></a></li>
                <li><a target="_blank" href="https://www.linkedin.com/in/aron-scapinello-selhorst-62b905200/"><i class="lni lni-linkedin-original"></i></a></li>
              </ul>
            </div> 
          </div>
        </div>
      </div>
    </footer> 

    <script src="<?php echo URL::getBase() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL::getBase() ?>assets/js/wow.min.js"></script>
    <script src="<?php echo URL::getBase() ?>assets/js/main.js"></script>
    
  </body>
</html>
