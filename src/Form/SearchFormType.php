<?php

namespace App\Form;

use App\Entity\Medecins;
use App\Entity\Specialite;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom'
            ])


            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom'
            ]);
        // ->add('medecin', EntityType::class, [
        //     'class' => Medecins::class,
        //     'choice_label' => 'nom'
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
