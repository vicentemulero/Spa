<?php

declare(strict_types=1);

namespace App\Health\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class DatabaseNotHealthyRepositoryException extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 8001; // Internal code to identify Health Error connection database repository
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
