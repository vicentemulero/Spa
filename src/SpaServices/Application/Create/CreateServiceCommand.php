<?php

declare(strict_types=1);

namespace App\SpaServices\Application\Create;

use App\Shared\Domain\Bus\Command\CommandInterface;

final class CreateServiceCommand implements CommandInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly float $price
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }
}
