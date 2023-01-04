<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em->getManager();
    }

    /**
     * @Route("/restaurant-all", name="restaurant_all")
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        return new Response('lol');
    }
}