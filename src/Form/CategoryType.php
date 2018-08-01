<?php
// src/Form/CategoryType.php
namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, array(
                'choices' => array(
                    'Symfony' => 1,
                    'React/Vue.js' => 2,
                    'Php'   => 3,
                    'Javascipt'   => 4,
                    'Html/CSS'   => 5,
                    'Other'   => 6,
            ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Category::class,
        ));
    }
}