<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class ServicesNotExistsException extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return "no_services";
    }

    public function errorMessage(): string
    {
        return sprintf('No services');
    }

    public function errorStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
