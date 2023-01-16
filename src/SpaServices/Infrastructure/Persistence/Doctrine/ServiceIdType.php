<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Persistence\Doctrine;

use App\Shared\Infrastructure\Persistence\Doctrine\Type\UuidType;
use App\SpaServices\Domain\Model\ServiceId;

final class ServiceIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ServiceId::class;
    }
}
