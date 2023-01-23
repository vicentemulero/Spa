<?php

declare(strict_types=1);

namespace App\Reservations\Application\CreateReservation;


use App\Reservations\Domain\Model\ClientEmail;
use App\Reservations\Domain\Model\ClientName;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Shared\Domain\SpaValueObject\ServiceId;
use DateTime;

final class CreateReservationCommandHandler implements CommandHandlerInterface
{

    public function __construct(private readonly ReservationCreator $creator)
    {
    }

    public function __invoke(CreateReservationCommand $command)
    {
        $serviceId = new ServiceId($command->serviceId());
        $clientName = new ClientName($command->clientName());
        $clientEmail = new ClientEmail($command->clientEmail());
        $reservedDay = $command->reservedDay();
        $reservedTime = $command->reservedTime();
        $createdAt = new DateTime('now');

        $this->creator->__invoke($serviceId, $clientName, $clientEmail, $reservedDay, $reservedTime, $createdAt);
    }
}
