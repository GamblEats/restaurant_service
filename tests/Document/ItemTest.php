<?php

namespace App\Tests\Document;

use App\Document\Item;
use App\Document\Restaurant;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testItemSettersAndGetters()
    {
        $item = new Item();
        $restaurant = new Restaurant();

        $item->setId("123456");
        $item->setPrice(4.99);
        $item->setName("Name Item");
        $item->setPic("pic random");
        $item->setCategory("drink");
        $item->setRestaurant($restaurant);
        $itemArray = [
          'id' => '123456',
          'category' => 'drink',
          'name' => 'Name Item',
          'price' => 4.99,
          'pic' => 'pic random'
        ];

        $this->assertEquals("123456", $item->getId());
        $this->assertEquals(4.99, $item->getPrice());
        $this->assertEquals("Name Item", $item->getName());
        $this->assertEquals("pic random", $item->getPic());
        $this->assertEquals("drink", $item->getCategory());
        $this->assertEquals($restaurant, $item->getRestaurant());
        $this->assertEquals($itemArray, $item->toArray());
    }
}