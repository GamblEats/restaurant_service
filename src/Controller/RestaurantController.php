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
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
     * @Route("/restaurants", name="restaurant_all", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $response = new JsonResponse();
        $restaurants = $this->dm->getRepository(Restaurant::class)->findAll();
        $restaurantsArray = [];
        foreach ($restaurants as $restaurant) {
            $restaurantsArray[] = $restaurant->toArrayFull();
        }

        $response->setStatusCode(200);
        $response->setData($restaurantsArray);

        return $response;
    }

    /**
     * @Route("/restaurants/{id}", name="restaurant_view", methods={"GET"})
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function findById(Request $request, string $urlUser, string $id, HttpClientInterface $httpClient): Response
    {
        $response = new JsonResponse();
        $restaurant = $this->dm->getRepository(Restaurant::class)->findOneBy(['_id' => $id]);

        if ($restaurant) {
            $restaurantArray = $restaurant->toArrayFull();
            $restaurantArray['menus'] = $this->restaurantService->getMenuAndItemsByRestaurant($restaurant)['menus'];
            $response->setData($restaurantArray);
        } else {
            $response->setData(null);
        }

        $response->setStatusCode(200);

        return $response;
    }


    /**
     * @Route("/restaurants", name="restaurant_create", methods={"POST"})
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

    /**
     * @Route("/restaurants/{id}", name="restaurant_edit", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function editRestaurant(Request $request, string $id): Response
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $restaurant = $this->dm->getRepository(Restaurant::class)->findOneBy(['_id' => $id]);
        $newRestaurant = $this->restaurantService->restaurantEdite($restaurant, $requestData);

        try {
            $this->dm->persist($newRestaurant);
            $this->dm->flush();
            $response->setData('The restaurant ' . $id . ' was editing.');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    /**
     * @Route("/restaurants/{id}", name="restaurant_delete", methods={"DELETE"})
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function deleteRestaurant(Request $request, string $id): Response
    {
        $response = new JsonResponse();
        $restaurant = $this->dm->getRepository(Restaurant::class)->findOneBy(['_id' => $id]);

        try {
            $this->dm->remove($restaurant);
            $this->dm->flush();
            $response->setData('A restaurant was be deleted');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    /**
     * @Route("/users/{id}/restaurants", name="restaurant_by_user_id", methods={"GET"})
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function getRestaurantsByUser(Request $request, string $id): Response
    {
        $response = new JsonResponse();
        $response->setStatusCode(200);

        $restaurant = $this->dm->getRepository(Restaurant::class)->findOneBy(['owner' => $id]);

        if ($restaurant) {
            $response->setData($restaurant->toArray());
        } else {
            $response->setData(null);
        }

        return $response;
    }
}