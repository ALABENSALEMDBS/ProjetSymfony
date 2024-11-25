<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Psr\Log\LoggerInterface;


class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }


    #[Route('/readsliste',name:'app_read')]
    public function read ( LivreRepository $bookRepository){
        $list=$bookRepository->findAll();
    return $this->render('livre/read.html.twig',["liste"=>$list]);
    }

    // Route for both creating and editing a book
    #[Route('/book/nouveau', name: 'nouveau_Book')]
    #[Route('/book/edit/{id}', name: 'edit_Book')]
    public function manageBook(
        Request $request, 
        EntityManagerInterface $entityManager, 
        LoggerInterface $logger, 
        LivreRepository $bookRepository, 
        ?Livre $book = null
    ): Response {
        // If no book exists (edit mode), create a new book
        if (!$book) {
            $book = new Livre();
        }

        // For edit mode, fetch the book based on the provided id (when editing)
        if ($request->attributes->get('_route') === 'edit_Book') {
            $id = $request->get('id');
            $book = $bookRepository->find($id);
            if (!$book) {
                throw $this->createNotFoundException('No book found for id ' . $id);
            }
        }

        $form = $this->createForm(LivreType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_read');
        }

        // Pass the book variable and editMode flag to the template
        return $this->render('livre/new.html.twig', [
            'form' => $form->createView(),
            'editMode' => $book->getId() !== null, // Check if book has an ID
            'book' => $book, // Pass the book entity to the template
        ]);
    }

    #[Route('/book/delete/{id}', name: 'delete_Book')]
public function deleteBook(int $id, LivreRepository $bookRepository, EntityManagerInterface $entityManager): Response
{
    $book = $bookRepository->find($id);
    if (!$book) {
        throw $this->createNotFoundException('No book found for id ' . $id);
    }

    $entityManager->remove($book);
    $entityManager->flush();

    // Redirect back to the list after deletion
    return $this->redirectToRoute('app_read');
}
}




