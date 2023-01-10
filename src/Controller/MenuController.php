<?php

namespace App\Controller;

use App\Document\Item;
use App\Document\Menu;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $documentManager)
    {
        $this->dm = $documentManager;
    }

    /**
     * @Route("menu/{id}/view", name="menu_view")
     * @param string $id
     * @return JsonResponse
     */
    public function getMenuById(string $id): JsonResponse
    {
        $response = new JsonResponse();
        $menu = $this->dm->getRepository(Menu::class)->findOneBy(['_id' => $id]);
        $response->setStatusCode(200);
        $response->setData($menu->toArray());

        return $response;
    }
}