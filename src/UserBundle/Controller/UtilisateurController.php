<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Head;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     * @Get("/all", name="_utilisateur") 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('UserBundle:Utilisateur')->findAll();

        return array('users' => $utilisateurs);
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Post("/create", name="_utilisateur")
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('UserBundle\Form\UtilisateurType', $utilisateur);
        $form->submit($request->request->all());
        
        $em = $this->getDoctrine()->getManager();
        $roleRepository = $em->getRepository('UserBundle:CyRole');
       
        if ($form->isValid()) {           
            $utilisateur->setRoles(
                        $roleRepository->findById(
                                    $request->request->get('roles')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return array('message' => "added successfully");
        }
        
        return array('message' => "data not valid");
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Get("/find/{id}", name="_utilisateur")
     */
    public function showAction(Utilisateur $utilisateur)
    {
        return array('utilisateur' => $utilisateur);
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Post("/edit/{id}", name="_utilisateur")
     */
    public function editAction(Request $request, int $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('UserBundle:Utilisateur')->find($id);

        if ($utilisateur === null) {
            return array('message' => "user not found");
        }
        
        $em = $this->getDoctrine()->getManager();
        $roleRepository = $em->getRepository('UserBundle:CyRole');
        
        $form = $this->createForm('UserBundle\Form\UtilisateurType', $utilisateur);
        $form->submit($request->request->all(),false);

        if ($form->isValid()) {
            $utilisateur->setRoles(
                        $roleRepository->findById(
                                    $request->request->get('roles')));
            $this->getDoctrine()->getManager()->flush();
            return array('message' => "updated successfully");
        }
        return array('message' => "data not valid");
        
    }

    /**
     * Deletes a utilisateur entity.
     *
     * @Delete("/delete/{id}", name="_utilisateur")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        
        if(! $utilisateur) {
            return array('message' => "user not found");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($utilisateur);
        $em->flush();
        return array('message' => "user deleted");
        
    }    
}
