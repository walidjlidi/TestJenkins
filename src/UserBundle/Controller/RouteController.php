<?php

namespace UserBundle\Controller;

use UserBundle\Entity\CyPermission;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Route controller.
 *
 * @Route("/route",name="route")
 */
class RouteController extends Controller {

    /**
     * @Route("/", name="us_list_routes", options={"description" = "المستخدمون : إدارة بيانات حقوق العبور : قائمة حقوق العبور "})
     */
    public function ListRoutesAction() {


        $routes = array();
        $nvroutes = array();
        $em = $this->getDoctrine()->getManager();

        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            $existDesc = isset($route->getOptions()["description"]);
            $existvisible = isset($route->getOptions()["visible"]);
            $existgroupe = isset($route->getOptions()["groupe"]);
           
            $permission = $this->getDoctrine()->getRepository('UserBundle:CyPermission')->findOneBy(array('path' => $name));
            if ($permission == null) {
                $permission = new CyPermission();
                $permission->setPath($name);
                $permission->setVisible(2);
                if ($existDesc) {
                    $permission->setIntitule($route->getOptions()["description"]);
                }
                $em->persist($permission);
                $em->flush();
                $permission->new = true;
            } elseif ($existDesc && $route->getOptions()["description"] != $permission->getIntitule()) {
                $permission->setIntitule($route->getOptions()["description"]);
                $permission->new = false;
            } else {
                $permission->new = false;
            }
            if ($existvisible) {
                $permission->setVisible($route->getOptions()["visible"]);
            }
            if ($existgroupe) {
                    $permission->setGroupe($route->getOptions()["groupe"]);
                }

            $routes[$name] = $permission;
        }
        $routeslist = $this->getDoctrine()->getRepository('UserBundle:CyPermission')->findAll();
        foreach ($routeslist as $rl) {
            if (!in_array($rl, $routes)) {
                $em->remove($rl);
            }
        }
    

        $em->flush();

        $content = $this->get('templating')->render('UserBundle:Route:ListeDesRoutes.html.twig', array('routes' => $routes, 'nvroutes' => $nvroutes));
        return new Response($content);
    }

    /**
     * Edits an existing Permission entity.
     *
     * @Route("/update/{id}",requirements={"id"="\d+"}, name="us_update_route", options={"description" =  "المستخدمون : إدارة بيانات حقوق العبور :تعديل حق العبور "})
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $permission = $em->getRepository('UserBundle:CyPermission')->find($id);
        if ($request->getMethod() == "POST") {
            $form = $request->request->get('modifierroute');
            $permission->setIntitule($form['intitule']);
            if (isset($form['visible'])) {
                $permission->setVisible(2);
            } else {
                $permission->setVisible(1);
            }

            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Modification avec succés');
            return $this->redirect($this->generateUrl('us_list_routes'));
        }

        return $this->render('UserBundle:route:ModifierRoute.html.twig', array(
                    'permission' => $permission,
        ));
    }

}
