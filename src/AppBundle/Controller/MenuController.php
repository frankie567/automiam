<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Menu;
use AppBundle\Form\MenuType;

use AppBundle\Form\RecipeSelectorsType;

/**
 * @Route("/menus")
 * @Security("has_role('ROLE_USER')")
 */
class MenuController extends Controller
{
    /**
     * @Route("/new", name="menu_new_route")
     * @Template()
     */
    public function newMenuAction(Request $request)
    {
        $menus = $this->getDoctrine()->getRepository('AppBundle:Menu')->findBy(array("user" => $this->getUser()));
        
        $menu = new Menu($this->getUser());
        $form = $this->createForm(new MenuType(), $menu);
        
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            
            // TODO : Should be in an event
            $menuService = $this->get('automiam.menu');
            $menuService->prepareDayMenus($menu);

            $em->persist($menu);
            $em->flush();
            
            return $this->redirect($this->generateURL('menu_edit_route', array('id' => $menu->getId())));
        }
        
        return array(
            "menus" => $menus,
            "form" => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", name="menu_edit_route")
     * @ParamConverter("menu", class="AppBundle:Menu")
     * @Security("is_granted('edit', menu)")
     * @Template()
     */
    public function editMenuAction($menu, Request $request)
    {   
        $recipeSelectors = array();
        $form = $this->createForm(new RecipeSelectorsType(), $recipeSelectors);
        
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $recipeSelectors = $form->getData()["recipeSelector"];
            
            // TODO : Should be in an event
            $menuService = $this->get('automiam.menu');
            $menuService->computeRecipes($menu, $recipeSelectors);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            return $this->redirect($this->generateURL('menu_edit_route', array('id' => $menu->getId())));
        }

        return array(
            "menu" => $menu,
            "form" => $form->createView()
        );
    }
    
    /**
     * @Route("/edit/{id}/remove/{menuRecipeId}", name="remove_menu_recipe_route")
     * @ParamConverter("menu", class="AppBundle:Menu")
     * @ParamConverter("menuRecipe", class="AppBundle:MenuRecipe", options={"id" = "menuRecipeId"})
     * @Security("is_granted('edit', menu)")
     */
    public function removeMenuRecipeAction($menu, $menuRecipe, Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $em->remove($menuRecipe);
        $em->flush();
        
        return new Response("OK");
    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteMenuAction()
    {
        return array(
                // ...
            );    }

}
