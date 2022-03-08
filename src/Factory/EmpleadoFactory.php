<?php

namespace App\Factory;

use App\Entity\Empleado;
use App\Repository\EmpleadoRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Empleado>
 *
 * @method static Empleado|Proxy createOne(array $attributes = [])
 * @method static Empleado[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Empleado|Proxy find(object|array|mixed $criteria)
 * @method static Empleado|Proxy findOrCreate(array $attributes)
 * @method static Empleado|Proxy first(string $sortedField = 'id')
 * @method static Empleado|Proxy last(string $sortedField = 'id')
 * @method static Empleado|Proxy random(array $attributes = [])
 * @method static Empleado|Proxy randomOrCreate(array $attributes = [])
 * @method static Empleado[]|Proxy[] all()
 * @method static Empleado[]|Proxy[] findBy(array $attributes)
 * @method static Empleado[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Empleado[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmpleadoRepository|RepositoryProxy repository()
 * @method Empleado|Proxy create(array|callable $attributes = [])
 */
final class EmpleadoFactory extends ModelFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'nombre' => self::faker()->firstName(),
            'apellidos' => self::faker()->lastName() . ' ' . self::faker()->lastName(),
            'ordenanza' => false,
            'secretario' => false,
            'nombreUsuario' => self::faker()->unique()->userName(),
            'clave' => $this->userPasswordEncoder->encodePassword(new Empleado(), 'pordefecto')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Empleado $empleado): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Empleado::class;
    }
}
