<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class ServiceCreatedEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $name,
        private readonly float $price,
        private readonly string $createdAt,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'service.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['name'],
            $body['price'],
            $body['createdAt'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'price'  => $this->price,
            'createdAt'    => $this->createdAt
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }
    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
