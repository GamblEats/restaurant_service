<?php

namespace App\Tests\Document;

use App\Document\Item;
use App\Document\Menu;
use App\Document\Restaurant;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function testMenuSettersAndGetters()
    {
        $menu = new Menu();
        $restaurant = new Restaurant();
        $item = new Item();
        $itemObject = [
          $item->getId() => true
        ];

        $menu->setId("123456");
        $menu->setName("Name");
        $menu->setPic("random pic");
        $menu->setDescription("description");
        $menu->setPrice(5.99);
        $menu->setRestaurant($restaurant);
        $menu->setItems($itemObject);
        $menuToArray = [
            'id' => "123456",
            'restaurant' => null,
            'name' =>"Name",
            'pic' => "random pic",
            'price' => 5.99,
            'description' => "description"
        ];

        $this->assertEquals("123456", $menu->getId());
        $this->assertEquals("Name", $menu->getName());
        $this->assertEquals("random pic", $menu->getPic());
        $this->assertEquals("description", $menu->getDescription());
        $this->assertEquals(5.99, $menu->getPrice());
        $this->assertEquals($restaurant, $menu->getRestaurant());
        $this->assertEquals($itemObject, $menu->getItems());
        $this->assertEquals($menuToArray, $menu->toArray());
    }
}