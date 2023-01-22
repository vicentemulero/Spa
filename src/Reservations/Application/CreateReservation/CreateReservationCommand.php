<?php

declare(strict_types=1);

namespace App\Reservations\Application\CreateReservation;

use App\Shared\Domain\Bus\Command\CommandInterface;

final class CreateReservationCommand implements CommandInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $serviceId,
        private readonly string $clientName,
        private readonly string $clientEmail,
        private readonly string $reservedDay,
        private readonly string $reservedTime
    )
    {
    }


    public function id(): string
    {
        return $this->id;
    }

    public function serviceId(): string
    {
        return $this->serviceId;
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
}
