<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 07/03/19
 * Time: 19:51
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Contact;


class ContactType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre nom'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre adresse mail'
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => false,
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'Le sujet du message'
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre message',
                    'cols' => 30,
                    'rows' => 10
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}