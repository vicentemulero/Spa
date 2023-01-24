<?php

declare(strict_types=1);

namespace App\Reservations\Domain\Repository;

use App\Reservations\Domain\Model\Reservation;

interface ReservationRepositoryInterface
{
    public function store(Reservation $reservation): void;

}
