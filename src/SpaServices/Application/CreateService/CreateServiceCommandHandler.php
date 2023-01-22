<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateService;


use App\Shared\Domain\Bus\Command\CommandHandlerInterface;
use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\ServiceName;
use App\SpaServices\Domain\Model\ServicePrice;

final class CreateServiceCommandHandler implements CommandHandlerInterface
{

    public function __construct(private readonly ServiceCreator $creator)
    {
    }

    public function __invoke(CreateServiceCommand $command)
    {
        $id = new ServiceId($command->id());
        $name = new ServiceName($command->name());
        $price = new ServicePrice($command->price());

        $this->creator->__invoke($id, $name, $price);
    }
}
