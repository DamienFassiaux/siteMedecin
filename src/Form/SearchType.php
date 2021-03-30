<?php

namespace App\Form;

use App\Entity\Medecins;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Specialite;
use App\Entity\Departement;



class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom'
            ])
               
            
            ->add('departement', EntityType::class, [
                'required' => false,
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
