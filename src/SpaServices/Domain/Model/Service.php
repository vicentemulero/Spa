<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\Reservations\Domain\Model\Reservation;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Events\ServiceCreatedEvent;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


final class Service extends AggregateRoot
{
    private ServiceId $id;
    private ServiceName $name;
    private ServicePrice $price;
    private DateTime $createdAt;
    private Collection $serviceSchedules;
    private Collection $serviceReservations;


    public function __construct(
        ServiceId    $id,
        ServiceName  $name,
        ServicePrice $price,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->createdAt = new DateTime();
        $this->serviceSchedules = new ArrayCollection();
        $this->serviceReservations = new ArrayCollection();

    }

    public static function create(ServiceId $id, ServiceName $name, ServicePrice $price): self
    {
        $service = new self($id, $name, $price);
        $service->record(new ServiceCreatedEvent(
            $id->value(),
            $name->value(),
            $price->value(),
            $service->createdAt->format('Y-m-d H:i:s')
        ));

        return $service;
    }

    public function addServiceSchedules(DateTime $dayAvailable, DateTime $availableFrom, DateTime $availableTo): void
    {
        $current = clone $availableFrom;
        while ($current < $availableTo) {
            $this->serviceSchedules->add(new ServiceSchedule($this, $dayAvailable->format('d/m/Y'), $availableFrom->format('H:i'),
                $availableTo->format('H:i'), $current->format('H:i')));
            $current->modify('+1 hour');
        }
    }

    public function addServiceReservation(Reservation $reservation): void
    {
        $this->serviceReservations->add($reservation);
    }


    public function id(): ServiceId
    {
        return $this->id;
    }

    public function serviceSchedulesAvailableFilteredByDayAndTime(string $day, $time= null): ?Collection
    {
        return $this->serviceSchedules->filter(function ($schedule) use ($day, $time) {
            return $schedule->dayAvailable() == $day && (is_null($time) || $schedule->time() === $time) && $schedule->isAvailable() == true;
        });
    }

    public function name(): ServiceName
    {
        return $this->name;
    }

    public function price(): ServicePrice
    {
        return $this->price;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
