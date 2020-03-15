<?php
namespace Tests;

class FakeMenu
{
  public $foods;

  public function __construct()
  {
    $this->foods = [
      (object)["name" => "豬肉漢堡", "price" => 120, "is_burger" => true],
      (object)["name" => "牛肉漢堡", "price" => 160 , "is_burger" => true],
      (object)["name" => "義大利麵", "price" => 130, "is_burger" => false]
    ];
  }
}