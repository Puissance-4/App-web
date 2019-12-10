<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Fraisforfaitise;
use App\Entity\Fraishorsforfait;
use App\Form\AjoutFraiForfaitiseType;
use App\Form\AjoutHorsForfaitType;
use App\Form\ConfChangQteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

     /**
     * @Route("/ajouterhf/{id}", name="ajouterhf")
     */
    public function ajouterhf($id, Request $request) //permet d'ajouter un frais hors forfait
    {
        $entityManager=$this->getDoctrine()->getManager();

        //On récupère la fiche dont l'id se trouve dans l'URL
        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $fiche=$repository->find($id);

        //On ajoute dans le frais la fiche
        $fraishf= new Fraishorsforfait();
        $fraishf->setIdFiche($fiche);

        $form=$this->createForm(AjoutHorsForfaitType::class,$fraishf);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           $entityManager->persist($fraishf);
           $entityManager->flush($fraishf);
          
           return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        return $this->render('acceuil/ajouterhf.html.twig',['form'=>$form->createView()]);

    }
     /**
     * @Route("/ajouterf", name="ajouterf")
     */
  /*  public function ajouterf(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $fraisf= new Fraisforfaitise;
        $form=$this->createForm(AjoutFraiForfaitiseType::class,$fraisf);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($fraisf);
            $entityManager->flush($fraisf);
            return $this->redirectToRoute("accueil");
        }
        return $this->render('acceuil/ajouterf.html.twig',['form'=>$form->createView()]);

    }*/

    /**
     * @Route("/modifierFraisHF/{id}", name="modifierFraisHF", methods="GET|POST")
     */
    public function modifierFraisHF($id, Request $request) // permet de modifier un frais hors forfait déjà créé
    {
        $repository = $this->getDoctrine()->getRepository(FraisHorsForfait::class);
        $frais = $repository->find($id);
        $form=$this->createForm(AjoutHorsForfaitType::class,$frais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        return $this->render('acceuil/modifierFraisHF.html.twig', ['frais'=>$frais, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/modifierFraisF/{id}", name="modifierFraisF", methods="GET|POST")
     */
    public function modifierFraisF($id, Request $request)  // permet de modifier un frais forfaitisé déjà créé
    {
        $repository = $this->getDoctrine()->getRepository(FraisForfaitise::class);
        $frais = $repository->find($id);
        $form=$this->createForm(AjoutFraiForfaitiseType::class,$frais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        return $this->render('acceuil/modifierFraisF.html.twig', ['frais'=>$frais, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/supprimerHF/{id}", name="supprimerHF", methods="DELETE")
     */
    public function supprimerHF($id, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token')))
        {
            $repository = $this->getDoctrine()->getRepository(FraisHorsForfait::class);
            $frais = $repository->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($frais);
            $entityManager->flush();

        }
        return $this->redirectToRoute("accueil",['id'=>$id]);
    }

    /**
     * @Route("/ConfChange/{id}/{idfrais}", name="ConfChange", methods="GET|POST")
     */
    public function ConfChange($id, $idfrais, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $fraisFF = $repository->find($idfrais);
        $form=$this->createForm(ConfChangQteType::class,$fraisFF);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        
        return $this->render('acceuil/changeforfait.html.twig', ['fraisFF'=>$fraisFF,'idfrais'=>$idfrais,'id'=>$id,'form' => $form->createView()]);
    }

}
