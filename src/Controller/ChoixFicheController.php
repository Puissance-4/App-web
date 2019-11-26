<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChoixFicheController extends AbstractController
{
    /**
     * @Route("/choix/fiche", name="choix_fiche")
     */
    public function index()
    {
        return $this->render('choix_fiche/index.html.twig', [
            'controller_name' => 'ChoixFicheController',
        ]);
    }
}
