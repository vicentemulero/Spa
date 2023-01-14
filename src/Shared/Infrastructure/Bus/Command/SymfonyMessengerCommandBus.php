<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Domain\Bus\Command\CommandNotRegisteredException;
use App\Shared\Infrastructure\Bus\HandlerBuilder;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class SymfonyMessengerCommandBus implements CommandBus
{
    private MessageBusInterface $bus;

    public function __construct(
        iterable $commandHandlers
    )
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($commandHandlers),
                ),
            ),
        ]);
    }

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException $noHandlerForMessageException) {
            throw new CommandNotRegisteredException($command);
        } catch (HandlerFailedException $handlerFailedException) {
            foreach ($handlerFailedException->getNestedExceptions() as $nestedException) {
                throw $nestedException;
            }

            throw $handlerFailedException;
        }
    }
}
