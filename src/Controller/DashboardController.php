<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/showLivreAdmin', name: 'app_showLivreAdmin')]
    public function showLivreAdmin(): Response
    {
        return $this->render('dashboardd/showAdminLivres.html.twig');
    }

    #[Route('/ajouterLivre', name: 'app_ajouterLivre')]
    public function ajouterLivre(): Response
    {
        return $this->render('dashboardd/ajouterLivre.html.twig');
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('dashboardd/profile.html.twig');
    }
}
