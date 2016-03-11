<?php

namespace WallBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class wallType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('admin', CheckboxType::class, array(
                'label' => 'Admin ?',
                'required' => false))
            ->add('typeSearch', ChoiceType::class, array(
                'choices'  => array(
                    'Keyword' => "keyword :",
                    '@' => "@",
                    '#' => "#",
                ),
                'choices_as_values' => true,))
            ->add('search')
            ->add('time');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WallBundle\Entity\wall'
        ));
    }
}
