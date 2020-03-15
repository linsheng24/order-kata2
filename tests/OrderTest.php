<?php
namespace App;

// use App\Menu;
use App\Order;
use Tests\FakeMenu;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

  protected function setUp():void
  {
    parent::setUp();
    $this->order = new Order(new FakeMenu);
  }

  protected function tearDown():void
  {
    parent::tearDown();
    $this->order = null;
  }

  /**
   * @test
   */
  public function add_Give1PorkBurger()
  {
    //Arrange
    $food = "豬肉漢堡";
    
    $expected = ["豬肉漢堡" => 1];
    //Act
    $this->order->add($food);
    $actual = $this->order->getCount();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function add_Give2PorkBurger()
  {
    //Arrange
    $food = "豬肉漢堡";
    
    $expected = ["豬肉漢堡" => 2];
    //Act
    $this->order->add($food);
    $this->order->add($food);
    $actual = $this->order->getCount();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add1PorkBurger_Return120()
  {
    //Arrange
    $food = "豬肉漢堡";
    $this->order->add($food);
    $expected = 120;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add2PorkBurger_Return240()
  {
    //Arrange
    $food = "豬肉漢堡";
    $this->order->add($food);
    $this->order->add($food);
    $expected = 240;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add1PorkBurgerAnd1BeefBurger_Return280()
  {
    //Arrange
    $food0 = "豬肉漢堡";
    $this->order->add($food0);
    $food1 = "牛肉漢堡";
    $this->order->add($food1);

    $expected = 280;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add2PorkBurgerDiscount_Return180()
  {
    //Arrange
    $food0 = "豬肉漢堡";
    $this->order->add($food0);
    $this->order->add($food0);
    $this->order->discount();

    $expected = 180;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add4PorkBurgerDiscount_Return360()
  {
    //Arrange
    $food0 = "豬肉漢堡";
    $this->order->add($food0);
    $this->order->add($food0);
    $this->order->add($food0);
    $this->order->add($food0);
    $this->order->discount();

    $expected = 360;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add2PorkBurgerAnd2BeefBurgerDiscount_Return440()
  {
    //Arrange
    $food0 = "豬肉漢堡";
    $this->order->add($food0);
    $this->order->add($food0);
    $food1 = "牛肉漢堡";
    $this->order->add($food1);
    $this->order->add($food1);
    $this->order->discount();

    $expected = 440;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

  /**
   * @test
   */
  public function getPrice_Add2PorkBurgerAnd2BeefBurgerDiscountIsMember_Return396()
  {
    //Arrange
    $food0 = "豬肉漢堡";
    $this->order->add($food0);
    $this->order->add($food0);
    $food1 = "牛肉漢堡";
    $this->order->add($food1);
    $this->order->add($food1);
    $this->order->discount();
    $this->order->setMember();

    $expected = 396;
    //Act
    $actual = $this->order->getPrice();
    
    //Assert
    $this->assertEquals($expected, $actual);
  }

}
