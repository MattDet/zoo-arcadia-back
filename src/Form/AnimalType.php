<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Species;
use App\Entity\Habitat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Healthy' => 'healthy',
                    'Sick' => 'sick',
                    'Injured' => 'injured',
                ],
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a habitat',
            ])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a species',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
