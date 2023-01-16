<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\SpaServices\Domain\Model\ValueObjects\ServiceId;
use DateTime;

final class ServiceSchedule
{

    private ?int $id;
    private Service $service;
    private ServiceId $serviceId;
    private ?string $reservationId; //TODO Refactor to ReservationId
    private ?DateTime $reservationDate;
    private string $dayAvailable;
    private string $availableTo;
    private string $availableFrom;
    private string $timeAvailable;
    private bool $isAvailable;
    private DateTime $createdAt;
    private ?Datetime $updatedAt;


    public function __construct(
        Service        $service,
        string         $dayAvailable,
        string         $availableTo,
        string         $availableFrom,
        string         $timeAvailable
    )
    {
        $this->service = $service;
        $this->serviceId = $service->id();
        $this->dayAvailable = $dayAvailable;
        $this->availableTo= $availableTo;
        $this->availableFrom = $availableFrom;
        $this->timeAvailable = $timeAvailable;
        $this->reservationId = null;
        $this->reservationDate = null;
        $this->isAvailable = true;
        $this->createdAt = new DateTime('now');
        $this->updatedAt = null;
    }

    public function id(): int
    {
        return $this->id;
    }
}
