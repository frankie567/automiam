<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class RecipeExists extends Constraint
{
    public $message = 'automiam.menu.edit.recipe_not_found';
    
    public function validatedBy()
    {
        return 'recipe_exists_validator';
    }
}
