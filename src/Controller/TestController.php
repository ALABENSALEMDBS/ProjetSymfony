<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }


    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('contact.html.twig', );
    }


    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('about.html.twig', );
    }


    #[Route('/singn_in', name: 'singn_in')]
    public function singn_in(): Response
    {
        return $this->render('singnin.html.twig', );
    }

    #[Route('/singn_up', name: 'singn_up')]
    public function singn_up(): Response
    {
        return $this->render('singnup.html.twig', );
    }


    #[Route('/livres', name: 'livres_show')]
    public function livres_show(LivreRepository $livreRepository): Response
    {
        $books = $livreRepository->findAll();
               
        return $this->render('livres.html.twig', 
    ['books' => $books]);
    }


}
