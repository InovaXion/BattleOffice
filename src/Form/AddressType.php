<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address_line1')
            ->add('address_line2')
            ->add('city')
            ->add('zipcode')
            ->add('country', ChoiceType::Class, [
                'choices' => [
                    '' => '',
                    'France' => 'France',
                    'Belgique' => 'Belgique',
                    'Luxembourg' => 'Luxembourg'

                ],
            ])
            ->add('phone')
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
