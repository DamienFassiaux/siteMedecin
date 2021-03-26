<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Entity\Medecins;
use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('horaires');
        // ->add('utilisateurs',  EntityType::class, [
        //     'class' => Utilisateurs::class,
        //     'choice_label' => 'nom'
        // ])
        // ->add('medecins', EntityType::class, [
        //     'class' => Medecins::class,
        //     'choice_label' => 'nom'
        // ]);
        //->add('medecins');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
