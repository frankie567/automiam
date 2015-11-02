<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecipeExistsValidator extends ConstraintValidator
{
    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public function validate($value, Constraint $constraint)
    {
        $recipeRepository = $this->em->getRepository("AppBundle:Recipe");
        $recipes = $recipeRepository->searchRecipes($value["category"], $value["tags"]);
        if (count($recipes) == 0)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
