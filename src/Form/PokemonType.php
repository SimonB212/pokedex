<?php

namespace App\Form;

use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('pokedexNumber')
            ->add('primaryType', ChoiceType::class, [
                'mapped'=>false,
                'choices' => [
                    'Bug' => 'Bug',
                    'Dark' => 'Dark',
                    'Dragon' => 'Dragon',
                    'Electric' => 'Electric',
                    'Fairy' => 'Fairy',
                    'Fighting' => 'Fighting',
                    'Fire' => 'Fire',
                    'Flying' => 'Flying',
                    'Ghost' => 'Ghost',
                    'Grass' => 'Grass',
                    'Ground' => 'Ground',
                    'Ice' => 'Ice',
                    'Normal' => 'Normal',
                    'Poison' => 'Poison',
                    'Psychic' => 'Psychic',
                    'Rock' => 'Rock',
                    'Steel' => 'Steel',
                    'Water' => 'Water',
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'label' => 'Type primaire',
            ])
            ->add('secondaryType', ChoiceType::class, [
            'mapped'=>false,
            'choices' => [
                'None' => null,
                'Bug' => 'Bug',
                'Dark' => 'Dark',
                'Dragon' => 'Dragon',
                'Electric' => 'Electric',
                'Fairy' => 'Fairy',
                'Fighting' => 'Fighting',
                'Fire' => 'Fire',
                'Flying' => 'Flying',
                'Ghost' => 'Ghost',
                'Grass' => 'Grass',
                'Ground' => 'Ground',
                'Ice' => 'Ice',
                'Normal' => 'Normal',
                'Poison' => 'Poison',
                'Psychic' => 'Psychic',
                'Rock' => 'Rock',
                'Steel' => 'Steel',
                'Water' => 'Water',
            ],
            'expanded' => false,
            'multiple' => false,
            'required' => true,
            'label' => 'Type secondaire',
            ])
            ->add('favorite')
            ->add('image', FileType::class, [
                'label' => 'Photo du bien',
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un PNG ou un JPEG',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
