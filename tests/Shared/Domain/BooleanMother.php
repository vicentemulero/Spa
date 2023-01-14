<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class BooleanMother
{
    public static function random(): bool
    {
        return MotherCreator::random()->boolean;
    }
}
