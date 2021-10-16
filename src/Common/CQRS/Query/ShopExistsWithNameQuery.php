<?php

declare(strict_types=1);

use App\Common\CQRS\Query;

final class ShopExistsWithNameQuery implements Query
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
