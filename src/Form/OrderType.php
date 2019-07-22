<?php

namespace App\Form;

use App\Entity\Orders;
use App\Form\AddressType;
use App\Form\ProductType;
use App\Form\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('createdat')
            // ->add('updatedat')
            ->add('status')
            ->add('client')
            ->add('product')
            ->add('addressDelivery', AddressType::Class)
            ->add('product', ProductType::Class)
            ->add('client', ClientType::Class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
