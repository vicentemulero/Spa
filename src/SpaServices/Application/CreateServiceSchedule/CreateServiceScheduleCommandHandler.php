<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateServiceSchedule;


use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\SpaServices\Domain\Model\ServiceId;
use DateTime;

final class CreateServiceScheduleCommandHandler implements CommandHandlerInterface
{

    public function __construct(private readonly ServiceScheduleCreator $creator)
    {
    }

    public function __invoke(CreateServiceScheduleCommand $command)
    {
        $id = new ServiceId($command->id());
        $dayAvailable = DateTime::createFromFormat("d/m/Y", $command->dayAvailable());
        $availableFrom = DateTime::createFromFormat("H:i", $command->availableFrom());
        $availableTo = DateTime::createFromFormat("H:i", $command->availableTo());

        $this->creator->__invoke($id, $dayAvailable, $availableTo, $availableFrom);
    }
}
