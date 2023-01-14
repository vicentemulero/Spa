<?php declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class FloatMother
{
    public static function random(): float
    {
        return MotherCreator::random()->randomFloat(2);
    }
}
