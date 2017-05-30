<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\CyPermission;

use Faker;

class LoadCyPermissionData
    extends AbstractFixture
    implements OrderedFixtureInterface, ContainerAwareInterface
{   
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function load(ObjectManager $manager)
    {        
        $faker = Faker\Factory::create();
        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            if($name[0] ==='_' ) continue;
            $permission = new CyPermission();                     
            $permission->setPath($name);
            
            if(isset($route->getOptions()["groupe"])){
                $permission->setGroupe($route->getOptions()["groupe"]);
            }
            if(isset($route->getOptions()["visible"])){
                $permission->setVisible($route->getOptions()["visible"]);
            }
            if(isset($route->getOptions()["description"])){
                $permission->setVisible($route->getOptions()["description"]);
            }
           
            $manager->persist($permission);
        }

        $manager->flush();        
    }
    
    /**
     * Sets the container.
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}