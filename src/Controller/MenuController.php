<?php

namespace App\Controller;

use App\Document\Item;
use App\Document\Menu;
use App\Service\MenuService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private DocumentManager $dm;
    private MenuService $menuService;

    public function __construct(DocumentManager $documentManager, MenuService $menuService)
    {
        $this->dm = $documentManager;
        $this->menuService = $menuService;
    }

    /**
     * @Route("/menus/{id}", name="menu_view", methods={"GET"})
     * @param string $id
     * @return JsonResponse
     */
    public function getMenuById(string $id): JsonResponse
    {
        $response = new JsonResponse();
        $menu = $this->dm->getRepository(Menu::class)->findOneBy(['_id' => $id]);
        $response->setStatusCode(200);
        $menuArray = $menu->toArray();
        $menuArray['items'] = [];
        foreach ($menu->getItems() as $key => $item) {
            $itemObject = $this->dm->getRepository(Item::class)->findOneBy(['_id' => $key]);
            if ($itemObject) {
                $menuArray['items'][] = $itemObject->toArray();
            }
        }

        $response->setData($menuArray);

        return $response;
    }

    /**
     * @Route("/menus", name="menu_create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addMenu(Request $request): JsonResponse
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $menu = $this->menuService->menuSetters($requestData, $this->dm);

        try {
            $this->dm->persist($menu);
            $this->dm->flush();
            $response->setData('A menu was be created');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    /**
     * @Route("/menus/{id}", name="menu_edit", methods={"PATCH"})
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function editMenu(Request $request, string $id): Response
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $menu = $this->dm->getRepository(Menu::class)->findOneBy(['_id' => $id]);
        $newMenu = $this->menuService->menuEdite($requestData, $this->dm, $menu);

        try {
            $this->dm->persist($newMenu);
            $this->dm->flush();
            $response->setData('The menu ' . $id . ' was editing.');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    /**
     * @Route("/menus/{idMenu}", name="menu_delete", methods={"DELETE"})
     * @param Request $request
     * @param string $idMenu
     * @return Response
     */
    public function deleteMenu(Request $request, string $idMenu): Response
    {
        $response = new JsonResponse();
        $requestData = json_decode($request->getContent(), true);
        $menu = $this->dm->getRepository(Menu::class)->findOneBy(['_id' => $idMenu]);

        try {
            $this->dm->remove($menu);
            $this->dm->flush();
            $response->setData('A menu was be deleted');
            $response->setStatusCode(200);
        }
        catch (\Exception $exception) {
            dd($exception);
        }

        return $response;
    }

    // TODO RevieW all route with ID etc...
}