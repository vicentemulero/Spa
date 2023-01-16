<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class ServiceAlreadyExistsException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 9300; // Internal code to identify the service already exist exception
    }

    public function errorMessage(): string
    {
        return sprintf('The service <%s> already exists', $this->value);
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

}
