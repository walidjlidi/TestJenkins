<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\Utilisateur;

use Faker;

class LoadUtilisateurData
    extends AbstractFixture
    implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        //*
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $obj = new Utilisateur();
            $obj->setEmail($faker->email);           
            $obj->setNom($faker->lastName);
            $obj->setPrenom($faker->firstName);
            $obj->setEstDesactive($this->getRandomActivation());          
            $obj->setUsername($faker->userName);
            $obj->setTel($faker->randomNumber(8));
            $obj->setAdresse($faker->address);
            $obj->setPassword($faker->password);
            $manager->persist($obj);
        }

        $manager->flush();
        //*/
    }
    
    private function getRandomActivation()
    {
        $activation = array(0,1);
        return $activation[array_rand($activation)];
    } 
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}