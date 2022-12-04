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
        $array = $this->loadPromesse($manager);
        $this->loadCampagne($manager, $array);
        $this->loadUser($manager);
    }

    public function loadPromesse(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $array_promesse = [];
        for ($i = 0; $i<50; $i++)
        {
            $promesse = new PromesseDon();
            $promesse->setNom($faker->lastName);
            $promesse->setPrenom($faker->firstName);
            $promesse->setEmail($faker->email);
            $promesse->setDateDeCreation(\DateTimeImmutable::createFromMutable($faker->dateTime()));
            if ($i % 3 === 0)
            {
                $promesse->setDateHonore(\DateTimeImmutable::createFromMutable($faker->dateTime()));
                $promesse->getDateHonore()->modify("+1 day");
            }
            $promesse->setMontantDon($faker->numberBetween(1, 100));

            $array_promesse[] = $promesse;


            $manager->persist($promesse);


            //$this->addReference('promesse', $promesse);
        }

        return $array_promesse;
    }

    public function loadCampagne(ObjectManager $manager, $array)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i<20; $i++)
        {

            $nb_rand = rand(0, count($array));

            $new_array = array_slice($array, 0, $nb_rand);
            $array = array_slice($array, $nb_rand, count($array));
            $campagne = new Campagne();

            for($j = 0; $j<$nb_rand; $j++)
            {
                $campagne->addPromesseDon($new_array[$j]);
            }
            $campagne->setNom($faker->word);
            $campagne->setDescription($faker->paragraph(3, true));
            if ($i%2 === 0)
            {
                $campagne->setActive(true);
            }
            else{
                $campagne->setActive(false);
            }
            $manager->persist($campagne);
        }
        $manager->flush();

    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("user@ort.fr");
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->encode->hashPassword($user, "password"));

        $manager->persist($user);
        $manager->flush();
    }
}
