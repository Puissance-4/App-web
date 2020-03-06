<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Fraisforfaitise;
use App\Entity\Fraishorsforfait;
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
    public function ajouterhf($id, Request $request) //Permet d'ajouter un frais hors forfait
    {
        $entityManager=$this->getDoctrine()->getManager();

        //On récupère la fiche dont l'id se trouve dans l'URL
        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $fiche=$repository->find($id);

        //On ajoute dans le frais la fiche
        $fraishf= new Fraishorsforfait();
        $fraishf->setIdFiche($fiche);
        $fraishf->setValidite(1);

        //Création du formulaire d'ajout de frais hors forfait
        $form=$this->createForm(AjoutHorsForfaitType::class, $fraishf);
        $form->handleRequest($request);

        //On récupère le frais ajouté dans le formulaire et on l'enregistre dans la base de données
        if($form->isSubmitted() && $form->isValid())
        {
           $entityManager->persist($fraishf);
           $entityManager->flush($fraishf);
          
           //Redirige l'utilisateur vers 'accueil' avec l'id de la fiche
           return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        return $this->render('acceuil/ajouterhf.html.twig',['form'=>$form->createView(), 'fiche'=>$fiche]);

    }
     




    /**
     * @Route("/modifierFraisHF/{id}", name="modifierFraisHF", methods="GET|POST")
     */
    public function modifierFraisHF($id, Request $request) // permet de modifier un frais hors forfait déjà créé
    {

        //On récupère le frais n°id
        $repository = $this->getDoctrine()->getRepository(FraisHorsForfait::class);
        $frais = $repository->find($id);

        //On l'id de la fiche correspondant au frais que l'on veut modifié
        $idFiche=$frais->getIdFiche()->getId();

        //On récupère la fiche dont l'id a été récupéré juste au-dessus
        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $fiche=$repository->find($idFiche);

        //On modifie la date de modification à la date d'aujourd'hui
        $fiche->setDateModif(new \DateTime('now'));

        //Création du formulaire de modification du frais
        $form=$this->createForm(AjoutHorsForfaitType::class,$frais);
        $form->handleRequest($request);

        //On récupère le frais modifié dans le formulaire et on l'enregistre dans la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            //Redirige l'utilisateur vers 'accueil' avec l'id de la fiche
            return $this->redirectToRoute("accueil",['id'=>$idFiche]);
        }
        return $this->render('acceuil/modifierFraisHF.html.twig', ['fiche'=>$idFiche, 'frais'=>$frais, 'form'=>$form->createView()]);
    }






    /**
     * @Route("/supprimerHF/{id}", name="supprimerHF", methods="DELETE")
     */
    public function supprimerHF($id, Request $request) //Permet de supprimer un frais Hors forfait
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token')))
        {
            //On récupère le frais que l'on veut supprimer
            $repository = $this->getDoctrine()->getRepository(FraisHorsForfait::class);
            $frais = $repository->find($id);

            //On le supprime de la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($frais);
            $entityManager->flush();

            //On récupère l'id de la fiche correspondant au frais pour la redirection (voir return)
            $idFiche=$frais->getIdFiche()->getId(); 

        }
        return $this->redirectToRoute("accueil",['id'=>$idFiche]);
    }





    /**
     * @Route("/modifierQtiteFF/{id}/{idfrais}", name="modifierQtiteFF", methods="GET|POST")
     */
    public function modifierQtiteFF($id, $idfrais, Request $request) //Permet de modifier la quantité du frais forfaitisé
    {
        //On récupère le frais forfaitisé
        $repository = $this->getDoctrine()->getRepository(Fraisforfaitise::class);
        $fraisF = $repository->find($idfrais);

        //Création de formulaire
        $form=$this->createForm(ConfChangQteType::class,$fraisF);
        $form->handleRequest($request);

        //Récupération de la fiche correspondant au frais modifié
        $idFiche=$fraisF->getIdFiche()->getId();

        //On récupère la fiche dont l'id se trouve dans l'URL
        $repository=$this->getDoctrine()->getRepository(Fiche::class);
        $fiche=$repository->find($idFiche);
        
        //On modifie la date de modification à la date d'aujourd'hui
        $fiche->setDateModif(new \DateTime('now'));

        //Enregistrement dans la base de données des nouvelles valeurs
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("accueil",['id'=>$id]);
        }
        
        return $this->render('acceuil/changeforfait.html.twig', ['fiche'=>$fiche, 'fraisF'=>$fraisF,'idfrais'=>$idfrais,'id'=>$id,'form' => $form->createView()]);
    }
}
