<?php

declare(strict_types=1);

namespace App\Health\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class DatabaseNotHealthyRepositoryException extends DomainError
{
    public function __construct()
    {
    }

    public function errorCode(): string
    {
        return '8001';
    }

    public function errorMessage(): string
    {
        return sprintf('Error: connection database repository');
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
