<?php

namespace App\Tests\Service;

use App\Document\Menu;
use App\Service\MenuService;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPUnit\Framework\TestCase;

class MenuServiceTest extends TestCase
{
    private MenuService $menuService;
    private DocumentManager $documentManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->documentManager = $this->getMockBuilder(DocumentManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->menuService = new MenuService();
    }

    public function testMenuServiceMenuSetters()
    {
        $menu = new Menu();
        $menu->setName("Name");
        $menu->setPic("random pic");
        $menu->setDescription("description");
        $menu->setPrice(8.99);
        $menu->setItems(['1' => true, '2' => true]);
        $menuData = [
            "name" => "Name",
            "pic" => "random pic",
            "description" => "description",
            "price" => 8.99,
            "items" => [
                '1' => true,
                '2' => true
            ]
        ];

        $menuGenerating = $this->menuService->menuSetters($menuData, $this->documentManager);

        $this->assertEquals($menuGenerating->getName(), $menu->getName());
        $this->assertEquals($menuGenerating->getPic(), $menu->getPic());
        $this->assertEquals($menuGenerating->getDescription(), $menu->getDescription());
        $this->assertEquals($menuGenerating->getPrice(), $menu->getPrice());
        $this->assertEquals($menuGenerating->getItems(), $menu->getItems());
    }

    public function testMenuServiceMenuEdite()
    {
        $menu = new Menu();
        $menu->setName("Name");
        $menu->setPic("random pic");
        $menu->setDescription("description");
        $menu->setPrice(8.99);
        $menu->setItems(['1' => true, '2' => true]);

        $menuData = [
            "name" => "Name 2",
            "pic" => "new random pic",
            "description" => "new description",
            "price" => 9.99,
            "items" => [
                '1' => true,
                '2' => true,
                '3' => true,
            ]
        ];

        $menuGenerating = $this->menuService->menuEdite($menuData, $this->documentManager, $menu);

        $this->assertEquals($menuGenerating->getName(), $menuData["name"]);
        $this->assertEquals($menu->getName(), $menuData["name"]);
        $this->assertEquals($menuGenerating->getPic(), $menuData["pic"]);
        $this->assertEquals($menu->getPic(), $menuData["pic"]);
        $this->assertEquals($menuGenerating->getDescription(), $menuData["description"]);
        $this->assertEquals($menu->getDescription(), $menuData["description"]);
        $this->assertEquals($menuGenerating->getPrice(), $menuData["price"]);
        $this->assertEquals($menu->getPrice(), $menuData["price"]);
        $this->assertEquals($menuGenerating->getItems(), $menuData["items"]);
        $this->assertEquals($menu->getItems(), $menuData["items"]);
    }
}