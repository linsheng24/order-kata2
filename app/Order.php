<?php
namespace App;

use App\Menu;

class Order
{
  private $menu;
  private $count = [];
  private $discount_price = 0;
  private $isMember = false;

  public function __construct($menu)
  {
    $this->menu = $menu->foods;
  }

  public function add($name)
  {
    $this->count[$name] = isset($this->count[$name]) ? $this->count[$name] + 1 : 1;
  }

  public function getCount()
  {
    return $this->count;
  }

  private function foodCount($name)
  {
    return isset($this->count[$name]) ? $this->count[$name] : 0;
  }

  public function getPrice()
  {
    $total = array_reduce($this->menu, function ($carry, $item) {
      return $carry += $this->foodCount($item->name) * $item->price;
    }) - $this->discount_price;

    return $this->isMember ? floor(0.9 * $total) : $total;
  }

  public function discount()
  {
    $discount_num = floor(array_reduce($this->menu, function ($carry, $item) { 
      return $carry + $this->foodCount($item->name);
    }) / 2);

    $pork_price = array_values(array_filter($this->menu, function ($item) {
      return $item->name == "豬肉漢堡";
    }))[0]->price;
    
    $beef_price = array_values(array_filter($this->menu, function ($item) {
      return $item->name == "牛肉漢堡";
    }))[0]->price;

    if ($discount_num < $this->foodCount("豬肉漢堡")) {
      $this->discount_price = $pork_price / 2 * $discount_num;
    } else {
      $this->discount_price = $pork_price / 2 * $this->foodCount("豬肉漢堡") + $beef_price / 2 * ($discount_num - $this->foodCount("豬肉漢堡"));
    }
  }

  public function setMember()
  {
    $this->isMember = true;
  }

}

