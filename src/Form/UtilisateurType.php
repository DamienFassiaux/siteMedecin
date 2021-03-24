<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email')
        ->add('roles', CollectionType::class, [  
            'label_format' => 'Role utilisateur',
            'entry_type' => ChoiceType::class,  
            'entry_options' => [
                'choices' => [
                    'Utilisateur'=> 'ROLE_USER',
                    'Administrateur'=> 'ROLE_ADMIN'
                ]
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
