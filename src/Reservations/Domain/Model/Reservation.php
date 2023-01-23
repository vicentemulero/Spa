<?php

declare(strict_types=1);

namespace App\Reservations\Domain\Model;

use App\Reservations\Domain\Events\ReservationCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceName;
use App\SpaServices\Domain\Model\ServicePrice;
use App\SpaServices\Domain\Model\ServiceSchedule;
use DateTime;

class Reservation extends AggregateRoot
{
    private ?int $id;
    private Service $service;
    private ServiceSchedule $serviceSchedule;
    private ServiceId $serviceId;
    private int $scheduleId;
    private ClientName $clientName;
    private ClientEmail $clientEmail;
    private string $reservedDay;
    private string $reservedTime;
    private ServiceName $serviceName;
    private ServicePrice $servicePrice;
    private DateTime $createdAt;

    public function __construct(
        Service         $service,
        ServiceSchedule $serviceSchedule,
        ClientName      $clientName,
        ClientEmail     $clientEmail,
        string          $reservedDay,
        string          $reservedTime
    )
    {
        $this->service = $service;
        $this->serviceSchedule = $serviceSchedule;
        $this->serviceId = $service->id();
        $this->scheduleId = $serviceSchedule->id();
        $this->clientName = $clientName;
        $this->clientEmail = $clientEmail;
        $this->reservedDay = $reservedDay;
        $this->reservedTime = $reservedTime;
        $this->serviceName = $service->name();
        $this->servicePrice = $service->price();
        $this->createdAt = new DateTime();

    }

    public function id(): int
    {
        return $this->id;
    }

    public function forceDomainEvent(): void
    {
        $this->record(new ReservationCreatedEvent(
            $this->id(),
            $this->serviceId()->value(),
            $this->scheduleId(),
            $this->clientName()->value(),
            $this->clientEmail()->value(),
            $this->reservedDay(),
            $this->reservedTime(),
            $this->serviceName()->value(),
            $this->servicePrice()->value(),
            $this->createdAt()->format('Y-m-d H:i:s')
        ));

    }

    private function serviceId(): ServiceId
    {
        return $this->serviceId;
    }

    private function scheduleId(): int
    {
        return $this->scheduleId;
    }

    private function clientName(): ClientName
    {
        return $this->clientName;
    }

    private function clientEmail(): ClientEmail
    {
        return $this->clientEmail;
    }

    private function reservedDay(): string
    {
        return $this->reservedDay;
    }

    private function reservedTime(): string
    {
        return $this->reservedTime;
    }

    private function serviceName(): ServiceName
    {
        return $this->serviceName;
    }

    private function servicePrice(): ServicePrice
    {
        return $this->servicePrice;
    }

    private function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
