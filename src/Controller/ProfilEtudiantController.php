<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilEtudiantController extends AbstractController
{
    #[Route('/profil/etudiant', name: 'app_profil_etudiant')]
    public function index(): Response
    {
        return $this->render('profil_etudiant/index.html.twig', [
            'controller_name' => 'ProfilEtudiantController',
        ]);
    }
}
