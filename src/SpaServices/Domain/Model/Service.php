<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\SpaServices\Domain\Events\ServiceCreatedEvent;
use App\SpaServices\Domain\Model\ValueObjects\ServiceId;
use App\SpaServices\Domain\Model\ValueObjects\ServiceName;
use App\SpaServices\Domain\Model\ValueObjects\ServicePrice;
use DateInterval;
use DatePeriod;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;


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

    private function addServiceSchedules(DateTime $dayAvailable, DateTime $availableTo, DateTime $availableFrom): void
    {
        $interval = new DateInterval('PT1H');
        $timesAvailable = new DatePeriod($availableTo, $interval, $availableFrom);
        foreach ($timesAvailable as $time) {
            $this->serviceSchedules->add(new ServiceSchedule($this, $dayAvailable->format('d:m:Y'), $availableTo->format('H:i:s'),
                $availableFrom->format('H:i:s'), $time->format('H:i:s')));
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
