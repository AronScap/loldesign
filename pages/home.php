<?php  


use \App\Classes\Origin;
$origins_ = new Origin();
$originsList = $origins_->getOrigins();

use \App\Classes\Destiny;
$destinies_ = new Destiny();
$destiniesList = $destinies_->getDestinies();

use \App\Classes\Plan;
$plans_ = new Plan();
$plansList = $plans_->getPlans();

?>

<section class="ud-hero" id="home">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="ud-hero-content wow fadeInUp" data-wow-delay=".2s">
          <h1 class="ud-hero-title">LOL DESIGN CHALLENGE</h1>
          <p class="ud-hero-desc">ARON SCAPINELLO SELHORST</p>
          <ul class="ud-hero-buttons"><li><a href="#calculate" class="ud-main-btn ud-white-btn">Go <i class="lni lni-arrow-down"></i></a></li></ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="calculate" class="ud-features">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="ud-section-title">
          <span></span>
          <h2>FaleMais Telzir</h2>
          <div>Type your origin and destiny, select your plan and enjoy the new FaleMais</div>
        </div>
      </div>
    </div>
    <form action="search" method="post">
      <div class="row">
        <div class="form-group col-lg-3">
          <label>Number Origin:</label>
          <select class="form-control" name="origin" required >
            <option value="">Select an option</option>
            <?php foreach ($originsList as $originValue): ?>
              <option value="<?php echo $originValue['id'] ?>"><?php echo $originValue['code'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group col-lg-3">
          <label>Number Destiny:</label>
          <select class="form-control" name="destiny" required >
            <option value="">Select an option</option>
            <?php foreach ($destiniesList as $destinyValue): ?>
              <option value="<?php echo $destinyValue['id'] ?>"><?php echo $destinyValue['code'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group col-lg-3">
          <label>Minutes of Call:</label>
          <input class="form-control" type="number" name="minutes" min="0" required placeholder="0" />
        </div>
        <div class="form-group col-lg-3">
          <label>Plan FaleMais:</label>
          <select class="form-control" name="plan" required >
            <option value="">Select an option</option>
            <?php foreach ($plansList as $planValue): ?>
              <option value="<?php echo $planValue['id'] ?>"><?php echo $planValue['name'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group col-lg-3">
          <label></label>
          <input class="form-control btn btn-primary" type="submit" value="Calculate" />
        </div>
      </div>
    </form>
  </div>
</section>


