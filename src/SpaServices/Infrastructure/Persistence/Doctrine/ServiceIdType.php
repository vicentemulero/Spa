<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\SpaValueObject\ServiceId;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\UuidType;

final class ServiceIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ServiceId::class;
    }
}
