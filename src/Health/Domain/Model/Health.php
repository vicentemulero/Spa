<?php

declare(strict_types=1);

namespace App\Health\Domain\Model;

class Health
{
    public function __construct(private int $status)
    {
    }
}
