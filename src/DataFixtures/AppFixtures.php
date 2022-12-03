<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\PromesseDon;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encode;

    public function __construct(UserPasswordHasherInterface $password)
    {
        $this->encode = $password;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadCampagnePromesse($manager);
        $this->loadUser($manager);
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
            //$campagne->setDescription($faker->text(100));
            if ($i%2 === 0)
            {
                $campagne->setActive(true);
            }
            else{
                $campagne->setActive(false);
            }
            $manager->persist($campagne);

            //$this->addReference('promesse', $promesse);
        }
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("toto@tata.com");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->encode->hashPassword($user, "toto"));

        $manager->persist($user);
        $manager->flush();
    }
}
