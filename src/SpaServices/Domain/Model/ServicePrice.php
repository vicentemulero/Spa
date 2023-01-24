<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Model;

use App\Shared\Domain\ValueObject\FloatValueObject;

final class ServicePrice extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
