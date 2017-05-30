<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class SecurityController extends Controller {

    /**
     * Login a user.
     *
     * @Route("/login", name="login", options={"description" = "Gestion des utilisateurs : Interface de connexion"})
     */
    public function loginAction() {

// Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
           
            return $this->redirectToRoute('zone_index');
        }

// Le service authentication_utils permet de récupérer le nom d'utilisateur
// et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
// (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:User:login.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUsername(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

}
