<?php  
namespace App\Classes;

use PHPUnit\Framework\TestCase;

class OriginTest extends TestCase
{
	public function testGetoriginName()
	{
		$origin = new Origin();
		$this->assertEquals("011",$origin->getOriginName(1));
		$this->assertEquals("016",$origin->getOriginName(2));
		$this->assertEquals("017",$origin->getOriginName(3));
		$this->assertEquals("018",$origin->getOriginName(4));

	}

 
}


?>