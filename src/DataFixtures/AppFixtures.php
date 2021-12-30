<?php

namespace App\DataFixtures;

use App\Factory\DepartamentoFactory;
use App\Factory\EmpleadoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $secretario = EmpleadoFactory::new()->create([
                                           'nombre' => 'Secretario',
                                           'apellidos' => 'IES',
                                           'secretario' => true
                                       ]);
        $ordenanza = EmpleadoFactory::new()->create([
                                           'nombre' => 'Ordenanza',
                                           'apellidos' => 'IES',
                                           'ordenanza' => true
                                       ]);

        EmpleadoFactory::createMany(30);

        DepartamentoFactory::createMany(8, function() {
            return ['jefatura' => DepartamentoFactory::faker()->boolean(80) ? EmpleadoFactory::random() : null];
        });

        $manager->flush();
    }
}
