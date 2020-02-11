<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DependenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción'
            ])
            ->add('responsables', EntityType::class, [
                'label' => 'Personas responsables de la dependencia',
                'class' => Usuario::class,
                'disabled' => $options['modificar_responsables'] === false,
                'multiple' => true,
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dependencia::class,
            'modificar_responsables' => false
        ]);
    }

}
