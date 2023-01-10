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

        if (isset($request["address"]) && $request["address"] !== "") {
            $restaurant->setAddress($request["address"]);
        }

        if (isset($request["deliveryPrice"]) && $request["deliveryPrice"] !== "") {
            $restaurant->setDeliveryPrice($request["deliveryPrice"]);
        }

        if (isset($request["deliveryTime"]) && $request["deliveryTime"] !== "") {
            $restaurant->setDeliveryTime($request["deliveryTime"]);
        }

        if (isset($request["rating"]) && $request["rating"] !== "") {
            $restaurant->setRating($request["rating"]);
        }

        if (isset($request["description"]) && $request["description"] !== "") {
            $restaurant->setRating($request["description"]);
        }

        return $restaurant;
    }

    public function restaurantEdite(Restaurant $restaurant, array $request): Restaurant
    {
        if(isset($request["description"]) && $request["description"] !== $restaurant->getDescription()) {
            $restaurant->setDescription($request["description"]);
        }

        if(isset($request["name"]) && $request["name"] !== $restaurant->getName()) {
            $restaurant->setName($request["name"]);
        }

        if(isset($request["pic"]) && $request["pic"] !== $restaurant->getPic()) {
            $restaurant->setPic($request["pic"]);
        }

        if(isset($request["address"]) && $request["address"] !== $restaurant->getAddress()) {
            $restaurant->setAddress($request["address"]);
        }

        if(isset($request["deliveryPrice"]) && $request["deliveryPrice"] !== $restaurant->getDeliveryPrice()) {
            $restaurant->setDeliveryPrice($request["deliveryPrice"]);
        }

        if(isset($request["deliveryTime"]) && $request["deliveryTime"] !== $restaurant->getDeliveryTime()) {
            $restaurant->setDeliveryTime($request["deliveryTime"]);
        }

        if(isset($request["deliveryTime"]) && $request["deliveryTime"] !== $restaurant->getDeliveryTime()) {
            $restaurant->setDeliveryTime($request["deliveryTime"]);
        }

        if(isset($request["rating"]) && $request["rating"] !== $restaurant->getRating()) {
            $restaurant->setRating($request["rating"]);
        }


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