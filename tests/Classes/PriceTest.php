<?php  
namespace App\Classes;

use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
	public function testCalculateExcedeedMinutesTax()
	{
		$price = new Price();	
		$this->assertEquals(37.4,$price->calculateExcedeedMinutesTax(20,10,1.7));
		$this->assertEquals(167.2,$price->calculateExcedeedMinutesTax(80,10,1.9));
		$this->assertEquals(0,$price->calculateExcedeedMinutesTax(0,10,1.9));

	}


	public function testGetPricePerMinute(){
		$price = new Price();
		$this->assertEquals(1.9,$price->getPricePerMinute(1,2));
		$this->assertEquals(2.9,$price->getPricePerMinute(2,1));
		$this->assertEquals(1.7,$price->getPricePerMinute(1,3));
		$this->assertEquals(2.7,$price->getPricePerMinute(3,1));
		$this->assertEquals(0.9,$price->getPricePerMinute(1,4));
		$this->assertEquals(1.9,$price->getPricePerMinute(4,1));
	}

	public function testGetPriceWithOutFaleMais(){
		$price = new Price();
		$this->assertEquals('$ 38,00',$price->getPriceWithOutFaleMais(1,2,20));
		$this->assertEquals('$ 136,00',$price->getPriceWithOutFaleMais(1,3,80));
		$this->assertEquals('$ 380,00',$price->getPriceWithOutFaleMais(4,1,200));
		$this->assertEquals('-',$price->getPriceWithOutFaleMais(4,3,100));
	}


	public function testGetPriceWithFaleMais(){
		$price = new Price();
		$this->assertEquals('$ 0,00',$price->getPriceWithFaleMais(1,2,20,1));
		$this->assertEquals('$ 37,40',$price->getPriceWithFaleMais(1,3,80,2));
		$this->assertEquals('$ 167,20',$price->getPriceWithFaleMais(4,1,200,3));
		$this->assertEquals('-',$price->getPriceWithFaleMais(4,3,100,1));
	}
}


?>