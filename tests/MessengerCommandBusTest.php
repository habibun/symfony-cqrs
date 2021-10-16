<?php

declare(strict_types=1);

namespace App\Tests;

use App\Common\CQRS\Command;
use App\Common\CQRS\MessengerCommandBus;
use App\Tests\Common\CQRS\TestDouble\DummyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBusTest extends TestCase
{
    private MessageBusInterface $symfonyMessageBus;
    private MessengerCommandBus $commandBus;

    protected function setUp(): void
    {
        $this->symfonyMessageBus = $this->assembleSymfonyMessageBus();
        $this->commandBus = new MessengerCommandBus($this->symfonyMessageBus);
    }

    public function testMessageForwardedToMessageBusWhileDispatching(): void
    {
        $command = new DummyCommand();
        $this->commandBus->dispatch($command);

        self::assertSame($command, $this->symfonyMessageBus->lastDispatchedCommand());
    }

    private function assembleSymfonyMessageBus(): MessageBusInterface
    {
        return new class() implements MessageBusInterface {
            private Command $dispatchedCommand;

            public function dispatch($message, array $stamps = []): Envelope
            {
                $this->dispatchedCommand = $message;

                return new Envelope($message);
            }

            public function lastDispatchedCommand(): Command
            {
                return $this->dispatchedCommand;
            }
        };
    }
}
