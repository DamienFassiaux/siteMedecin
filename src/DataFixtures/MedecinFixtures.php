<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Medecins;
use Faker\Factory;

class MedecinFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        
        for($i = 1; $i <= 10; $i++)
        {
            $medecin = new Medecins();

            $medecin->setNom("Docteur $i")
                    ->setPrenom("$i")
                    ->setTelephone("$i")
                    ->setAdresse("$i")
                    ->setCodePostal("$i")
                    ->setVille("$i")
                    ->setEmail("$i")
                    //->setSpecialite("$i")
                    ->setPassword($i)
                    ->setHoraires("$i");

                    $manager->persist($medecin);
           
        }

        $manager->flush();
    }
}
