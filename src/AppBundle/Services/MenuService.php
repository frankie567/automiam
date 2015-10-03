<?php

namespace AppBundle\Services;

use AppBundle\Entity\DayMenu;
use AppBundle\Entity\MenuRecipe;

class MenuService
{
    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;
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
        
        foreach ($recipeSelectors as $recipeSelector)
        {
            $recipes = $recipeRepository->searchRecipes($recipeSelector["category"], $recipeSelector["tags"]);
            $recipe = $recipes[array_rand($recipes)];
            $dayMenu = $menu->getDayMenuById($recipeSelector["dayMenu"]);
            
            $menuRecipe = new MenuRecipe($recipe);
            $dayMenu->addMenuRecipe($menuRecipe);
        }
    }
}