<?php

namespace App\Service;

use App\Document\Item;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;

class RestaurantService
{
    private $itemRepository;

    public function __construct(DocumentManager $documentManager)
    {
        $this->itemRepository = $documentManager->getRepository(Item::class);
    }

    public function restaurantSetters(array $request): Restaurant
    {
        $restaurant = new Restaurant();

        if (isset($request["name"]) && $request["name"] !== "") {
            $restaurant->setName($request["name"]);
        }

        if (isset($request["pic"]) && $request["pic"] !== "") {
            $restaurant->setPic($request["pic"]);
        }

        $restaurant->setIsDeployed(false);

        return $restaurant;
    }

    public function getMenuAndItemsByRestaurant(Restaurant $restaurant): array
    {
        $toArrayMenus = [];
        foreach ($restaurant->getMenus() as $menu) {
            $menuArray = $menu->toArray();
            $menuArray['items'] = [];
            foreach ($menu->getItems() as $key => $item) {
                $itemObject = $this->itemRepository->findOneBy(['_id' => $key]);
                $menuArray['items'][] = $itemObject->toArray();
            }

            $toArrayMenus[] = $menuArray;
        }

        return [
            'menus' => $toArrayMenus
        ];
    }
}