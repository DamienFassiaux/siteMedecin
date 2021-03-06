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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MedecinInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('prenom', TextType::class, [
                'required' => false
            ])
            ->add('telephone', TextType::class, [
                'required' => false
            ])
            ->add('centre_medical', TextType::class, [
                'required' => false
            ])
            ->add('adresse', TextType::class, [
                'required' => false
            ])
            ->add('code_postal', IntegerType::class, [
                'required' => false
            ])
            ->add('ville', TextType::class, [
                'required' => false
            ])
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'required' => false
            ])
            ->add('confirm_password', PasswordType::class, [
                'required' => false
            ])
            ->add('horaires', TextType::class, [
                'required' => false
            ])
            ->add('specialite',  EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom'
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom'
            ])

            ->add('image', FileType::class, [
                'label' =>"Photo du m??decin", 
                'mapped' => true, 
                'required' => false, 
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Extensions accept??es : jpg/jpeg/png '
                    ])
                ]
            ]);
        // ->add('roles', CollectionType::class, [
        //     'label_format' => 'Role medecin',
        //     'entry_type' => ChoiceType::class,
        //     'entry_options' => [
        //         'choices' => [
        //             'Utilisateur' => 'ROLE_DOC'
        //         ]
        //     ]
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecins::class,
             'validation_groups' => ['inscription'] 
        ]);
    }
}
