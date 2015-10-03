<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeSelectorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dayMenu', 'hidden', array(
            
            ))
            ->add('category', 'entity', array(
                'class' => 'AppBundle:Category',
                'label' => 'automiam.recipe.new.category',
                'empty_value' => 'automiam.recipe.new.select_category',
                'required' => true
            ))
            ->add('tags', 'entity', array(
                'class' => 'AppBundle:Tag',
                'label' => 'automiam.recipe.new.tags',
                'multiple' => true,
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
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_recipe_selector';
    }
}
