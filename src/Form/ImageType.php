<?php

// src/Form/ImageType.php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('altText', TextType::class)
            ->add('file', FileType::class, [
                'label' => 'Image file',
                'mapped' => false, // Do not map this field to the entity, it is handled by the service
                'required' => false,
            ])
            ->add('linkedService', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'placeholder' => 'Optional',
                'required' => false,
            ])
            ->add('linkedAnimal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'placeholder' => 'Optional',
                'required' => false,
            ])
            ->add('linkedHabitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'name',
                'placeholder' => 'Optional',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
