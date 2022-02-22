<?php

namespace App\Form;

use App\Entity\Departamento;
use App\Entity\Llave;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LlaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo')
            ->add('descripcion', TextareaType::class)
            ->add('disponible')
            ->add('departamento', EntityType::class, [
                'class' => Departamento::class,
                'placeholder' => 'No asociado a departamento'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Llave::class
        ]);
    }
}
