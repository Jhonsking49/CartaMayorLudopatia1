<?php

namespace App\Form;

use App\Entity\Boleto;
use App\Entity\Sorteo;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoletoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('propietario', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('sorteo', EntityType::class, [
                'class' => Sorteo::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boleto::class,
        ]);
    }
}
