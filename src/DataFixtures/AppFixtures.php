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
        $manager->persist($secteur1);

        $secteur2 = new Secteur();
        $secteur2->setNomSecteur('Valenciennois');
        $manager->persist($secteur2);


        $ville = new Ville();
        $ville->setNomVille('Bruay sur Escaut')
            ->setSecteur($secteur2);
        $manager->persist($ville);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_CLIENT'])
            ->setPassword($hash)
            ->setLastName('Brocheton')
            ->setFirstName('Vincent')
            ->setEmail('user@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville);

        $manager->persist($user);



        $ville->setNomVille('Valenciennes')
            ->setSecteur($secteur2);
        $manager->persist($ville);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_LIVREUR'])
            ->setPassword($hash)
            ->setLastName('Van Hoorde')
            ->setFirstName('Théo')
            ->setEmail('livreur@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville);

        $manager->persist($user);




        $ville->setNomVille('Anzin')
            ->setSecteur($secteur2);
        $manager->persist($ville);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_RESTO'])
            ->setPassword($hash)
            ->setLastName('Druvent')
            ->setFirstName('Charlotte')
            ->setEmail('resto@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville);

        $manager->persist($user);



        $ville->setNomVille('St-Saulve')
            ->setSecteur($secteur2);
        $manager->persist($ville);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_SUPER_ADMIN'])
            ->setPassword($hash)
            ->setLastName('Caudron')
            ->setFirstName('Cédric')
            ->setEmail('admin@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville)
            ->setUserType('Client');

        $manager->persist($user);




        $manager->flush();
    }
}
