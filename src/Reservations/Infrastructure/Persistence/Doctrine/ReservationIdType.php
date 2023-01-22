<?php

declare(strict_types=1);

namespace App\Reservations\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\SpaValueObject\ReservationId;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\UuidType;

final class ReservationIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ReservationId::class;
    }
}
