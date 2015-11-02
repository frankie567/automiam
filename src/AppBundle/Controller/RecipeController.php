<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $recipes = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findBy(array("user" => $this->getUser()));

        return array(
            "recipes" => $recipes
        );
    }
    
    /**
     * @Route("/new", name="recipe_new_route")
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
     * @Route("/edit/{slug}", name="recipe_edit_route")
     * @ParamConverter("recipe", class="AppBundle:Recipe")
     * @Security("is_granted('edit', recipe)")
     * @Template()
     */
    public function editRecipeAction($recipe, Request $request)
    {
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
            "recipe" => $recipe,
            "form" => $form->createView()
        );
    }

    /**
     * @Route("/delete/{slug}", name="recipe_delete_route")
     * @ParamConverter("recipe", class="AppBundle:Recipe")
     * @Security("is_granted('edit', recipe)")
     */
    public function deleteRecipeAction($recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();
        
        return $this->redirect($this->generateURL('recipe_view_recipes_route'));
    }

}
