<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\Reservations\Domain\Model\Reservation;
use App\Shared\Domain\SpaValueObject\ServiceId;
use DateTime;

class ServiceSchedule
{

    private ?int $id;
    private Service $service;
    private ServiceId $serviceId;
    private Reservation $reservation;
    private ?int $reservationId;
    private string $dayAvailable;
    private string $availableTo;
    private string $availableFrom;
    private string $availableTime;
    private bool $isAvailable;
    private DateTime $createdAt;
    private ?Datetime $updatedAt;

    public function __construct(
        Service $service,
        string  $dayAvailable,
        string  $availableFrom,
        string  $availableTo,
        string  $availableTime
    )
    {
        $this->service = $service;
        $this->serviceId = $service->id();
        $this->reservationId = null;
        $this->dayAvailable = $dayAvailable;
        $this->availableFrom = $availableFrom;
        $this->availableTo = $availableTo;
        $this->availableTime = $availableTime;
        $this->isAvailable = true;
        $this->createdAt = new DateTime('now');
        $this->updatedAt = null;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }


    public function dayAvailable(): string
    {
        return $this->dayAvailable;
    }

    public function availableTime(): string
    {
        return $this->availableTime;
    }

    public function disableAvailability(): void
    {
        $this->isAvailable = false;
    }

    public function setReservation(Reservation $reservation): void
    {
        $this->reservation = $reservation;
        $this->reservationId = $reservation->id();
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
