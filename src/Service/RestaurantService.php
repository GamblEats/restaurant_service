<?php

namespace App\Service;

use App\Document\Item;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\ObjectId;

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
            $restaurant->setRating(rand(1, 5));
        }

        if (isset($request["description"]) && $request["description"] !== "") {
            $restaurant->setDescription($request["description"]);
        }

        if (isset($request["owner"]) && $request["owner"] !== "") {
            $restaurant->setOwner(new ObjectId($request["owner"]));
        }

        if(isset($request["categories"]) && $request["categories"] !== "") {
            $restaurant->setCategories($request["categories"]);
        }

        if(isset($request["city"]) && $request["city"] !== "") {
            $restaurant->setCity($request["city"]);
        }

        if(isset($request["postalCode"]) && $request["postalCode"] !== "") {
            $restaurant->setPostalCode($request["postalCode"]);
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

        if(isset($request["rating"]) && $request["rating"] !== $restaurant->getRating()) {
            $restaurant->setRating($request["rating"]);
        }

        if(isset($request["owner"]) && $request["owner"] !== $restaurant->getOwner()) {
            $restaurant->setOwner(new ObjectId($request["owner"]));
        }

        if(isset($request["categories"]) && $request["categories"] !== $restaurant->getCategories()) {
            $restaurant->setCategories($request["categories"]);
        }

        if(isset($request["city"]) && $request["city"] !== $restaurant->getCity()) {
            $restaurant->setCity($request["city"]);
        }

        if(isset($request["postalCode"]) && $request["postalCode"] !== $restaurant->getPostalCode()) {
            $restaurant->setPostalCode($request["postalCode"]);
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
                $itemObject = $this->itemRepository->findOneBy(['_id' => $item['id']]);
                if ($itemObject) {
                    $menuArray['items'][] = $itemObject->toArray();
                }
            }

            $toArrayMenus[] = $menuArray;
        }

        return [
            'menus' => $toArrayMenus
        ];
    }
}