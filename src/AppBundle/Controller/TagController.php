<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Tag;

/**
 * @Route("/tags")
 * @Security("has_role('ROLE_USER')")
 */
class TagController extends Controller
{
    /**
     * @Route("/new", name="tag_new_route")
     */
    public function newTagAction(Request $request)
    {
        if ($request->getMethod() == "POST")
        {
            $tag = new Tag($request->request->get('tagLabel'));
            
            $em = $this->getDoctrine()->getManager();

            $em->persist($tag);
            $em->flush();
        
            $response = new JsonResponse();
            $response->setData(array(
                'valid' => true,
                'tagId' => $tag->getId()
            ));
            
            return $response;
        }
    }
}
