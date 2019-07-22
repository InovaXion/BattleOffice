<?php

namespace App\Form;

use App\Entity\Clientdeliveryaddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('addressmore')
            ->add('city')
            ->add('postalcode')
            ->add('country')
            ->add('phonenumber')
            ->add('createdat')
            ->add('updatedat')
            ->add('client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clientdeliveryaddress::class,
        ]);
    }
}
