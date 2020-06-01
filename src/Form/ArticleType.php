<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'attr' => ['class' => 'form-control'],
                'config' => [
                    'toolbar' => 'basic',
                    'language' => 'fr',
                    'uiColor' => 'rgb(3, 23, 80)'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de couverture',
                'attr' => ['class' => 'form-control-file'],
                'required' => false,
                'empty_data' => ''
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Publier',
                'attr' => ['class' => 'btn btn-outline-light mt-4']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
