<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\QueryInterface;
use App\Shared\Domain\Bus\Query\QueryNotRegisteredException;
use App\Shared\Domain\Bus\Query\QueryResponse;
use App\Shared\Infrastructure\Bus\HandlerBuilder;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class InMemoryQueryBus implements QueryBus
{
    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($queryHandlers),
                ),
            ),
        ]);
    }

    public function dispatch(QueryInterface $query): QueryResponse
    {
        try {
            $messengerEnvelope = $this->bus->dispatch($query);

            return $messengerEnvelope->last(HandledStamp::class)->getResult();
        } catch (NoHandlerForMessageException $noHandlerForMessageException) {
            throw new QueryNotRegisteredException($query);
        } catch (HandlerFailedException $handlerFailedException) {
            foreach ($handlerFailedException->getNestedExceptions() as $nestedException) {
                throw $nestedException;
            }

            throw $handlerFailedException;
        }
    }
}
