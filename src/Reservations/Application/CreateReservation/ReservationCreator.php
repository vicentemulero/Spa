<?php

declare(strict_types=1);

namespace App\Reservations\Application\CreateReservation;

use App\Reservations\Domain\Exceptions\ReservationNotAllowedException;
use App\Reservations\Domain\Model\ClientEmail;
use App\Reservations\Domain\Model\ClientName;
use App\Reservations\Domain\Model\Reservation;
use App\Reservations\Domain\Repository\ReservationRepositoryInterface;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\SpaValueObject\ReservationId;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use App\SpaServices\Domain\Model\ServiceSchedule;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;
use DateTime;

final class ReservationCreator
{

    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository,
        private readonly ServiceRepositoryInterface     $serviceRepository,
        private readonly EventBus                       $bus
    )
    {
    }

    public function __invoke(
        ReservationId $id,
        ServiceId     $serviceId,
        ClientName    $clientName,
        ClientEmail   $clientEmail,
        string        $reservedDay,
        string        $reservedTime,
        DateTime      $createdAt
    ): void
    {
        $service = $this->serviceRepository->findById($serviceId);

        if (null === $service) {
            throw new ServiceNotExistsException($serviceId->value());
        }

        $availableHoursFound = $service->serviceSchedulesAvailableFilteredByDayAndTime($reservedDay, $reservedTime);

        if (empty($availableHoursFound)) {
            throw new ReservationNotAllowedException($serviceId->value(), $reservedTime);
        }

        /** @var ServiceSchedule $availableServiceSchedule */
        $availableServiceSchedule= $availableHoursFound->first();

        $reservation = Reservation::create(
            $id,
            $serviceId,
            $availableServiceSchedule->id(),
            $clientName,
            $clientEmail,
            $availableServiceSchedule->dayAvailable(),
            $availableServiceSchedule->availableTime(),
            $service->name(),
            $service->price(),
            $createdAt);

        $availableServiceSchedule->disableAvailability();
        $availableServiceSchedule->setReservationId($id);
        $availableServiceSchedule->setUpdatedAt(new DateTime('now'));
        $service->addServiceReservation($reservation);

        $this->reservationRepository->store($reservation);
        $this->serviceRepository->store($service);
        $this->bus->publish(...$service->pullDomainEvents());
    }
}

