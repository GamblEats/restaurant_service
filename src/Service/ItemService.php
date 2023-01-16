<?php

namespace App\Service;

use App\Document\Item;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use PhpParser\Comment\Doc;

class ItemService
{
    public function itemSetters(array $request, DocumentManager $dm): Item
    {
        $item = new Item();

        if (isset($request["category"]) && $request["category"] !== "") {
            $item->setCategory($request["category"]);
        }

        if (isset($request["name"]) && $request["name"] !== "") {
            $item->setName($request["name"]);
        }

        if (isset($request["price"]) && $request["price"] !== "") {
            $item->setPrice($request["price"]);
        }

        if (isset($request["pic"]) && $request["pic"] !== "") {
            $item->setPic($request["pic"]);
        }

        if (isset($request["restaurant"]) && $request["restaurant"] !== "") {
            $restaurant = $dm->getRepository(Restaurant::class)->findOneBy(['_id' => $request["restaurant"]]);
            $item->setRestaurant($restaurant);
        }

        return $item;
    }

    public function itemEdit(array $request, DocumentManager $documentManager, ?Item $item): ?Item
    {
        if ($item) {
            if(isset($request["category"]) && $request["category"] !== $item->getCategory()) {
                $item->setCategory($request["category"]);
            }

            if(isset($request["name"]) && $request["name"] !== $item->getName()) {
                $item->setName($request["name"]);
            }

            if(isset($request["price"]) && $request["price"] !== $item->getPrice()) {
                $item->setPrice($request["price"]);
            }

            if(isset($request["pic"]) && $request["pic"] !== $item->getPic()) {
                $item->setPic($request["pic"]);
            }

            if(isset($request["restaurant"]) && $request["restaurant"] !== $item->getRestaurant()->getId()) {
                $restaurant = $documentManager->getRepository(Restaurant::class)->findOneBy(['_id' => $request["restaurant"]]);
                $item->setRestaurant($restaurant);
            }

            return $item;
        }

        return null;
    }
}