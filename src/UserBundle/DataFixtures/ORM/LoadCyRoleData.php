<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\CyRole;

use Faker;

class LoadCyRoleData
    extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        //*
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $obj = new CyRole();                     
            $obj->setNom("ROLE_".strtoupper($faker->word));
            $obj->setDescription($faker->sentence(9));
            $obj->setRoleProvisoire($this->getRandomProvisoire());
            $manager->persist($obj);
        }

        $manager->flush();
        
    }
    
    private function getRandomProvisoire()
    {
        $provisoire = array(0,1);
        return $provisoire[array_rand($provisoire)];
    } 
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}