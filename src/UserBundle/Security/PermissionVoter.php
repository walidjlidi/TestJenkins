<?php


namespace UserBundle\Security;


use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Monolog\Logger;

use UserBundle\Entity\Utilisateur;


class PermissionVoter extends Voter
{

   /*
    * Pas nécessaire
    */
	protected function supports($attribute, $path)
	{
        return true;
	}

	protected function voteOnAttribute($attribute, $path, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof Utilisateur) 
        {
            return false;
        }
 
        		
		if($this->checkPermissions($user, $path))
        {
            return true; 
        }
        else
        {
            return false;
        }
    }   
    
     
    private function checkPermissions(UserInterface $user, $path)
    {
        $roles=$user->getRoles();
        //$pathtest = $this->getDoctrine()->getRepository('CYNAPSYSUserBundle:CyPermission')->findOneBy(array('path'=>$path));
        foreach ($roles as $role) 
        {
        	foreach($role->getPermissions() as $permission)
            {
                if ($path==$permission->getPath())
                {
                return true;
                }
            }	
        }
        return false;
    }
}