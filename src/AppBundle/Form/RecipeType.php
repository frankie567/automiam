<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'automiam.recipe.new.name'
            ))
            ->add('recipe', null, array(
                'label' => 'automiam.recipe.new.recipe'
            ))
            ->add('category', null, array(
                'label' => 'automiam.recipe.new.category',
                'required' => true
            ))
            ->add('tags', null, array(
                'label' => 'automiam.recipe.new.tags',
                'required' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_recipe';
    }
}
