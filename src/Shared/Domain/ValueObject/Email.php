<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class Email
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function ensureIsValid(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('<%s> is not a valid email address', $value));
        }
    }
}
