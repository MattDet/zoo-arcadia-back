<?php

namespace App\Form;

use App\Entity\VeterinaryReport;
use App\Entity\Animal;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VeterinaryReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class)
            ->add('date', DateType::class)
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an animal',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' => 'Choose a user',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VeterinaryReport::class,
        ]);
    }
}
