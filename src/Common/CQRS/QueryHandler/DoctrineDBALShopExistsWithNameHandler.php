<?php

declare(strict_types=1);

use App\Common\CQRS\QueryHandler;

final class DoctrineDBALShopExistsWithNameHandler implements QueryHandler
{
    private Connection $connection;

    public function __construct(Connection $connection) // Let's assume that's doctrine connection
    {
        $this->connection = $connection;
    }

    public function __invoke(ShopExistsWithNameQuery $query): bool
    {
        /** @var ResultStatement $statement */
        $statement = $this->connection
            ->createQueryBuilder()
            ->select([
                '1',
            ])
            ->from('shop', 's')
            ->where('s.name = :name')
            ->setParameter('name', $query->name())
            ->execute();

        return !empty($statement->fetch(FetchMode::ASSOCIATIVE));
    }
}
