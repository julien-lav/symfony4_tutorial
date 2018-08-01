<?php

namespace App\Form;

use App\Entity\Tutorial;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Form\TutorialType;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Form\CategoryType;


class AdminTutorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('link')
            ->add('createdAt', DateType::class, array(
                                    'widget' => 'single_text',
                                    'html5' => false,
                                    'attr' => [
                                    'class' => 'datepicker',
                                    'placeholder' => '31/12/2017',
                                    ],
                                    'format' => 'dd/MM/yyyy',))
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label'=> 'name',
                ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tutorial::class,
        ]);
    }
}
