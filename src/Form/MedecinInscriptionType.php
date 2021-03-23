<?php

namespace App\Form;

use App\Entity\Medecins;
use App\Entity\Specialite;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('centre_medical')
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('email')
            ->add('password')
            ->add('confirm_password')
            ->add('horaires')
            ->add('specialite',  EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom'
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecins::class,
        ]);
    }
}
