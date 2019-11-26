<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Fraisforfaitise;
use App\Entity\Fraishorsforfait;
use App\Entity\Visiteur;
use App\Form\AjoutFraiForfaitiseType;
use App\Form\AjoutHorsForfaitType;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
     /**
     * @Route("/ajouterhf", name="ajouterhf")
     */
    public function ajouterhf(Request $request)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $fraishf= new Fraishorsforfait();
        $form=$this->createForm(AjoutHorsForfaitType::class,$fraishf);
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid())
        {
           $entityManager->persist($fraishf);
           $entityManager->flush($fraishf);
          
            return $this->redirectToRoute("accueil");
        }
        return $this->render('acceuil/ajouterhf.html.twig',['form'=>$form->createView()]);

    }
     /**
     * @Route("/ajouterf", name="ajouterf")
     */
    public function ajouterf(Request $request)
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

    }

    /**
     * @Route("/modifierFraisHF/{id}", name="modifierFraisHF", methods="GET|POST")
     */
    public function modifierFraisHF($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(FraisHorsForfait::class);
        $frais = $repository->find($id);
        $form=$this->createForm(AjoutHorsForfaitType::class,$frais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil");
        }
        return $this->render('acceuil/modifierFraisHF.html.twig', ['frais'=>$frais, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/modifierFraisF/{id}", name="modifierFraisF", methods="GET|POST")
     */
    public function modifierFraisF($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(FraisForfaitise::class);
        $frais = $repository->find($id);
        $form=$this->createForm(AjoutFraiForfaitiseType::class,$frais);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil");
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
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/supprimerF/{id}", name="supprimerF", methods="DELETE")
     */
    public function supprimerF($id, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token')))
        {
            $repository = $this->getDoctrine()->getRepository(FraisForfaitise::class);
            $frais = $repository->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($frais);
            $entityManager->flush();

        }
        return $this->redirectToRoute("accueil");
    }
}

