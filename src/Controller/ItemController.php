<?php

namespace App\Controller;

use App\Document\Item;
use App\Service\ItemService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    private DocumentManager $dm;
    private ItemService $itemService;

    public function __construct(DocumentManager $documentManager, ItemService $itemService)
    {
        $this->dm = $documentManager;
        $this->itemService = $itemService;
    }

    /**
     * @Route("/items/{idItem}", name="item_view", methods={"GET"})
     * @param string $idItem
     * @return JsonResponse
     */
    public function getItemById(string $idItem): JsonResponse
    {
        $response = new JsonResponse();
        $item = $this->dm->getRepository(Item::class)->findOneBy(['_id' => $idItem]);
        $response->setStatusCode(200);
        $response->setData($item->toArray());

        return $response;
    }

    /**
     * @Route("/items", name="item_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addItem(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);

        $item = $this->itemService->itemSetters($requestData, $this->dm);

        try {
            $this->dm->persist($item);
            $this->dm->flush();
            $response->setData('A item was be created');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    /**
     * @Route("/items/{idItem}", name="item_edit", methods={"PATCH"})
     * @param Request $request
     * @param string $idItem
     * @return JsonResponse
     */
    public function editItem(Request $request, string $idItem): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);

        $item = $this->dm->getRepository(Item::class)->findOneBy(['_id' => $idItem]);
        $item = $this->itemService->itemEdit($requestData, $this->dm, $item);

        try {
            $this->dm->persist($item);
            $this->dm->flush();
            $response->setData('A item was be edited');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }
        return $response;
    }

    /**
     * @Route("/items/{idItem}", name="item_delete", methods={"DELETE"})
     * @param string $idItem
     * @return JsonResponse
     */
    public function deleteItem(string $idItem): JsonResponse
    {
        $response = new JsonResponse();
        $item = $this->dm->getRepository(Item::class)->findOneBy(['_id' => $idItem]);

        try {
            $this->dm->remove($item);
            $this->dm->flush();
            $response->setData('A item was be deleted');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }
        return $response;
    }
}