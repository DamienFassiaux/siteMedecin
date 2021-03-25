<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EditUserType extends AbstractType
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
            ->add('adresse',TextType::class,[
                'required'=>false])
            ->add('code_postal',IntegerType::class,[
                'required'=>false])
            ->add('ville',TextType::class,[
                'required'=>false])
                ->add('email', TextType::class,[
                    'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
