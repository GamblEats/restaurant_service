<?php

namespace App\Controller;

use App\Document\Restaurant;
use App\Service\RestaurantService;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    private DocumentManager $dm;
    private RestaurantService $restaurantService;

    public function __construct(DocumentManager $documentManager, RestaurantService $restaurantService)
    {
        $this->dm = $documentManager;
        $this->restaurantService = $restaurantService;
    }

    /**
     * @Route("/restaurant-all", name="restaurant_all")
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $response = new JsonResponse();
        $restaurants = $this->dm->getRepository(Restaurant::class)->findAll();
        $restaurantsArray = [];
        foreach ($restaurants as $restaurant) {
            $restaurantsArray[] = $restaurant->toArray();
        }

        $response->setStatusCode(200);
        $response->setData($restaurantsArray);

        return $response;
    }

    /**
     * @Route("restaurant/{id}/view", name="restaurant_view")
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function findById(Request $request, string $id): Response
    {
        $response = new JsonResponse();
        $restaurant = $this->dm->getRepository(Restaurant::class)->findOneBy(['_id' => $id]);

        $response->setStatusCode(200);
        $response->setData($restaurant->toArrayFull());

        return $response;
    }


    /**
     * @Route("/restaurant-create", name="restaurant_create")
     * @param Request $request
     * @return Response
     */
    public function addRestaurant(Request $request): Response
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $restaurant = $this->restaurantService->restaurantSetters($requestData);

        try {
            $this->dm->persist($restaurant);
            $this->dm->flush();
            $response->setData('A restaurant was be created');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }
}