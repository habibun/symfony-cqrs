<?php

declare(strict_types=1);

namespace App\Common\CQRS;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateShopController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $name = (string) $request->get('name');

        if (empty($name)) {
            return new JsonResponsee([
                'error' => 'shop \'name\' can not be empty',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($this->shopWithNameExists($name)) {
            return new JsonResponse([
                'error' => 'given shop name is already taken',
            ], JsonResponse::HTTP_CONFLICT);
        }

        $command = new CreateShop('id', $name);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Shop creating started!',
            'shop_id' => $command->id(),
        ], JsonResponse::HTTP_ACCEPTED);
    }

    private function shopWithNameExists(string $name): bool
    {
        return $this->queryBus->handle(new ShopExistsWithNameQuery($name));
    }
}
