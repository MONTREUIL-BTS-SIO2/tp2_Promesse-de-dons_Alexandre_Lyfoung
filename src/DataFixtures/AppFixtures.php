<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\PromesseDon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadCampagnePromesse($manager);
    }

    public function loadCampagnePromesse(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i<10; $i++)
        {
            $promesse = new PromesseDon();
            $promesse->setNom($faker->lastName);
            $promesse->setPrenom($faker->firstName);
            $promesse->setEmail($faker->email);
            $promesse->setDateDeCreation(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            $promesse->setMontantDon($faker->randomDigit);



            $manager->persist($promesse);

            $campagne = new Campagne();
            $campagne->addPromesseDon($promesse);
            $campagne->setNom($faker->name());
            //$campagne->setDescription($faker->text);
            $manager->persist($campagne);

            //$this->addReference('promesse', $promesse);

        }
        $manager->flush();
    }


}
