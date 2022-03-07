<?php

namespace App\DataFixtures;

use App\Factory\DepartamentoFactory;
use App\Factory\EmpleadoFactory;
use App\Factory\HistorialFactory;
use App\Factory\LlaveFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $secretario = EmpleadoFactory::new()->create([
                                           'nombre' => 'Secretario',
                                           'apellidos' => 'IES',
                                           'secretario' => true,
                                           'nombreUsuario' => 'secretario'
                                       ]);
        $ordenanza = EmpleadoFactory::new()->create([
                                           'nombre' => 'Ordenanza',
                                           'apellidos' => 'IES',
                                           'ordenanza' => true,
                                           'nombreUsuario' => 'ordenanza'
                                       ]);
        $docente = EmpleadoFactory::new()->create([
                                           'nombre' => 'Docente',
                                           'apellidos' => 'IES',
                                           'docente' => true,
                                           'nombreUsuario' => 'docente'
                                       ]);

        EmpleadoFactory::createMany(30);

        DepartamentoFactory::createMany(8, function() {
            return ['jefatura' => DepartamentoFactory::faker()->boolean(80) ? EmpleadoFactory::random() : null];
        });

        LlaveFactory::createMany(100, function() use ($ordenanza) {
            $item = [
                'departamento' => LlaveFactory::faker()->boolean(80) ? DepartamentoFactory::random() : null
            ];
            if (LlaveFactory::faker()->boolean(10)) {
                // llave prestada
                $item['disponible'] = true;
                $item['prestadaPor'] = $ordenanza;
                $item['prestadaA'] = EmpleadoFactory::random();
                $item['fechaHoraPrestamo'] = \DateTimeImmutable::createFromMutable(LlaveFactory::faker()->dateTimeBetween('-1 month', 'now'));
            }

            return $item;
        });

        HistorialFactory::createMany(200, [
            'prestadaPor' => $ordenanza,
        ]);

        $manager->flush();
    }
}
