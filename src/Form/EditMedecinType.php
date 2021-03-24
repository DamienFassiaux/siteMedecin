<?php

namespace App\Form;

use App\Entity\Medecins;
use App\Entity\Specialite;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EditMedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'required'=>false])
            ->add('prenom',TextType::class,[
                'required'=>false])
            ->add('telephone',IntegerType::class,[
                'required'=>false])
            ->add('centre_medical',TextType::class,[
                'required'=>false])
            ->add('adresse',TextType::class,[
                'required'=>false])
            ->add('code_postal',IntegerType::class,[
                'required'=>false])
            ->add('ville',TextType::class,[
                'required'=>false])
            ->add('horaires',TextType::class,[
                'required'=>false])
            ->add('Specialite',  EntityType::class, [
                    'class' => Specialite::class,
                    'choice_label' => 'nom' ])
                ->add('Departement', EntityType::class, [
                    'class' => Departement::class,
                    'choice_label' => 'nom' ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecins::class,
        ]);
    }
}
