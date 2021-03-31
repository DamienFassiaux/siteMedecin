<?php

namespace App\Form;

use App\Entity\Medecins;
use App\Entity\Specialite;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
                    'choice_label' => 'nom' ])
            ->add('image', FileType::class, [
                        'label' =>"Photo du médecin", 
                        'mapped' => true, 
                        'required' => false ,
                        'constraints' => [
                            new File([
                                'maxSize' => '2M',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'image/jpg'
                                ],
                                'mimeTypesMessage'=> ['Extensions acceptées : jpg/jpeg/png ']
                           ])
                        
            ]]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecins::class,
            //'validation_groups' => ['inscription'] 
        ]);
    }
}
