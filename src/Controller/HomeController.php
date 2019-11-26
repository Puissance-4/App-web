<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Fraisforfaitise;
use App\Entity\Fraishorsforfait;
use App\Entity\Visiteur;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
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
                    return $this->redirectToRoute("accueil");
                }
            }
            
        }
        return $this->render('home/index.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil()
    {
        $repository=$this->getDoctrine()->getRepository(Fraishorsforfait::class);
        $fraisHorsForfait=$repository->findAll();
        $repository=$this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $fraisForfaitise=$repository->findAll();

        return $this->render('home/accueil.html.twig', ['fraisHF'=>$fraisHorsForfait, 'fraisF'=>$fraisForfaitise]);
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
    

}
