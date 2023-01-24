<?php

declare(strict_types=1);

namespace App\Reservations\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class ReservationCreatedEvent extends DomainEvent
{
    public function __construct(
        int                  $id,
        private readonly string $serviceId,
        private readonly int    $scheduleId,
        private readonly string $clientName,
        private readonly string $clientEmail,
        private readonly string $reservedDay,
        private readonly string $reservedTime,
        private readonly string $serviceName,
        private readonly float  $servicePrice,
        private readonly string $createdAt,
        string                  $eventId = null,
        string                  $occurredOn = null
    )
    {
        parent::__construct((string)$id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'reservation.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['ServiceId'],
            $body['scheduleId'],
            $body['clientName'],
            $body['clientEmail'],
            $body['reservedDay'],
            $body['reservedTime'],
            $body['serviceName'],
            $body['servicePrice'],
            $body['createdAt'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'serviceId' => $this->serviceId,
            'scheduleId' => $this->scheduleId,
            'clientName' => $this->clientName,
            'clientEmail' => $this->clientEmail,
            'dayReserved' => $this->reservedDay,
            'timeReserved' => $this->reservedTime,
            'serviceName' => $this->serviceName,
            'servicePrice' => $this->servicePrice,
            'createdAt' => $this->createdAt,
        ];
    }

    public function serviceId(): string
    {
        return $this->serviceId;
    }

    public function scheduleId(): int
    {
        return $this->scheduleId;
    }

    public function clientName(): string
    {
        return $this->clientName;
    }

    public function clientEmail(): string
    {
        return $this->clientEmail;
    }

    public function reservedDay(): string
    {
        return $this->reservedDay;
    }

    public function reservedTime(): string
    {
        return $this->reservedTime;
    }

    public function serviceName(): string
    {
        return $this->serviceName;
    }

    public function servicePrice(): float
    {
        return $this->servicePrice;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

}
