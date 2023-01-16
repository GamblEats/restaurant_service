<?php

namespace App\Tests\Service;

use App\Document\Restaurant;
use App\Service\RestaurantService;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\ObjectId;
use PHPUnit\Framework\TestCase;

class RestaurantServiceTest extends TestCase
{
    private RestaurantService $restaurantService;
    private DocumentManager $documentManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->documentManager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->restaurantService = new RestaurantService($this->documentManager);
    }

    public function testRestaurantServiceRestaurantSetters()
    {
        $restaurant = new Restaurant();

        $restaurant->setName("Name");
        $restaurant->setPic("random pic");
        $restaurant->setAddress("address");
        $restaurant->setDeliveryPrice(4.99);
        $restaurant->setDeliveryTime("30 min");
        $restaurant->setRating(4.1);
        $restaurant->setDescription("description");

        $restaurantData = [
            "name" => "Name",
            "pic" => "random pic",
            "address" => "address",
            "deliveryPrice" => 4.99,
            "deliveryTime" => "30 min",
            "rating" => 4.1,
            "description" => "description",
        ];

        $restaurantGenerating = $this->restaurantService->restaurantSetters($restaurantData);

        $this->assertEquals($restaurantGenerating->getName(), $restaurant->getName());
        $this->assertEquals($restaurantGenerating->getPic(), $restaurant->getPic());
        $this->assertEquals($restaurantGenerating->getAddress(), $restaurant->getAddress());
        $this->assertEquals($restaurantGenerating->getDeliveryPrice(), $restaurant->getDeliveryPrice());
        $this->assertEquals($restaurantGenerating->getDeliveryTime(), $restaurant->getDeliveryTime());
        $this->assertEquals($restaurantGenerating->getRating(), $restaurant->getRating());
        $this->assertEquals($restaurantGenerating->getDescription(), $restaurant->getDescription());
    }

    public function testRestaurantServiceRestaurantEdit()
    {
        $restaurant = new Restaurant();
        $restaurant->setName("Name");
        $restaurant->setPic("random pic");
        $restaurant->setAddress("address");
        $restaurant->setDeliveryPrice(4.99);
        $restaurant->setDeliveryTime("30 min");
        $restaurant->setRating(4.1);
        $restaurant->setDescription("description");

        $restaurantData = [
            "name" => "Name 2",
            "pic" => "random pic 2",
            "address" => "address 2",
            "deliveryPrice" => 5.99,
            "deliveryTime" => "35 min",
            "rating" => 4.5,
            "description" => "new description",
        ];

        $restaurantGenerating = $this->restaurantService->restaurantEdite($restaurant, $restaurantData);

        $this->assertEquals($restaurantGenerating->getName(), $restaurantData["name"]);
        $this->assertEquals($restaurant->getName(), $restaurantData["name"]);
        $this->assertEquals($restaurantGenerating->getPic(), $restaurantData["pic"]);
        $this->assertEquals($restaurant->getPic(), $restaurantData["pic"]);
        $this->assertEquals($restaurantGenerating->getAddress(), $restaurantData["address"]);
        $this->assertEquals($restaurant->getAddress(), $restaurantData["address"]);
        $this->assertEquals($restaurantGenerating->getDeliveryPrice(), $restaurantData["deliveryPrice"]);
        $this->assertEquals($restaurant->getDeliveryPrice(), $restaurantData["deliveryPrice"]);
        $this->assertEquals($restaurantGenerating->getDeliveryTime(), $restaurantData["deliveryTime"]);
        $this->assertEquals($restaurant->getDeliveryTime(), $restaurantData["deliveryTime"]);
        $this->assertEquals($restaurantGenerating->getRating(), $restaurantData["rating"]);
        $this->assertEquals($restaurant->getRating(), $restaurantData["rating"]);
        $this->assertEquals($restaurantGenerating->getDescription(), $restaurantData["description"]);
        $this->assertEquals($restaurant->getDescription(), $restaurantData["description"]);
    }
}