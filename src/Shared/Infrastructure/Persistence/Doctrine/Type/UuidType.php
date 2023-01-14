<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;


use App\Shared\Domain\Utils;
use App\Shared\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UuidType extends StringType
{
    protected function typeClassName(): string
    {
        return Uuid::class;
    }

    public function getName()
    {
        return self::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

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

    public static function customTypeName(): string
    {
        $explodedClassName = explode('\\', static::class);
        return Utils::toSnakeCase(str_replace('Type', '', end($explodedClassName)));
    }
}
