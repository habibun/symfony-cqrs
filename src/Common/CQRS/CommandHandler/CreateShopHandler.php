<?php

declare(strict_types=1);

namespace App\Common\CQRS\CommandHandler;

use App\Common\CQRS\CommandHandler;

final class CreateShopHandler implements CommandHandler
{
    private ShopFactory $shopFactory;
    private Shops $shops;

    public function __construct(CompanyFactory $shopFactory, Shops $shops)
    {
        $this->shopFactory = $shopFactory;
        $this->shops = $shops;
    }

    public function __invoke(CreateShopCommand $command): void
    {
        if ($this->shops->existsWithName($command->name())) {
            throw ShopNameTaken::withName($command->name());
        }

        $shop = $this->shopFactory->create($command->id(), $command->name());

        $this->shops->add($shop);
    }
}
