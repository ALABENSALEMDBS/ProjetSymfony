<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livre;


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


    // #[Route('/livres', name: 'livres_show')]
    // public function livres_show(LivreRepository $livreRepository): Response
    // {
    //     $books = $livreRepository->findAll();
               
    //     return $this->render('livres.html.twig', 
    // ['books' => $books]);
    // }


    #[Route('/livres/recherche', name: 'livres_recherche')]
    public function rechercher(Request $request, LivreRepository $livreRepository): Response
    {
        // Récupérer le terme de recherche depuis la requête GET (title)
        $query = $request->query->get('title', ''); // Par défaut, vide si non renseigné
    
        // Recherche des livres par titre
        if ($query) {
            $livres = $livreRepository->findByTitle($query);
        } else {
            // Si aucun titre n'est fourni, afficher tous les livres
            $livres = $livreRepository->findAll();
        }
    
        // Passer les livres et le terme de recherche au template
        return $this->render('livres.html.twig', [
            'books' => $livres,  // Liste des livres trouvés
            'query' => $query,    // Le terme de recherche
        ]);
    }


}
