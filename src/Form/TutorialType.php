<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Tutorial;
use App\Entity\Category;

use App\Form\UserType;
use App\Form\CategoryType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class TutorialType extends AbstractType
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
            
            //->add('category', CategoryType::class)
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label'=> 'name',
                ])

            //->add('user', UserType::class)
            /*->add('user', ChoiceType::class, array(
                            'choices'  => array(
                                'Maybe' => null,
                                 'Yes' => true,
                                 'No' => false,
                                )
                            ))*/
            /*->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'firstname',
                ])*/
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
