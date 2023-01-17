<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateServiceSchedule;

use App\Shared\Domain\Bus\Event\EventBus;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use App\SpaServices\Domain\Model\ServiceId;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;
use DateTime;

final class ServiceScheduleCreator
{

    public function __construct(
        private readonly ServiceRepositoryInterface $repository,
        private readonly EventBus                   $bus
    )
    {
    }

    public function __invoke(
        ServiceId    $id,
        DateTime $dayAvailable,
        DateTime $availableTo,
        DateTime $availableFrom
    ): void
    {
        $service= $this->repository->findById($id);

        if (null === $service) {
            throw new ServiceNotExistsException($id->value());
        }

        $service->addServiceSchedules($dayAvailable,$availableTo,$availableFrom);

        $this->repository->store($service);
        $this->bus->publish(...$service->pullDomainEvents());
    }
}

