<?php

namespace App\Factory;

use App\Entity\Llave;
use App\Repository\LlaveRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Llave>
 *
 * @method static Llave|Proxy createOne(array $attributes = [])
 * @method static Llave[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Llave|Proxy find(object|array|mixed $criteria)
 * @method static Llave|Proxy findOrCreate(array $attributes)
 * @method static Llave|Proxy first(string $sortedField = 'id')
 * @method static Llave|Proxy last(string $sortedField = 'id')
 * @method static Llave|Proxy random(array $attributes = [])
 * @method static Llave|Proxy randomOrCreate(array $attributes = [])
 * @method static Llave[]|Proxy[] all()
 * @method static Llave[]|Proxy[] findBy(array $attributes)
 * @method static Llave[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Llave[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LlaveRepository|RepositoryProxy repository()
 * @method Llave|Proxy create(array|callable $attributes = [])
 */
final class LlaveFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'codigo' => self::faker()->unique()->numerify('######'),
            'descripcion' => self::faker()->text(60),
            'disponible' => self::faker()->boolean(90),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Llave $llave): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Llave::class;
    }
}
