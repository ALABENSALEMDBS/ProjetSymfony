<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryLivreRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfilEtudiantController extends AbstractController
{
    #[Route('/profil/etudiant', name: 'app_profil_etudiant')]
public function index(Request $request, CategoryLivreRepository $categoryRepository, LivreRepository $livreRepository): Response
{
    // Récupérer toutes les catégories
    $categories = $categoryRepository->findAll();

    // Récupérer l'ID de la catégorie filtrée à partir des paramètres GET
    $categoryId = $request->query->get('category');

    // Si une catégorie est sélectionnée, filtrer les livres par catégorie
    if ($categoryId) {
        $liste = $livreRepository->findBy(['category' => $categoryId]);
    } else {
        // Si aucune catégorie sélectionnée, récupérer tous les livres
        $liste = $livreRepository->findAll();
    }

    return $this->render('profil_etudiant/index.html.twig', [
        'categories' => $categories, // Transmet les catégories
        'categoryId' => $categoryId, // Transmet la catégorie sélectionnée
        'liste' => $liste, // Transmet la liste des livres
    ]);
}

    // #[Route('/profil/etudiant/liste', name: 'app_profil_etudiant')]
    // public function read(LivreRepository $bookRepository): Response
    // {
    //     $list = $bookRepository->findAll();
    //     return $this->render('profil_etudiant/read_liste_livre.html.twig', ["liste" => $list]);
    // }

//    
// #[Route('/profil/etudiant', name: 'app_profil_etudiant_index')]
// public function index(): Response
// {
//     return $this->render('profil_etudiant/index.html.twig', [
//         'controller_name' => 'ProfilEtudiantController',
//     ]);
// }

// Route pour afficher la liste des livres avec filtre
#[Route('/profil/etudiant/liste', name: 'app_profil_etudiant_liste')]
public function read(
    Request $request, 
    LivreRepository $livreRepository, 
    CategoryLivreRepository $categoryLivreRepository
): Response {
    // Récupérer les paramètres de filtre
    $categoryId = $request->query->get('category'); // ID de catégorie
    $orderByAlpha = $request->query->get('alpha');  // Tri alphabétique
  

    $livres = [];
    $category = null;

    // Filtrage par catégorie
    if ($categoryId) {
        $category = $categoryLivreRepository->find($categoryId);
        if ($category) {
            $livres = $livreRepository->findBy(['category' => $category]);
        }
    } else {
        $livres = $livreRepository->findAll();
    }

    // Tri alphabétique
    if ($orderByAlpha === 'true') {
        usort($livres, fn($a, $b) => strcmp($a->getTitreLivre(), $b->getTitreLivre()));
    }

    return $this->render('profil_etudiant/read_liste_livre.html.twig', [
        'categories' => $categoryLivreRepository->findAll(), // Liste des catégories
        'liste' => $livres, // Liste des livres
        'categoryId' => $categoryId, // ID de la catégorie sélectionnée
        'alpha' => $orderByAlpha, // Paramètre pour tri alphabétique
        
    ]);
}


#[Route('/livre/reserver/{id}', name: 'app_livre_reserver')]
public function reserverLivre(int $id, LivreRepository $livreRepository, EntityManagerInterface $entityManager): Response
{
    // Récupérer le livre par son ID
    $livre = $livreRepository->find($id);

    // Vérifier si le livre existe
    if (!$livre) {
        $this->addFlash('error', 'Livre introuvable.');
        return $this->redirectToRoute('app_profil_etudiant');
    }

    // Vérifier si des exemplaires sont disponibles
    if ($livre->getNombreExemplaireLivre() <= 0) {
        $this->addFlash('error', 'Aucun exemplaire disponible pour ce livre.');
        return $this->redirectToRoute('app_profil_etudiant');
    }

    // Réduire le nombre d'exemplaires disponibles
    $livre->setNombreExemplaireLivre($livre->getNombreExemplaireLivre() - 1);

    // Sauvegarder les modifications
    $entityManager->persist($livre);
    $entityManager->flush();

    $this->addFlash('success', 'Le livre a été réservé avec succès.');

    return $this->redirectToRoute('app_profil_etudiant');
}


#[Route('/livre/emprunter/{id}', name: 'app_livre_emprunter')]
public function emprunterLivre(
    int $id,
    LivreRepository $livreRepository,
    EntityManagerInterface $entityManager
): Response {
    // Récupérer le livre par son ID
    $livre = $livreRepository->find($id);

    // Vérifier si le livre existe
    if (!$livre) {
        $this->addFlash('error', 'Livre introuvable.');
        return $this->redirectToRoute('app_profil_etudiant');
    }

    // Vérifier si des exemplaires sont disponibles
    if ($livre->getNombreExemplaireLivre() <= 0) {
        $this->addFlash('error', 'Aucun exemplaire disponible pour ce livre.');
        return $this->redirectToRoute('app_profil_etudiant');
    }

    // Réduire le nombre d'exemplaires disponibles
    $livre->setNombreExemplaireLivre($livre->getNombreExemplaireLivre() - 1);

    // Sauvegarder les modifications dans la base de données
    $entityManager->persist($livre);
    $entityManager->flush();

    $this->addFlash('success', 'Le livre a été emprunté avec succès.');

    return $this->redirectToRoute('app_profil_etudiant');
}



}

