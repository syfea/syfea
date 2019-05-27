<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('underTitle', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('position', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
