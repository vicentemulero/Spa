<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\Shared\Domain\Aggregate\AggregateRoot;
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
    }

    public static function create(ServiceId $id, ServiceName $name, ServicePrice $price): Service
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

    public function serviceSchedules(): Collection
    {
        return $this->serviceSchedules;
    }

    public function id(): ServiceId
    {
        return $this->id;
    }

}
