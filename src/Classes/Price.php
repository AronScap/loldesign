<?php 
namespace App\Classes;

use \App\Classes\DB;
use \App\Classes\Origin;
use \App\Classes\Plan;
class Price
{	 
	function getPriceWithOutFaleMais($originId,$destinyId,$minutes){
		if ($originId != '' 
			&& $destinyId != ''
			&& $minutes != ''
		) {
			$priceperminute = $this->getPricePerMinute($originId,$destinyId);

	    	if($priceperminute != '')$results = '$ '.number_format( ($minutes * $priceperminute),2,',','.' );
	    	else $results = '-';


	    	return $results;
		}
		else return "-";
	}
	function getPriceWithFaleMais($originId,$destinyId,$minutes,$planId){
		if ($originId != ''
			&& $destinyId != ''
			&& $minutes != ''
		) {
	    	$planCalculate = new Plan();
	    	$minutesLimitByPlan = $planCalculate->getPlanMinutesLimit($planId);
	    	if($minutes <= $minutesLimitByPlan)$results = '$ 0,00';
	    	else{
	    		$minutesExcedeed = $minutes - $minutesLimitByPlan;
				$priceperminute = $this->getPricePerMinute($originId,$destinyId);
		    	if($priceperminute != ''){
		    		$results = '$ '.number_format( $this->calculateExcedeedMinutesTax($minutesExcedeed,10,$priceperminute),2,',','.' );
		    	}
		    	else $results = '-';
	    	}
	    	return $results;
		}
		else return "-";
	}

	function calculateExcedeedMinutesTax($minutesExcedeed,$percentOfTax,$priceperminute){
		$percent = 1+($percentOfTax/100);
		return (($priceperminute*$percent)*$minutesExcedeed);
	}

	protected function initDatabase(){
		return new DB('localhost','root','','aron_loldesign');
	}
	function getPricePerMinute($originId,$destinyId){
		$database = $this->initDatabase();
    	$query = "SELECT prices.priceperminute FROM prices WHERE prices.originID = '$originId' AND prices.destinyID = '$destinyId' LIMIT 1 ";
    	if($database->num_rows($query) > 0) list($priceperminute) = $database->get_row($query);
    	else $priceperminute = '';

    	return $priceperminute;
	}
}


?>