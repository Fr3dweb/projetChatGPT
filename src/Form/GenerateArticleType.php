<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', TextType::class, [
                'label' => 'Posez votre question ou détaillez votre sujet d\'article ci-dessous.',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer <img class="htmx-indicator" src="/assets/loader.svg"/>' ,
                'label_html' => true,
                'attr' => [
                    'hx-post' => '/',
                    'hx-target' => '#response',
                    'class' => 'btnGenArticle'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
