<?php

namespace App\Tests\Controller;

use App\Document\Restaurant;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private $documentManager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->documentManager = $this->client->getContainer()->get('doctrine_mongodb.odm.document_manager')->getRepository(Restaurant::class);
    }

        public function testRestaurantControllerAdd()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->jsonRequest(Request::METHOD_POST,
            $urlGenerator->generate('restaurant_create'),
            [
                "name" => "Name new for test Restaurant",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

        public function testRestaurantControllerViewId()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $restaurant = $this->documentManager->findOneBy(['name' => 'Name new for test Restaurant']);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('restaurant_view', ['id' => $restaurant->getId()]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('restaurant_view', ['id' => 0]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testRestaurantControllerEdit()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $restaurant = $this->documentManager->findOneBy(['name' => 'Name new for test Restaurant']);
        $this->client->jsonRequest(Request::METHOD_PATCH,
            $urlGenerator->generate('restaurant_edit', ['id' => $restaurant->getId()]),
            [
                "name" => "Name new for test Restaurant 2",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testRestaurantControllerDelete()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $menu = $this->documentManager->findOneBy(['name' => 'Name new for test Restaurant 2']);
        $this->client->jsonRequest(Request::METHOD_DELETE,
            $urlGenerator->generate('restaurant_delete', ['id' => $menu->getId()]),
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}