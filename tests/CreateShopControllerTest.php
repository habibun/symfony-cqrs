<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class CreateShopControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function testShopSuccessfullyCreated(): void
    {
        $this->client->request('POST', '/shops', [
            'name' => 'My great shop',
        ]);

        self::assertEquals(Response::HTTP_ACCEPTED, $this->client->getResponse()->getStatusCode());
    }

    public function testCannotCreateShopWhenNameTaken(): void
    {
        $existingShop = ShopMother::any();
        static::$container->get(Shops::class)->add(existingShop); // You can replace it with any fixture-lib

        $this->client->request('POST', '/shops', [
            'name' => ShopMother::NAME, // We're taking the same name as existing in 30 line
        ]);

        self::assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }
}
