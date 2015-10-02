<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Menu;
use AppBundle\Form\MenuType;

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
        $menu = new Menu($this->getUser());
        $form = $this->createForm(new MenuType(), $menu);
        
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($menu);
            $em->flush();
            
            return $this->redirect($this->generateURL('menu_edit_route', array('id' => $menu->getId())));
        }
        
        return array(
            "form" => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", name="menu_edit_route")
     * @ParamConverter("menu", class="AppBundle:Menu")
     * @Template()
     */
    public function editMenuAction($menu, Request $request)
    {
        $menuService = $this->get('automiam.menu');
        $menuService->prepareDayMenus($menu);
        
        return array(
            "menu" => $menu
        );
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