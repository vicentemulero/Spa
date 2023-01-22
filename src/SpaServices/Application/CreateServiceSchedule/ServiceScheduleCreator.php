<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateServiceSchedule;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use App\SpaServices\Domain\Exceptions\ServiceScheduleAlreadyDefined;
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
        ServiceId $id,
        DateTime  $dayAvailable,
        DateTime  $availableTo,
        DateTime  $availableFrom
    ): void
    {
        $service = $this->repository->findById($id);

        if (null === $service) {
            throw new ServiceNotExistsException($id->value());
        }

        empty($service->serviceSchedulesAvailableFilteredByDayAndTime($dayAvailable->format('d/m/Y'))) ?
            $service->addServiceSchedules($dayAvailable, $availableFrom, $availableTo) :
            throw new ServiceScheduleAlreadyDefined($dayAvailable->format('d/m/Y'));

        $this->repository->store($service);
        $this->bus->publish(...$service->pullDomainEvents());
    }
}

