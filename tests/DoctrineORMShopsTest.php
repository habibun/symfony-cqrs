<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineORMShopsTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DoctrineORMShops $repository;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->em = self::$container->get(EntityManagerInterface::class);
        $this->repository = new DoctrineORMShops($this->em);
    }

    public function testShopSucceessfullyAdded(): void
    {
        $shop = ShopMother::any();

        $this->repository->add($shop);

        /** @var Shop $existing */
        $existing = $this->repository->ofId($shop->id());

        self::assertEquals($shop->id(), $existing->id());
    }

    public function testShopNotFoundWhenWasNotAdded(): void
    {
        $this->expectException(ShopNotFound::class);

        $this->repository->ofId(ShopIdMother::any());
    }
}
