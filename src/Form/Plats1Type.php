<?php

namespace App\Form;

use App\Entity\Plats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class Plats1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label'=>'Nom du Plat'])
            ->add('price',TextType::class,['label'=>'Prix'])
            ->add('qte',IntegerType::class,['label'=>'Quantité'])
            ->add('categoriePlats')
            ->add('description', TextType::class,['label'=>'Description'])
            ->add('image', FileType::class, [
                'label' => 'Image de plat',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Seulement des fichiers de type .jpg, .jpeg ou png 2MB max.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plats::class,
        ]);
    }
}
