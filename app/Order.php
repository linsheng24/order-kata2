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
    $burgers = array_values(array_filter($this->menu, function ($item) { 
      return $item->is_burger == true;
    }));

    usort($burgers,function ($a, $b) {
      return $a->price > $b->price;
    });

    $discount_num = floor(array_reduce($burgers, function ($carry, $item) {
      return $carry + $this->foodCount($item->name);
    }) / 2);

    foreach($burgers as $value) {  
    
      if ($discount_num > 0) {
        if ($discount_num < $this->foodCount($value->name)) {
          $this->discount_price += ($discount_num * $value->price / 2);
        } else {
          $this->discount_price += ($this->foodCount($value->name) * $value->price / 2);
        }
      }
      
      $discount_num -= $this->foodCount($value->name);
    } 

  }

  public function setMember()
  {
    $this->isMember = true;
  }

}

