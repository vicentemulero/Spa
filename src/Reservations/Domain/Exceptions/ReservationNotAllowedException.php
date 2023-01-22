<?php

declare(strict_types=1);

namespace App\Reservations\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class ReservationNotAllowedException extends DomainError
{
    public function __construct(private readonly string $serviceId,private readonly string $reservedTime)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return "reservation_not_allowed";
    }

    public function errorMessage(): string
    {
        return sprintf('The reservation for the service <%s> at time <%s> is not allowed', $this->serviceId, $this->reservedTime);
    }

    public function errorStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
