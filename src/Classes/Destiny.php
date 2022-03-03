<?php 
namespace App\Classes;

use \App\Classes\DB;

class Destiny
{
	private $codeOrigin;
	function getDestinies(){
    	$database = $this->initDatabase();
    	$query = "SELECT * FROM destiny";
    	$results = [];
    	if($database->num_rows($query) > 0) $results = $database->get_results($query);
    	return $results;
	}

	function getDestinyName($destinyId){
    	$database = $this->initDatabase();
    	$query = " SELECT code FROM destiny WHERE destiny.id = '$destinyId' LIMIT 1";
    	if($database->num_rows($query) > 0) list($code) = $database->get_row($query);
    	else $code = '';
    	return $code;
	}

	protected function initDatabase(){
		return new DB('localhost','root','','aron_loldesign');
	}
}
 ?>