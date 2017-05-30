<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Head;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Patch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\CyPermission;
use UserBundle\Entity\CyRole;

/**
 * Role controller.
 *
 */
class RoleController extends Controller {

    /**
     * Lists all Role entities.
     *
     * @Get("/all") 
     * 
     */
    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();

        $cyRoles = $em->getRepository('UserBundle:CyRole')->findAll();

        return array('roles' => $cyRoles);
    }

    /**
     * Creates a new Role entity.
     *
     * @Post("/create", name="_role")
     * 
     */
    public function createAction(Request $request) {
        
        $cyRole = new CyRole();
        $form = $this->createForm('UserBundle\Form\RoleType', $cyRole);
        $form->submit($request->request->all());
       
        $em = $this->getDoctrine()->getManager();
        $permissionRepository = $em->getRepository('UserBundle:CyPermission');
        
        if ($form->isValid()) {
            $cyRole->setPermissions(
                        $permissionRepository->findById(
                                    $request->request->get('permissions')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($cyRole);
            $em->flush();
            return array('message' => "added successfully");
        }
        return array('message' => "data not valid");
    }
    
    /**
     * Finds and displays a utilisateur entity.
     *
     * @Get("/find/{id}", name="_role")
     *
     */
    public function showAction(CyRole $cyRole)
    {
        return array('cyRole' => $cyRole);
    }

    /**
     * Edits an existing Role entity.
     *
     * @Post("/edit/{id}", name="_role")
     * 
     */
    public function editAction(Request $request, int $id) {
        
        $em = $this->getDoctrine()->getManager();
        $cyRole = $em->getRepository('UserBundle:CyRole')->find($id);
        
       
        $form = $this->createForm('UserBundle\Form\RoleType', $cyRole);
        $form->submit($request->request->all());

        $permissionRepository = $em->getRepository('UserBundle:CyPermission');
        
        if ($form->isValid()) {
            $cyRole->setPermissions(
                        $permissionRepository->findById(
                                    $request->request->get('permissions')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($cyRole);
            $em->flush();
            return array('message' => "updated successfully");
        }
        return array('message' => "data not valid");
    }

    /**
     * Deletes a Role entity.
     *
     * @Delete("/delete/{id}", name="_role")
     * 
     */
    public function deleteAction(Request $request, CyRole $role) {
        
        if(! $role) {
            return array('message' => "role not found");
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($role);
        $em->flush();
        
        return array('message' => "role deleted");
    }

    /*
      /**
     * Affecter les permissions aux rôles.
     *
     * @Route("/gestion", name="us_role_gestion" , options={"description" =  "المستخدمون : إدارة بيانات الأدوار : Affecter les routes aux roles "})
     * 
     */

    /*
      public function gestionAction(Request $request) {



      //Get all roles from database

      $roles = $this->getDoctrine()->getRepository('UserBundle:CyRole')->findAll();
      //Get all routes frome database
      $routes = array();
      $nvroutes = array();
      $em = $this->getDoctrine()->getManager();
      foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
      $permission = $this->getDoctrine()->getRepository('UserBundle:CyPermission')->findOneBy(array('path' => $name));
      if ($permission == null) {
      $permission = new CyPermission();
      $permission->setPath($name);
      $em->persist($permission);
      $permission->setVisible(2);
      $em->flush();
      $nvroutes[$name] = $permission;
      }
      $routes[$name] = $permission;
      }



      if ($request->isMethod('POST')) {

      $pathchecked = $request->request->get('pathchecked');
      $pathUnchecked = $request->request->get('pathUnchecked');
      if ($pathchecked != null) {
      foreach ($pathchecked as $roleid => $permissions) {
      $role = $this->getDoctrine()->getRepository('UserBundle:CyRole')->find($roleid);
      $permissionsrole = $role->getPermissions();
      foreach ($permissions as $permissionid => $val) {
      $permission = $this->getDoctrine()->getRepository('UserBundle:CyPermission')->find($permissionid);
      if (!in_array($permission, $permissionsrole)) {
      $role->addPermission($permission);
      $em->flush();
      }
      }
      }
      }
      if ($pathUnchecked != null) {
      foreach ($pathUnchecked as $roleid => $permissions) {
      $role = $this->getDoctrine()->getRepository('UserBundle:CyRole')->find($roleid);
      foreach ($permissions as $permissionid => $val) {
      $permission = $this->getDoctrine()->getRepository('UserBundle:CyPermission')->find($permissionid);
      $role->removePermission($permission);
      $em->flush();
      }
      }
      }
      $em->flush();
      }

      foreach ($roles as $role) {
      $tpermissionsdurole[$role->getNom()] = $role->getPermissions();
      }
      return $this->render('UserBundle:Role:GestionDesRoles.html.twig', array('roles' => $roles, 'routes' => $routes, 'nvroutes' => $nvroutes, 'tpermissionsdurole' => $tpermissionsdurole,
      ));
      }
     */
}
