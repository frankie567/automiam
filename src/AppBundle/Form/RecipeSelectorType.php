<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Validator\Constraints\RecipeExists;

class RecipeSelectorType extends AbstractType
{
    private $translator;
    
    public function __construct($translator)
    {
        $this->translator = $translator;
    }
    
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
                'label' => false,
                'required' => true,
                'placeholder' => 'automiam.menu.edit.select_category',
                
            ))
            ->add('tags', 'entity', array(
                'class' => 'AppBundle:Tag',
                'label' => false,
                'multiple' => true,
                'required' => false,
                'attr' => array('data-placeholder' => $this->translator->trans('automiam.menu.edit.tags'))
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'constraints'=> new RecipeExists(),
            'error_bubbling' => false
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
