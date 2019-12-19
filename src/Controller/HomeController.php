<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Fiche;
use App\Entity\Fraisforfaitise;
use App\Entity\Typefraisforfait;
use App\Entity\Fraishorsforfait;
use App\Entity\Visiteur;
use App\Form\AjoutFicheType;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request) //Formulaire de connexion
    {
        //Redirige le visiteur vers le formulaire de connexion lorsque qu'il lance l'appli web
        return $this->redirectToRoute("login");
    }



    /**
     * @Route("/choixfiche", name="choixfiche")
     */
    public function choixfiche(Request $request, AuthenticationUtils $authenticationUtils)
    {
        //Récupère l'utilisateur connecté
        $user = $this->getUser();
        
        $repository=$this->getDoctrine()->getRepository(Fiche::class);

        //récupère le mois choisi dans le filtre
        $mois= $request->get('mois');

        //Si "TOUS" est choisi
        if($mois=='00' || !isset($mois)){
            $fiches=$repository->findAll(); //récupère toutes les fiches
        }
        else{
            //Sinon
            $fiches=$repository->findByMonth($mois); //récupère les fiches du mois
        }

        //On récupère l'id du visiteur connecté
        $idVisiteur=$user->getId();

        return $this->render('home/choixfiche.html.twig', ['fiches'=>$fiches, 'idVisiteur'=>$idVisiteur]); //page de choix de la fiche
    }



    /**
     * @Route("/ajouterFiche", name="ajouterFiche")
     */
    public function ajouterFiche(Request $request)
    {  
        //On créer une nouvelle fiche vide
        $entityManager=$this->getDoctrine()->getManager();
        $fiche= new Fiche;

        //On prend l'etat "crée"
        $repository=$this->getDoctrine()->getRepository(Etat::class);
        $etat=$repository->find("3");

        //On affecte l'état à la fiche
        $fiche->setDateCreation(new \DateTime('now'));
        $fiche->setIdEtat($etat);
        
        //On récupère l'utilisateur connecté et on l'associe à la fiche
        $user = $this->getUser();
        $fiche->setIdVisiteur($user);

        //On enregistre dans la base de donnée
        $entityManager->persist($fiche);
        $entityManager->flush($fiche);

        //On récupère tous les types de frais
        $repository=$this->getDoctrine()->getRepository(Typefraisforfait::class);
        $typeFrais1=$repository->find("1");
        $typeFrais2=$repository->find("2");
        $typeFrais3=$repository->find("3");
        $typeFrais4=$repository->find("4");

        //Ajout frais forfaitisés correspondants (4 types dans la base)

        //Frais forfaitisé 1
        $fraisF = new Fraisforfaitise;
        $fraisF->setIdFiche($fiche);
        $fraisF->setIdType($typeFrais1);
        $fraisF->setQuantite("0");
        $entityManager->persist($fraisF);
        $entityManager->flush($fraisF);

        //Frais forfaitisé 2
        $fraisF = new Fraisforfaitise;
        $fraisF->setIdFiche($fiche);
        $fraisF->setIdType($typeFrais2);
        $fraisF->setQuantite("0");
        $entityManager->persist($fraisF);
        $entityManager->flush($fraisF);

        //Frais forfaitisé 3
        $fraisF = new Fraisforfaitise;
        $fraisF->setIdFiche($fiche);
        $fraisF->setIdType($typeFrais3);
        $fraisF->setQuantite("0");
        $entityManager->persist($fraisF);
        $entityManager->flush($fraisF);

        //Frais forfaitisé 4
        $fraisF = new Fraisforfaitise;
        $fraisF->setIdFiche($fiche);
        $fraisF->setIdType($typeFrais4);
        $fraisF->setQuantite("0");
        $entityManager->persist($fraisF);
        $entityManager->flush($fraisF);

        //On affiche une notification
        $this->addFlash('success', 'Fiche ajoutée !');

        return $this->redirectToRoute("choixfiche");
    }


    
    /**
     * @Route("/accueil/{id}", name="accueil")
     */
    public function accueil($id) //récupère tous les frais et types de frais pour la fiche n°$id
    {
        //On récupère les frais hors forfait correspondant à la fiche n°id
        $repository=$this->getDoctrine()->getRepository(Fraishorsforfait::class);
        $fraisHorsForfait=$repository->findByIdFiche($id);

        //On récupère tous les types de frais
        $repository=$this->getDoctrine()->getRepository(Typefraisforfait::class);
        $typeFraisForfaitise=$repository->findAll();

        //On récupère les frais forfaitisé correspondant à la fiche n°id
        $repository=$this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $fraisF=$repository->findByIdFiche($id);

        return $this->render('home/accueil.html.twig', ['fraisHF'=>$fraisHorsForfait, 'typeFraisF'=>$typeFraisForfaitise, 'idfiche'=>$id, 'fraisF'=>$fraisF]);
    }






    //GESTION DES API



    /**
     * @Route("/getAPIFiche", name="getAPIFiche")
     */
    public function getAPIFiche(Request $request) 
    {
        //On récupère toutes les fiches
        $repo = $this->getDoctrine()->getRepository(Fiche::class);
        $fiches = $repo->findAll();

        //On creer un tableau vide
        $formatted = [];

        foreach ($fiches as $fiche) {
            //Pour chaque fiche on ajoute dans le tableau chaque info souhaitée
            $formatted[] = [
                'id'                => $fiche->getId(),
                'datemodif'         => $fiche->getDatemodif(),
                'datecreation'      => $fiche->getDatecreation(),
                'idEtat'      => $fiche->getIdEtat()->getLibelle(),
                'montant_rembourse'      => $fiche->getMontantRembourse(),
                'idVisiteur' => $fiche->getIdVisiteur()->getId(),
            ];
        }

        //On génère un fichier JSON avec le tableau
        return new JsonResponse($formatted);
    }



    /**
     * @Route("/getAPIVisiteur", name="getAPIVisiteur")
     */
    public function getAPIVisiteur(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Visiteur::class);
        $visiteurs = $repo->findAll();
        $formatted = [];
        foreach ($visiteurs as $visiteur) {
            $formatted[] = [
                'id'            => $visiteur->getId(),
                'login'         => $visiteur->getLogin(),
                'mdp'           => $visiteur->getMdp(),
            ];
        }
        return new JsonResponse($formatted);
    }




    /**
     * @Route("/getAPIFraisHF", name="getAPIFraisHF")
     */
    public function getAPIFraisHF(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Fraishorsforfait::class);
        $frais = $repo->findAll();
        $formatted = [];
        foreach ($frais as $unFrais) {
            $formatted[] = [
                'id'            => $unFrais->getId(),
                'date'         => $unFrais->getDate(),
                'montant'           => $unFrais->getMontant(),
                'libelle'           => $unFrais->getLibelle(),
                'validite'           => $unFrais->getValidite(),
                'idFiche'           => $unFrais->getIdFiche()->getId(),
            ];
        }
        return new JsonResponse($formatted);
    }
    



    /**
     * @Route("/getAPIFraisF", name="getAPIFraisF")
     */
    public function getAPIFraisF(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $frais = $repo->findAll();
        $formatted = [];
        foreach ($frais as $unFrais) {
            $formatted[] = [
                'id'            => $unFrais->getId(),
                'quantite'         => $unFrais->getQuantite(),
                'idFiche'           => $unFrais->getIdFiche()->getId(),
                'idType'           => $unFrais->getIdType()->getLibelle(),
            ];
        }
        return new JsonResponse($formatted);
    }




    /**
     * @Route("/getAPIType", name="getAPIType")
     */
    public function getAPIType(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Typefraisforfait::class);
        $frais = $repo->findAll();
        $formatted = [];
        foreach ($frais as $unFrais) {
            $formatted[] = [
                'id'                => $unFrais->getId(),
                'libelle'           => $unFrais->getLibelle(),
                'montantUnitaire'   => $unFrais->getMontantUnitaire(),
            ];
        }
        return new JsonResponse($formatted);
    }
}
