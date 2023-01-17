<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class ServiceNotExistsException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return "service_not_exist";
    }

    public function errorMessage(): string
    {
        return sprintf('The Service with id <%s> does not exist', $this->value);
    }

    public function errorStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
