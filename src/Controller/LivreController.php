<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }

    #[Route('/readsliste', name: 'app_read')]
    public function read(LivreRepository $bookRepository): Response
    {
        $list = $bookRepository->findAll();
        return $this->render('livre/read.html.twig', ["liste" => $list]);
    }

    #[Route('/book/nouveau', name: 'nouveau_Book')]
    #[Route('/book/edit/{id}', name: 'edit_Book')]
    public function manageBook(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        LivreRepository $bookRepository,
        SluggerInterface $slugger,
        ?Livre $book = null
    ): Response {
        if (!$book) {
            $book = new Livre();
        }

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
            $imageFile = $form->get('ImageLivre')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $logger->error('Failed to upload image: ' . $e->getMessage());
                }

                $book->setImageLivre($newFilename);
            }

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_read');
        }

        return $this->render('livre/new.html.twig', [
            'form' => $form->createView(),
            'editMode' => $book->getId() !== null,
            'book' => $book,
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

        return $this->redirectToRoute('app_read');
    }

    
    
}