<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_ville', TextType::class,[
                'label'=>'Nom de la ville',
                'attr'=>[
                    'placeholder'=>'Entrez le nom de la ville'
                ]
            ])
            ->add('Secteur')
            ->add('code_postal', TextType::class,[
                'label'=>'Code Postal',
                'attr'=>[
                    'placeholder'=>'Entrez le code postal de la ville'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
