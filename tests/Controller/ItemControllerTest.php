<?php

namespace App\Tests\Controller;

use App\Document\Item;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private $documentManager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->documentManager = $this->client->getContainer()->get('doctrine_mongodb.odm.document_manager')->getRepository(Item::class);
    }

    public function testItemControllerViewId()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('item_view', ['idItem' => 0]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testItemControllerAdd()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->jsonRequest(Request::METHOD_POST,
            $urlGenerator->generate('item_add'),
            [
                "name" => "Name new for test",
                "category" => "hamburgers",
                "price" => 6.99,
                "pic" => "random pic new",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testItemControllerEdit()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $item = $this->documentManager->findOneBy(['name' => 'Name new for test']);
        $this->client->jsonRequest(Request::METHOD_PATCH,
            $urlGenerator->generate('item_edit', ['idItem' => $item->getId()]),
            [
                "name" => "Name new for test 2",
                "category" => "hamburgers",
                "price" => 6.99,
                "pic" => "random pic new",
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testItemControllerDelete()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $item = $this->documentManager->findOneBy(['name' => 'Name new for test 2']);
        $this->client->jsonRequest(Request::METHOD_DELETE,
            $urlGenerator->generate('item_delete', ['idItem' => $item->getId()]),
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
