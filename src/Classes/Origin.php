<?php 
namespace App\Classes;

use \App\Classes\DB;

class Origin
{
	private $codeOrigin;
	function getOrigins(){
    	$database = $this->initDatabase();
    	$query = "SELECT * FROM origin ";
    	$results = [];
    	if($database->num_rows($query) > 0) $results = $database->get_results($query);
    	return $results;
	}

	
	function getOriginName($originId){
    	$database = $this->initDatabase();
    	$query = " SELECT code FROM origin WHERE origin.id = '$originId' LIMIT 1";
    	if($database->num_rows($query) > 0) list($code) = $database->get_row($query);
    	else $code = '';
    	return $code;
	}

	protected function initDatabase(){
		return new DB('localhost','root','','aron_loldesign');
	}

}
 ?>