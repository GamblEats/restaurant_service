<?php

namespace App\Service;

use App\Document\Item;
use App\Document\Menu;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;

class MenuService
{

    public function menuSetters(array $request, DocumentManager $dm): Menu
    {
        $menu = new Menu();

        if (isset($request["name"]) && $request["name"] !== "") {
            $menu->setName($request["name"]);
        }

        if (isset($request["pic"]) && $request["pic"] !== "") {
            $menu->setPic($request["pic"]);
        }

        if (isset($request["description"]) && $request["description"] !== "") {
            $menu->setDescription($request["description"]);
        }

        if (isset($request["price"]) && $request["price"] !== "") {
            $menu->setPrice($request["price"]);
        }

        if (isset($request["restaurant"]) && $request["restaurant"] !== "") {
            $restaurant = $dm->getRepository(Restaurant::class)->findOneBy(['_id' => $request['restaurant']]);
            $menu->setRestaurant($restaurant);
        }

        if (isset($request["items"]) && $request["items"] !== []) {
            $itemsArray = [];
            foreach ($request['items'] as $item) {
                $newItem = $dm->getRepository(Item::class)->findOneBy(['_id' => $item]);
                if ($newItem) {
                    $itemsArray[$newItem->getId()] = $newItem->toArray();
                }
            }
            $menu->setItems($itemsArray);
        }

        return $menu;
    }

    public function menuEdite(array $request, DocumentManager $dm, Menu $menu): Menu
    {
        if(isset($request["description"]) && $request["description"] !== $menu->getDescription()) {
            $menu->setDescription($request["description"]);
        }

        if(isset($request["name"]) && $request["name"] !== $menu->getName()) {
            $menu->setName($request["name"]);
        }

        if(isset($request["pic"]) && $request["pic"] !== $menu->getPic()) {
            $menu->setPic($request["pic"]);
        }

        if(isset($request["price"]) && $request["price"] !== $menu->getPrice()) {
            $menu->setPrice($request["price"]);
        }

        if(isset($request["restaurant"]) && $request["restaurant"] !== $menu->getRestaurant()) {
            $restaurant = $dm->getRepository(Restaurant::class)->findOneBy(['_id' => $request["restaurant"]]);
            $menu->setRestaurant($restaurant);
        }

        if (isset($request["items"]) && $request["items"] !== []) {
            $itemsArray = [];
            foreach ($request['items'] as $item) {
                $newItem = $dm->getRepository(Item::class)->findOneBy(['_id' => $item]);
                if ($newItem) {
                    $itemsArray[$newItem->getId()] = $newItem->toArray();
                }
            }
            $menu->setItems($itemsArray);
        }

        return $menu;
    }
}