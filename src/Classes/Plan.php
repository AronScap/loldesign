<?php 
namespace App\Classes;
class Plan
{
	private $name;
	private $minutes;

	function getPlans(){
    	$database = $this->initDatabase();
    	$query = " SELECT * FROM plans ";
    	$results = [];
    	if($database->num_rows($query) > 0) $results = $database->get_results($query);
    	return $results;
	}

	function getPlanName($planId){
    	$database = $this->initDatabase();
    	$query = " SELECT name FROM plans WHERE plans.id = '$planId' LIMIT 1";
    	if($database->num_rows($query) > 0) list($name) = $database->get_row($query);
    	else $name = '';
    	return $name;
	}
	function getPlanMinutesLimit($planId){
    	$database = $this->initDatabase();
    	$query = " SELECT minutes FROM plans WHERE plans.id = '$planId' LIMIT 1";
    	if($database->num_rows($query) > 0) list($minutes) = $database->get_row($query);
    	else $minutes = '';
    	return $minutes;
	}

	protected function initDatabase(){
		return new DB('localhost','root','','aron_loldesign');
	}

}
?>