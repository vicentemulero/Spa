<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateServiceSchedule;

use App\Shared\Domain\Bus\Command\CommandInterface;

final class CreateServiceScheduleCommand implements CommandInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $dayAvailable,
        private readonly string $availableFrom,
        private readonly string $availableTo
    )
    {
    }


    public function id(): string
    {
        return $this->id;
    }

    public function dayAvailable(): string
    {
        return $this->dayAvailable;
    }

    public function availableFrom(): string
    {
        return $this->availableFrom;
    }

    public function availableTo(): string
    {
        return $this->availableTo;
    }
}
