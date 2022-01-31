<?php

namespace App\Factory;

use App\Entity\Departamento;
use App\Repository\DepartamentoRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Departamento>
 *
 * @method static Departamento|Proxy createOne(array $attributes = [])
 * @method static Departamento[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Departamento|Proxy find(object|array|mixed $criteria)
 * @method static Departamento|Proxy findOrCreate(array $attributes)
 * @method static Departamento|Proxy first(string $sortedField = 'id')
 * @method static Departamento|Proxy last(string $sortedField = 'id')
 * @method static Departamento|Proxy random(array $attributes = [])
 * @method static Departamento|Proxy randomOrCreate(array $attributes = [])
 * @method static Departamento[]|Proxy[] all()
 * @method static Departamento[]|Proxy[] findBy(array $attributes)
 * @method static Departamento[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Departamento[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DepartamentoRepository|RepositoryProxy repository()
 * @method Departamento|Proxy create(array|callable $attributes = [])
 */
final class DepartamentoFactory extends ModelFactory
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
            'descripcion' => self::faker()->text(20),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Departamento $departamento): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Departamento::class;
    }
}
