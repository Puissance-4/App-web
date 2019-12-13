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
        /*
        $visiteur=new Visiteur;
        $form=$this->createForm(LoginType::class,$visiteur);
        $repository=$this->getDoctrine()->getRepository(Visiteur::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //Recup' du login du form
            $login = $form->get('login')->getData();
            //Recup des visiteurs correspondants au login dans la bdd
            $lesVisiteurs=$repository->findByLogin($login);
            //Verif de la correspondance du mdp
            foreach($lesVisiteurs as $leVisiteur){
                if($leVisiteur->getMdp() == $form->get('mdp')->getData()){
                    return $this->redirectToRoute("choixfiche");
                }
            }
            
        }
        return $this->render('home/index.html.twig', ['form'=>$form->createView()]);
        */
        return $this->redirectToRoute("login");
    }

    /**
     * @Route("/choixfiche", name="choixfiche")
     */
    public function choixfiche(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $user = $this->getUser();
        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $mois= $request->get('mois');
        if($mois=='00' || !isset($mois)){
            $fiches=$repository->findAll(); //récupère toutes les fiches
        }
        else{
            $fiches=$repository->findByMonth($mois); //récupère les fiches du mois
        }

        $idVisiteur=$user->getId();

        return $this->render('home/choixfiche.html.twig', ['fiches'=>$fiches, 'idVisiteur'=>$idVisiteur]); //page de choix de la fiche
    }

    /**
     * @Route("/ajouterFiche", name="ajouterFiche")
     */
    public function ajouterFiche(Request $request)
    {  
        $entityManager=$this->getDoctrine()->getManager();
        $fiche= new Fiche;

        $repository=$this->getDoctrine()->getRepository(Etat::class);
        $etat=$repository->find("3");

        $fiche->setDateCreation(new \DateTime('now'));
        $fiche->setIdEtat($etat);
        
        

        $form=$this->createForm(AjoutFicheType::class, $fiche);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($fiche);
            $entityManager->flush($fiche);

            $repository=$this->getDoctrine()->getRepository(Typefraisforfait::class);
            $typeFrais1=$repository->find("1");
            $typeFrais2=$repository->find("2");
            $typeFrais3=$repository->find("3");
            $typeFrais4=$repository->find("4");

            //Ajout frais forfaitisés correspondants
            $fraisF = new Fraisforfaitise;
            $fraisF->setIdFiche($fiche);
            $fraisF->setIdType($typeFrais1);
            $fraisF->setQuantite("0");
            $entityManager->persist($fraisF);
            $entityManager->flush($fraisF);

            $fraisF = new Fraisforfaitise;
            $fraisF->setIdFiche($fiche);
            $fraisF->setIdType($typeFrais2);
            $fraisF->setQuantite("0");
            $entityManager->persist($fraisF);
            $entityManager->flush($fraisF);

            $fraisF = new Fraisforfaitise;
            $fraisF->setIdFiche($fiche);
            $fraisF->setIdType($typeFrais3);
            $fraisF->setQuantite("0");
            $entityManager->persist($fraisF);
            $entityManager->flush($fraisF);

            $fraisF = new Fraisforfaitise;
            $fraisF->setIdFiche($fiche);
            $fraisF->setIdType($typeFrais4);
            $fraisF->setQuantite("0");
            $entityManager->persist($fraisF);
            $entityManager->flush($fraisF);


            return $this->redirectToRoute("choixfiche");
        }

        return $this->render('home/ajoutFiche.html.twig', ['form'=>$form->createView()]); //page de choix de la fiche
    }

    
    /**
     * @Route("/accueil/{id}", name="accueil")
     */
    public function accueil($id) //récupère tous les frais et types de frais pour la fiche n°$id
    {
        $repository=$this->getDoctrine()->getRepository(Fraishorsforfait::class);
        $fraisHorsForfait=$repository->findByIdFiche($id);

        $repository=$this->getDoctrine()->getRepository(Typefraisforfait::class);
        $typeFraisForfaitise=$repository->findAll();

        $repository=$this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $ficheFF=$repository->findByIdFiche($id);

        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $idfiche=$id;

        return $this->render('home/accueil.html.twig', ['fraisHF'=>$fraisHorsForfait, 'typeFraisF'=>$typeFraisForfaitise, 'idfiche'=>$idfiche, 'ficheFF'=>$ficheFF]);
    }

    /**
     * @Route("/getAPIFiche", name="getAPIFiche")
     */
    public function getAPIFiche(Request $request) 
    {
        $repo = $this->getDoctrine()->getRepository(Fiche::class);
        $fiches = $repo->findAll();
        $formatted = [];
        foreach ($fiches as $fiche) {
            //$lesFraisForfaitise = $fiche->getLesGenres();
            /*$genreDeLaSerie = "";
            foreach ($lesGenres as $unGenre) {
                $genreDeLaSerie = $genreDeLaSerie . ';' . $unGenre->getLibelle();
            }*/
            $formatted[] = [
                'id'                => $fiche->getId(),
                'datemodif'         => $fiche->getDatemodif(),
                'datecreation'      => $fiche->getDatecreation(),
                'idEtat'      => $fiche->getIdEtat()->getLibelle(),
                'montant_rembourse'      => $fiche->getMontantRembourse(),
                'idVisiteur' => $fiche->getIdVisiteur()->getId(),


                //'lesGenres'         => ltrim($genreDeLaSerie, $genreDeLaSerie[0])
            ];
        }
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
