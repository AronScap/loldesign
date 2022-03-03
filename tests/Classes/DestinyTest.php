<?php  
namespace App\Classes;

use PHPUnit\Framework\TestCase;

class DestinyTest extends TestCase
{
	public function testGetDestinyName()
	{
		$destiny = new Destiny();
		$this->assertEquals("011",$destiny->getDestinyName(1));
		$this->assertEquals("016",$destiny->getDestinyName(2));
		$this->assertEquals("017",$destiny->getDestinyName(3));
		$this->assertEquals("018",$destiny->getDestinyName(4));

	}

 
}


?>