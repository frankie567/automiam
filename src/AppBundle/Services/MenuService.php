<?php

namespace AppBundle\Services;

use AppBundle\Entity\DayMenu;
use AppBundle\Entity\MenuRecipe;
use AppBundle\Entity\Recipe;

class MenuService
{
    private $em;
    private $tokenStorage;
    
    public function __construct($em, $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }
    
    /* Create a DayMenu for each day (if not already done) */
    public function prepareDayMenus($menu)
    {
        if (count($menu->getDayMenus()) == 0)
        {
            $currentDate = clone $menu->getBeginDate();
            while ($currentDate <= $menu->getEndDate())
            {
                $dayMenu = new DayMenu();
                $dayMenu->setDay(clone $currentDate);
                $dayMenu->setMenu($menu);
                
                $currentDate->add(new \DateInterval('P1D'));
            }
        }
    }
    
    /* Compute recipes given the parameters */
    public function computeRecipes($menu, $recipeSelectors)
    {
        $recipeRepository = $this->em->getRepository("AppBundle:Recipe");
        
        foreach ($recipeSelectors as $index => $recipeSelector)
        {
            $foundRecipes = $recipeRepository->searchRecipes($this->tokenStorage->getToken()->getUser(), $recipeSelector["category"], $recipeSelector["tags"]);
            
            /* Try to take not already used recipes */
            $recipes = Recipe::substractSets($foundRecipes, $menu->getAllRecipes());
            if (count($recipes) == 0)
            {
                $recipes = $foundRecipes;
            }
            
            /* Take a random recipe from the set */
            $recipe = $recipes[array_rand($recipes)];
            
            /* Add it to the menu */
            $menuRecipe = new MenuRecipe($recipe);
            $dayMenu = $menu->getDayMenuById($recipeSelector["dayMenu"]);
            $dayMenu->addMenuRecipe($menuRecipe);
        }
    }
}