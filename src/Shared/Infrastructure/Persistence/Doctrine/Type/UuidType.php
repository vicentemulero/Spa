<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;


use App\Shared\Domain\Utils;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use function Lambdish\Phunctional\last;

abstract class UuidType extends StringType implements DoctrineCustomType
{

    abstract protected function typeClassName(): string;

    public static function customTypeName(): string
    {
        return Utils::toSnakeCase(str_replace('Type', '', (string) last(explode('\\', static::class))));
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {

        if ($value instanceof Uuid) {
            return $value->value();
        }

        return $value;
    }
}
