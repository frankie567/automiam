<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;

/**
 * @Route("/recipes")
 * @Security("has_role('ROLE_USER')")
 */
class RecipeController extends Controller
{
    /**
     * @Route("/", name="recipe_view_recipes_route")
     * @Template()
     */
    public function viewRecipesAction()
    {
        $recipes = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findAll();

        return array(
            "recipes" => $recipes
        );
    }
    
    /**
     * @Route("/new")
     * @Template()
     */
    public function newRecipeAction(Request $request)
    {
        $recipe = new Recipe($this->getUser());
        $form = $this->createForm(new RecipeType(), $recipe);
        
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($recipe);
            $em->flush();
            
            return $this->redirect($this->generateURL('recipe_view_recipes_route'));
        }
        
        return array(
            "form" => $form->createView()
        );
    }

    /**
     * @Route("/edit")
     * @Template()
     */
    public function editRecipeAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteRecipeAction()
    {
        return array(
                // ...
            );    }

}
