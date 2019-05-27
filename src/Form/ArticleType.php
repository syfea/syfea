<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 12/05/19
 * Time: 11:34
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Service\Api;

class ArticleType extends abstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $api = new Api();
        $images = $api->getImages();

        $select[""] = "";
        foreach ($images as $image) {
            $select[$api->getApiSyfea().$image->contentUrl] = "/media_objects/".$image->id;
        }
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('content', CKEditorType::class, [
                'required' => true,
                'config' => array(
                    'uiColor' => '#ffffff',
                ),
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('priority', NumberType::class, [
                'required' => true,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ])
            ->add('image', ChoiceType::class, [
                'required' => false,
                'choices'  => $select,
                'attr'  => [
                    'class' => 'form-control',
                ],
            ]);
    }
}