<?php

namespace App\Service;

use App\Document\Restaurant;

class RestaurantService
{
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
}