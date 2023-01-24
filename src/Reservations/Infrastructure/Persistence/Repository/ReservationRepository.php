<?php

declare(strict_types=1);

namespace App\Reservations\Infrastructure\Persistence\Repository;

use App\Reservations\Domain\Model\Reservation;
use App\Reservations\Domain\Repository\ReservationRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class ReservationRepository extends DoctrineRepository implements ReservationRepositoryInterface
{
    public function store(Reservation $reservation): void
    {
        $this->persist($reservation);
    }
}
