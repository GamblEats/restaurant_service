<?php

namespace App\Tests\Service;

use App\Document\Item;
use App\Document\Restaurant;
use App\Service\ItemService;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPUnit\Framework\TestCase;

class ItemServiceTest extends TestCase
{
    private ItemService $itemService;
    private DocumentManager $documentManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->itemService = new ItemService();
        $this->documentManager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItemServiceItemSetters()
    {
        $item = new Item();
        $restaurant = new Restaurant();

        $item->setName("Name");
        $item->setCategory("pasta");
        $item->setPrice(5.99);
        $item->setPic("random pic");
        $item->setRestaurant($restaurant);
        $itemData = [
            "name" => "Name",
            "category" => "pasta",
            "price" => 5.99,
            "pic" => "random pic",
            "restaurant" => $restaurant->getId()
        ];

        $itemGenerating = $this->itemService->itemSetters($itemData, $this->documentManager);

        $this->assertEquals($itemGenerating->getName(), $item->getName());
        $this->assertEquals($itemGenerating->getCategory(), $item->getCategory());
        $this->assertEquals($itemGenerating->getPrice(), $item->getPrice());
        $this->assertEquals($itemGenerating->getPic(), $item->getPic());
    }

    public function testItemServiceItemEdit()
    {
        $item = new Item();
        $item->setName("Name");
        $item->setCategory("pasta");
        $item->setPrice(5.99);
        $item->setPic("random pic");

        $itemData = [
            "name" => "Name new",
            "category" => "hamburgers",
            "price" => 6.99,
            "pic" => "random pic new",
        ];

        $itemGenerating = $this->itemService->itemEdit($itemData, $this->documentManager, $item);

        $this->assertEquals($itemGenerating->getName(), $itemData["name"]);
        $this->assertEquals($item->getName(), $itemData["name"]);
        $this->assertEquals($itemGenerating->getPic(), $itemData["pic"]);
        $this->assertEquals($item->getPic(), $itemData["pic"]);
        $this->assertEquals($itemGenerating->getCategory(), $itemData["category"]);
        $this->assertEquals($item->getCategory(), $itemData["category"]);
        $this->assertEquals($itemGenerating->getPrice(), $itemData["price"]);
        $this->assertEquals($item->getPrice(), $itemData["price"]);
    }
}