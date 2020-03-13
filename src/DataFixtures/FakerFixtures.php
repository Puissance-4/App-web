<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;

use App\Entity\Fiche;
use App\Entity\Etat;
use App\Entity\Visiteur;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        $date = date('Y-m-d');
        $date = new DateTime($date);

        $etat = new Etat;
        $etat->setLibelle('Créé');
        $manager->persist($etat);
        $manager->flush($etat);

        $visiteur = new Visiteur;
        $visiteur->setNom($faker->firstName);
        $visiteur->setPrenom($faker->lastName);
        $visiteur->setLogin($faker->userName);
        $visiteur->setMdp($faker->password);
        $visiteur->setEmail($faker->safeEmail);
        $visiteur->setTelephone(01234567);
        $visiteur->setDateNaiss($date);
        $visiteur->setNumRue($faker->buildingNumber);
        $visiteur->setRue($faker->streetName);
        $visiteur->setCp(85100);
        $visiteur->setVille($faker->city);
        $manager->persist($visiteur);
        $manager->flush($visiteur);

        // on créé 10 fiches
        for ($i = 0; $i < 10; $i++) {
            $fiche = new Fiche();
            $fiche->setDateModif($date);
            $fiche->setDateCreation($date);
            $fiche->setMontantRembourse($faker->randomFloat(2,0,1000));
            $fiche->setIdEtat($etat);
            $fiche->setIdVisiteur($visiteur);
            $manager->persist($fiche);
        }

        $manager->flush();
    }
}