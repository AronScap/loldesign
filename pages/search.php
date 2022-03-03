<?php 
use \App\Classes\Url;
use \App\Classes\DB;
use \App\Classes\Destiny;
use \App\Classes\Origin;
use \App\Classes\Price;
use \App\Classes\Plan;
?>
  <section class="ud-hero" id="home">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="ud-hero-content wow fadeInUp" data-wow-delay=".2s">
            <h1 class="ud-hero-title">RESULT</h1>
            <p class="ud-hero-desc">LOL DESIGN CHALLENGE</p>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php 
 

if (
	isset($_POST['origin'])
	&& !empty($_POST['origin'])
	&& isset($_POST['destiny'])
	&& !empty($_POST['destiny'])
	&& isset($_POST['minutes'])
	&& !empty($_POST['minutes'])
	&& isset($_POST['plan'])
	&& !empty($_POST['plan'])
	) {


	$database = new DB('localhost','root','','aron_loldesign');
	$originCode = $database->escape($_POST['origin']);
	$destinyCode = $database->escape($_POST['destiny']);
	$minutes = $database->escape($_POST['minutes']);
	$plan = $database->escape($_POST['plan']);

	$priceWithOutFaleMaisObject = new Price();
	$priceWithOutFaleMais = $priceWithOutFaleMaisObject->getPriceWithOutFaleMais($originCode,$destinyCode,$minutes);
	$priceWithFaleMais = $priceWithOutFaleMaisObject->getPriceWithFaleMais($originCode,$destinyCode,$minutes,$plan);

	$planObject = new Plan();
	$planName = $planObject->getPlanName($plan);

	$destinyObject = new Destiny();
	$destinyName = $destinyObject->getDestinyName($destinyCode);

	$originObject = new Origin();
	$originName = $originObject->getOriginName($originCode);

	?>

	<section id="pricing" class="ud-pricing">
	    <div class="container">
	      <div class="row">
	        <div class="col-lg-12"><div class="ud-section-title mx-auto text-center"><h3>You selected:</h3></div></div>
	      </div>

      		<div class="row align-items-center justify-content-center">
		        <div class="col-lg-3">
		        	<label>Origin:</label>
		        	<div class="btn btn-secondary" style="cursor: inherit;display: block;"><?php echo $originName ?></div>
		        </div>
		        <div class="col-lg-3">
		        	<label>Destiny:</label>
		        	<div class="btn btn-secondary" style="cursor: inherit;display: block;"><?php echo $destinyName ?></div>
		        </div>
		        <div class="col-lg-3">
		        	<label>Minutes of Call:</label>
		        	<div class="btn btn-secondary" style="cursor: inherit;display: block;"><?php echo $minutes.' minute'; if($minutes!=1)echo "s";  ?></div>
		        </div>
		        <div class="col-lg-3">
		        	<label>Plan:</label>
		        	<div class="btn btn-secondary" style="cursor: inherit;display: block;"><?php echo $planName ?></div>
		        </div>
	      	</div>
	      </div>
	</section>


  <section id="pricing" class="ud-pricing" style="padding-top: 0px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="ud-section-title mx-auto text-center">
            <span>Pricing</span>
            <h2>Our Pricing Plans</h2>
          </div>
        </div>
      </div>

      <div class="row g-0 align-items-center justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-10">
          <div
            class="ud-single-pricing first-item wow fadeInUp"
            data-wow-delay=".15s"
          >
            <span class="ud-popular-tag">WITHOUT FALEMAIS</span>
            <div class="ud-pricing-header"> <h4><?php echo $priceWithOutFaleMais ?></h4></div> 
            <div class="ud-pricing-footer">
              <a href="<?php echo URL::getBase() ?>javascript:void(0)" class="ud-main-btn ud-border-btn">
                Purchase Now
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-10">
          <div
            class="ud-single-pricing active wow fadeInUp"
            data-wow-delay=".1s"
          >
            <span class="ud-popular-tag">WITH FALEMAIS</span>
            <div class="ud-pricing-header"><h4><?php echo $priceWithFaleMais ?></h4></div>
            <div class="ud-pricing-footer">
              <a href="<?php echo URL::getBase() ?>javascript:void(0)" class="ud-main-btn ud-white-btn">
                Purchase Now
              </a>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </section>
 
	<?php

}
else{
	echo "Erro ao pesquisar";
}

?>