<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('linkedin', TextType::class, [
                'required' => false,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('git', TextType::class, [
                'required' => false,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('website', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('about_me', TextareaType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('contact', TextareaType::class, [
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
            'data_class' => User::class,
        ]);
    }
}
