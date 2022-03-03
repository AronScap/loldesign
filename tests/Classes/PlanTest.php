<?php  
namespace App\Classes;

use PHPUnit\Framework\TestCase;

class PlanTest extends TestCase
{
	public function testGetPlanName()
	{
		$plan = new Plan();
		$this->assertEquals("FaleMais 30",$plan->getPlanName(1)); 
		$this->assertEquals("FaleMais 60",$plan->getPlanName(2)); 
		$this->assertEquals("FaleMais 120",$plan->getPlanName(3)); 

	}

 
}


?>