<?php

namespace App\DataFixtures;

use App\Entity\Secteur;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $secteur1 = new Secteur();
        $secteur1->setNomSecteur('Ostrevent');

        $secteur2 = new Secteur();
        $secteur2->setNomSecteur('Valenciennois');

        $ville = new Ville();
        $ville->setNomVille('Somain')
            ->setSecteur($secteur1);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_USER'])
            ->setPassword($hash)
            ->setLastName('Caudron')
            ->setFirstName('Cedric')
            ->setEmail('ceduser@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville)
            ->setIsClient(true)
            ->setIsLivreur(false)
            ->setIsRestaurant(false);


        $manager->flush();
    }
}
