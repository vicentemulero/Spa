<?php declare(strict_types=1);

namespace App\Shared\Domain;

use DomainException;

abstract class DomainError extends DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract public function errorCode(): int;

    abstract protected function errorMessage(): string;
}
