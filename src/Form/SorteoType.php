<?php

namespace App\Form;

use App\Entity\Sorteo;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SorteoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre',null,['label' => 'Nombre del sorteo: '])
            ->add('fechaFIN',null,['label' => 'Fecha cierre: '])
            ->add('precioBoleto',null,['label' => 'Precio de venta por boleto: '])
            ->add('numerosPosibles',null,['label' => 'Número de boletos a vender: '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorteo::class,
        ]);
    }
}
