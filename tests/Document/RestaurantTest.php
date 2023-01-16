<?php

namespace App\Tests\Document;

use App\Document\Item;
use App\Document\Menu;
use App\Document\Restaurant;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testDocumentSettersGetters()
    {
        $restaurant = new Restaurant();
        $menu = new Menu();
        $arrayMenu = new ArrayCollection([$menu]);
        $item = new Item();
        $arrayItem = new ArrayCollection([$item]);
        $categories = [
            "pasta" => true,
            "hamburgers" => true
        ];

        $restaurant->setId("123456");
        $restaurant->setPic("pic random");
        $restaurant->setName('Name Restaurant');
        $restaurant->setIsDeployed(true);
        $restaurant->setAddress('address 1');
        $restaurant->setDeliveryPrice(33.99);
        $restaurant->setDeliveryTime("30 min");
        $restaurant->setRating(4.1);
        $restaurant->setDescription("description");
        $restaurant->setOwner("123456789");
        $restaurant->setItems($arrayItem);
        $restaurant->setMenus($arrayMenu);
        $restaurant->setCategories($categories);

        $arrayRestaurant = [
            'name' => 'Name Restaurant',
            'pic' => "pic random",
            'id' => "123456"
        ];
        $arrayRestaurantFull = [
            "name" => "Name Restaurant",
            "pic" => "pic random",
            "id" => "123456",
            "deliveryPrice" => 33.99,
            "deliveryTime" => "30 min",
            "rating" => 4.1,
            "description" => "description",
            "items" => [
                [
                    "id" => null,
                    "category" => null,
                    "name" => null,
                    "price" => null,
                    "pic" => null
                ]
            ],
            "categories" => ["pasta", "hamburgers"]
        ];

        $this->assertEquals("123456", $restaurant->getId());
        $this->assertEquals("pic random", $restaurant->getPic());
        $this->assertEquals("Name Restaurant", $restaurant->getName());
        $this->assertEquals(true, $restaurant->isDeployed());
        $this->assertEquals('address 1', $restaurant->getAddress());
        $this->assertEquals(33.99, $restaurant->getDeliveryPrice());
        $this->assertEquals("30 min", $restaurant->getDeliveryTime());
        $this->assertEquals(4.1, $restaurant->getRating());
        $this->assertEquals("description", $restaurant->getDescription());
        $this->assertEquals("123456789", $restaurant->getOwner());
        $this->assertEquals($arrayRestaurant, $restaurant->toArray());
        $this->assertEquals($arrayItem, $restaurant->getItems());
        $this->assertEquals($arrayMenu, $restaurant->getMenus());
        $this->assertEquals($categories, $restaurant->getCategories());
        $this->assertEquals($arrayRestaurantFull, $restaurant->toArrayFull());
    }
}