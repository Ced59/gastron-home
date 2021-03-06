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
            ->add('name', TextType::class,[
                'label'=>'Nom du Plat',
                'attr'=>[
                    'placeholder'=>'Entrez le nom du plat'
                ]
            ])
            ->add('price',TextType::class,[
                'label'=>'Prix',
                'attr'=>[
                    'placeholder'=>'Entrez le prix du plat'
                ]
            ])
            ->add('qte',IntegerType::class,[
                'label'=>'Quantité',
                'attr'=>[
                    'min'=> 0
                ]
                ])
            ->add('categoriePlats')
            ->add('description', TextType::class,[
                'label'=>'Description',
                'attr'=>[
                    'placeholder'=>'Entrez la description du plat'
                ]
                ])
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
