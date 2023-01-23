<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServiceAvailability;

use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceSchedule;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;

final class ServiceAvailabilityFinder
{
    public function __construct(private readonly ServiceRepositoryInterface $repository)
    {
    }

    public function __invoke(ServiceId $id, string $day): array
    {
        $service = $this->repository->findById($id);

        if (null === $service) {
            throw new ServiceNotExistsException($id->value());
        }

        return $this->transformServiceScheduleAvailable($service, $day);
    }

    private function transformServiceScheduleAvailable(Service $service, string $day): array
    {
        $availabilities = $service->serviceSchedulesAvailableFilteredByDayAndTime($day);

        if (empty($availabilities)) {
            return [];
        }
        $timeAvailable = [["Service" => $service->name()->value()], ["Day" => $day]];

        /** @var ServiceSchedule $availability */
        foreach ($availabilities as $availability) {
            $timeAvailable[] = ["Available at -> " => $availability->availableTime()];
        }

        return $timeAvailable;
    }
}
