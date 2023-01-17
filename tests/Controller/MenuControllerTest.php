<?php

namespace App\Tests\Controller;

use App\Document\Menu;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private $documentManager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->documentManager = $this->client->getContainer()->get('doctrine_mongodb.odm.document_manager')->getRepository(Menu::class);
    }

    public function testItemControllerAdd()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->jsonRequest(Request::METHOD_POST,
            $urlGenerator->generate('menu_create'),
            [
                "name" => "Name new for test Menu",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testItemControllerViewId()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $menu = $this->documentManager->findOneBy(['name' => 'Name new for test Menu']);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('menu_view', ['id' => $menu->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('menu_view', ['id' => 0]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testMenuControllerEdit()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $menu = $this->documentManager->findOneBy(['name' => 'Name new for test Menu']);
        $this->client->jsonRequest(Request::METHOD_PATCH,
            $urlGenerator->generate('menu_edit', ['id' => $menu->getId()]),
            [
                "name" => "Name new for test Menu 2",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

        public function testMenuControllerDelete()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $menu = $this->documentManager->findOneBy(['name' => 'Name new for test Menu 2']);
        $this->client->jsonRequest(Request::METHOD_DELETE,
            $urlGenerator->generate('menu_delete', ['idMenu' => $menu->getId()]),
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}