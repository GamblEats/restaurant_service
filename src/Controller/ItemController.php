<?php

namespace App\Controller;

use App\Document\Item;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private DocumentManager $dm;

    public function __construct(DocumentManager $documentManager)
    {
        $this->dm = $documentManager;
    }

    /**
     * @Route("item/{id}", name="item_view")
     * @param string $id
     * @return JsonResponse
     */
    public function getItemById(string $id): JsonResponse
    {
        $response = new JsonResponse();
        $item = $this->dm->getRepository(Item::class)->findOneBy(['_id' => $id]);
        $response->setStatusCode(200);
        $response->setData($item->toArray());

        return $response;
    }
}