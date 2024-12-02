<?php

namespace App\Controller;

use App\Entity\CategoryLivre;
use App\Form\CategoryLivreType;
use App\Repository\CategoryLivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryLivreController extends AbstractController
{
    #[Route('/category_livre', name: 'app_livre')]
    public function index(): Response
    {
        return $this->render('category_livre/index.html.twig', [
            'controller_name' => 'CategoryLivreController',
        ]);
    }

    #[Route('/readsliste_categ', name: 'app_read_category')]
    public function read(CategoryLivreRepository $categoryLivreRepository): Response
    {
        $list = $categoryLivreRepository->findAll();
        return $this->render('category_livre/read_category.html.twig', ["liste" => $list]);
    }
    #[Route('/category_livre/add', name: 'category_livre_add')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new CategoryLivre();
        $form = $this->createForm(CategoryLivreType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été ajoutée avec succès.');

            return $this->redirectToRoute('app_read_category'); // Changez vers une route appropriée.
        }

        return $this->render('category_livre/new_category.html.twig', [
            'form' => $form->createView(),
            'category' => $category, // Add this line
        ]);
    }

    #[Route('/category_livre/edit/{id}', name: 'category_livre_edit')]
    public function editCategory(Request $request, EntityManagerInterface $entityManager, CategoryLivre $category = null): Response
    {
        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas.');
        }
    
        $form = $this->createForm(CategoryLivreType::class, $category);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();  // Met à jour l'entité
    
            $this->addFlash('success', 'La catégorie a été mise à jour avec succès.');
    
            return $this->redirectToRoute('app_read_category'); // Redirige après la mise à jour
        }
    
        return $this->render('category_livre/new_category.html.twig', [
            'form' => $form->createView(),
            'category' => $category,  // Assurez-vous de passer l'objet CategoryLivre au template
        ]);
    }

    #[Route('/category_livre/delete/{id}', name: 'category_livre_delete')]
public function deleteCategory(int $id, CategoryLivreRepository $categoryLivreRepository, EntityManagerInterface $entityManager): Response
{
    // Recherche de la catégorie par son ID
    $category = $categoryLivreRepository->find($id);

    // Vérifie si la catégorie existe
    if (!$category) {
        throw $this->createNotFoundException('La catégorie de livre avec l\'ID ' . $id . ' n\'existe pas.');
    }

    // Suppression de la catégorie
    $entityManager->remove($category);
    $entityManager->flush();

    // Message flash pour informer l'utilisateur
    $this->addFlash('success', 'La catégorie a été supprimée avec succès.');

    // Redirection vers la liste des catégories après suppression
    return $this->redirectToRoute('app_read_category');
}
  
}
