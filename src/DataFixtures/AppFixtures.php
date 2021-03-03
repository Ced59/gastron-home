<?php

namespace App\DataFixtures;

use App\Entity\CategoriePlats;
use App\Entity\CategorieRestaurant;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Plats;
use App\Entity\Restaurant;
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

        $ville = new Ville();
        $ville->setNomVille('Somain');
        $manager->persist($ville);

        $secteur1 = new Secteur();
        $secteur1->setNomSecteur('Ostrevent')
        ->addVille($ville);
        $manager->persist($secteur1);

        $secteur2 = new Secteur();
        $secteur2->setNomSecteur('Valenciennois');
        $manager->persist($secteur2);


        $ville1 = new Ville();
        $ville1->setNomVille('Bruay sur Escaut')
            ->setSecteur($secteur2);
        $manager->persist($ville1);

        $user = new  User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_CLIENT'])
            ->setPassword($hash)
            ->setLastName('Brocheton')
            ->setFirstName('Vincent')
            ->setEmail('user@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville1)
            ->setUserType('CLIENT')
            ->setImageFileName('vincent.jpg');


        $manager->persist($user);


        $ville2 = new Ville();
        $ville2->setNomVille('Valenciennes')
            ->setSecteur($secteur2);
        $manager->persist($ville2);

        $user1 = new  User();
        $hash = $this->encoder->encodePassword($user1, 'password');
        $user1->setRoles(['ROLE_LIVREUR'])
            ->setPassword($hash)
            ->setLastName('Van Hoorde')
            ->setFirstName('Théo')
            ->setEmail('livreur@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville2)
            ->setUserType('LIVREUR')
            ->setImageFileName('theo.jpg');

        $manager->persist($user1);



        $ville3 = new Ville();
        $ville3->setNomVille('Anzin')
            ->setSecteur($secteur2);
        $manager->persist($ville3);


        $ville4 = new Ville();
        $ville4->setNomVille('St-Saulve')
            ->setSecteur($secteur2);
        $manager->persist($ville4);

        $user2 = new  User();
        $hash = $this->encoder->encodePassword($user2, 'password');
        $user2->setRoles(['ROLE_SUPER_ADMIN'])
            ->setPassword($hash)
            ->setLastName('Caudron')
            ->setFirstName('Cédric')
            ->setEmail('admin@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville4)
            ->setUserType('ADMIN')
            ->setImageFileName('ced.jpg');

        $manager->persist($user2);

        $user3 = new  User();
        $hash = $this->encoder->encodePassword($user3, 'password');
        $user3->setRoles(['ROLE_RESTO'])
            ->setPassword($hash)
            ->setLastName('Druvent')
            ->setFirstName('Charlotte')
            ->setEmail('resto@fake.com')
            ->setAdress('25 rue de moi')
            ->setVille($ville3)
            ->setUserType('RESTO')
            ->setImageFileName('charlotte.jpg');

        $manager->persist($user3);



        $categoryResto1 = new CategorieRestaurant();
        $categoryResto1->setLibelle("Fast Food");
        $manager->persist($categoryResto1);

        $categoryResto2 = new CategorieRestaurant();
        $categoryResto2->setLibelle("Chinois");
        $manager->persist($categoryResto2);



        $categoryPlats1 = new CategoriePlats();
        $categoryPlats1->setLibelle('Sushis');
        $manager->persist($categoryPlats1);

        $categoryPlats2 = new CategoriePlats();
        $categoryPlats2->setLibelle('Makis');
        $manager->persist($categoryPlats2);

        $categoryPlats3 = new CategoriePlats();
        $categoryPlats3->setLibelle('Plats chauds');
        $manager->persist($categoryPlats3);

        $categoryPlats4 = new CategoriePlats();
        $categoryPlats4->setLibelle('Dessert');
        $manager->persist($categoryPlats4);

        $categoryPlats5 = new CategoriePlats();
        $categoryPlats5->setLibelle('Entrée');
        $manager->persist($categoryPlats5);


        $plat1 = new Plats();
        $plat1->setPrice(5)
            ->setName('Sushis saumons 12 pc')
            ->setCategoriePlats($categoryPlats1)
            ->setQte(50);
        $manager->persist($plat1);

        $plat2 = new Plats();
        $plat2->setPrice(17)
            ->setName('Maki saumon 12 pc')
            ->setCategoriePlats($categoryPlats2)
            ->setQte(10);
        $manager->persist($plat2);

        $plat3 = new Plats();
        $plat3->setPrice(15)
            ->setName('Canard à l\'orange')
            ->setCategoriePlats($categoryPlats3)
            ->setQte(0);
        $manager->persist($plat3);


        $restoChinois = new Restaurant();
        $restoChinois->addCategorieRestaurant($categoryResto1)
            ->addCategorieRestaurant($categoryResto2)
            ->addCategorieRestaurant($categoryResto1)
            ->addPlat($plat1)
            ->addPlat($plat2)
            ->addPlat($plat3)
            ->setCompanyName('Gronichonyah')
            ->setUtilisateur($user3);


        $command1 = new Commande();

        $dateCommand1 = $faker->dateTimeBetween('2019-03-20T00:00:00.012345Z', 'now');
        $command1->setHeureCommande($dateCommand1)
            ->setStatus('Prise en charge')
            ->setUtilisateur($user)
            ->setRestaurant($restoChinois)
            ->addPlat($plat1)
            ->addPlat($plat1)
            ->addPlat($plat2);

        $prixTotal = 0;
        foreach ($command1->getPlats() as $plat)
        {
            $prixTotal += $plat->getPrice();
        }
        $prixTotal += 3;

        $command1->setTotalPrice($prixTotal);

        $livreur = new Livreur();
        $livreur->setUtilisateur($user1)
            ->setTypeVehicule('Voiture')
            ->setIsDisponible(false);


        $livraison = new Livraison();
        $livraison->setAdresseLivraison($user->getAdress())
            ->setStatus('Prise en charge livreur')
            ->setCommande($command1)
            ->setLivreur($livreur);

        $manager->persist($command1);
        $manager->persist($livreur);
        $manager->persist($livraison);
        $manager->persist($restoChinois);



        $categoryResto = new CategorieRestaurant();
        $categoryResto->setLibelle("Indien");
        $manager->persist($categoryResto);

        $categoryResto = new CategorieRestaurant();
        $categoryResto->setLibelle("Pizzeria");
        $manager->persist($categoryResto);




        $categoryPlats = new CategoriePlats();
        $categoryPlats->setLibelle('Burgers');
        $manager->persist($categoryPlats);

        $categoryPlats = new CategoriePlats();
        $categoryPlats->setLibelle('Pâtes');
        $manager->persist($categoryPlats);

        $categoryPlats = new CategoriePlats();
        $categoryPlats->setLibelle('Pizzas');
        $manager->persist($categoryPlats);








        $manager->flush();
    }
}
