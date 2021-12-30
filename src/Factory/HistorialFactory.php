<?php

namespace App\Factory;

use App\Entity\Historial;
use App\Repository\HistorialRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Historial>
 *
 * @method static Historial|Proxy createOne(array $attributes = [])
 * @method static Historial[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Historial|Proxy find(object|array|mixed $criteria)
 * @method static Historial|Proxy findOrCreate(array $attributes)
 * @method static Historial|Proxy first(string $sortedField = 'id')
 * @method static Historial|Proxy last(string $sortedField = 'id')
 * @method static Historial|Proxy random(array $attributes = [])
 * @method static Historial|Proxy randomOrCreate(array $attributes = [])
 * @method static Historial[]|Proxy[] all()
 * @method static Historial[]|Proxy[] findBy(array $attributes)
 * @method static Historial[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Historial[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static HistorialRepository|RepositoryProxy repository()
 * @method Historial|Proxy create(array|callable $attributes = [])
 */
final class HistorialFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $fechaDevolucion = self::faker()->dateTimeBetween('-1 year', '-2 months');
        $fechaPrestamo = self::faker()->dateTimeBetween('-13 months', $fechaDevolucion);

        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'llave' => LlaveFactory::random(),
            'prestadaA' => EmpleadoFactory::random(),
            'fechaHoraPrestamo' => \DateTimeImmutable::createFromMutable($fechaPrestamo),
            'fechaHoraDevolucion' => \DateTimeImmutable::createFromMutable($fechaDevolucion),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Historial $historial): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Historial::class;
    }
}
