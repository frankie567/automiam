<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecipeExistsValidator extends ConstraintValidator
{
    private $em;
    private $tokenStorage;
    
    public function __construct($em, $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }
    
    public function validate($value, Constraint $constraint)
    {
        $recipeRepository = $this->em->getRepository("AppBundle:Recipe");
        $recipes = $recipeRepository->searchRecipes($this->tokenStorage->getToken()->getUser(), $value["category"], $value["tags"]);
        if (count($recipes) == 0)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
