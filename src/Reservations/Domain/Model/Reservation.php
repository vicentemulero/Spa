<?php

declare(strict_types=1);

namespace App\Reservations\Domain\Model;

use App\Reservations\Domain\Events\ReservationCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\SpaValueObject\ReservationId;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\ServiceName;
use App\SpaServices\Domain\Model\ServicePrice;
use DateTime;

final class Reservation extends AggregateRoot
{

    public function __construct(
        private readonly ReservationId $id,
        private readonly ServiceId     $serviceId,
        private readonly int           $scheduleId,
        private readonly ClientName    $clientName,
        private readonly ClientEmail   $clientEmail,
        private readonly string        $reservedDay,
        private readonly string        $reservedTime,
        private readonly ServiceName   $serviceName,
        private readonly ServicePrice  $servicePrice,
        private readonly DateTime      $createdAt
    )
    {
    }

    public static function create(ReservationId $id, ServiceId $serviceId, int $scheduleId, ClientName $clientName, ClientEmail $clientEmail, string $reservedDay, string $reservedTime,
                                  ServiceName   $serviceName, ServicePrice $servicePrice, DateTime $createdAt): self
    {
        $reservation = new self($id, $serviceId, $scheduleId, $clientName, $clientEmail, $reservedDay, $reservedTime, $serviceName, $servicePrice, $createdAt);
        $reservation->record(new ReservationCreatedEvent(
            $id->value(),
            $serviceId->value(),
            $scheduleId,
            $clientName->value(),
            $clientEmail->value(),
            $reservedDay,
            $reservedTime,
            $serviceName->value(),
            $servicePrice->value(),
            $createdAt->format('Y-m-d H:i:s')
        ));

        return $reservation;
    }

}
