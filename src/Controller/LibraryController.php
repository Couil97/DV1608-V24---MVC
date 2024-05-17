<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function libraryIndex(
        BookRepository $bookReposatory
    ): Response {
        $total = $bookReposatory->getTotalCount();

        $data = [
            'total' => $total[0]['COUNT(*)']
        ];

        return $this->render('library/index.twig', $data);
    }

    #[Route('/library/view/all', name: 'library_view_all')]
    public function libraryViewAll(
        BookRepository $bookReposatory
    ): Response {
        $books = $bookReposatory->findAll();

        $data = [
            'books' => $books,
            'type' => 'showAll'
        ];

        return $this->render('library/view.twig', $data);
    }

    #[Route('/library/view/{id}', name: 'library_view_one')]
    public function libraryViewOne(
        BookRepository $bookReposatory,
        int $bookId
    ): Response {
        $book = $bookReposatory->find($bookId);

        $data = [
            'book' => $book,
            'type' => 'showOne'
        ];

        return $this->render('library/view-one.twig', $data);
    }

    #[Route('/library/search', name: 'library_search')]
    public function librarySearch(): Response {

        $data = [
            'title' => 'Sök',
            'placeholder' => 'Namn, id, etc',
            'type' => 'search'
        ];

        return $this->render('library/search.twig', $data);
    }

    #[Route('/library/view/type/{type}', name: 'library_view_type')]
    public function libraryView(
        BookRepository $bookReposatory,
        string $type
    ): Response {
        if(isset($_POST['search'])) {
            $book = $this->getSearch($bookReposatory, $_POST['search'], $type);

            if(!$book) {
                switch($type) {
                    case 'search':
                        return $this->redirectToRoute('library_search');
                    case 'update':
                        return $this->redirectToRoute('library_update');
                    case 'delete':
                        return $this->redirectToRoute('library_delete');
                }

            }

            $data = [
                'book' => $book,
                'type' => $type,
                'id' => $_POST['search']
            ];

            return $this->render('library/view-one.twig', $data);
        }

        $this->addFlash(
            'warning',
            'Direkt åtkomst till den sidan är förbjuden'
        );

        return $this->redirectToRoute('library_search');
    }

    #[Route('/library/create', name: 'library_create')]
    public function libraryCreate(
        BookRepository $bookReposatory
    ): Response {
        $headers = $bookReposatory->getHeaders();

        $data = [
            'headers' => $headers,
            'type' => 'create'
        ];

        return $this->render('library/create.twig', $data);
    }

    #[Route('/library/create/posting', name: 'library_create_posting')]
    public function libraryCreateInProgress(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($_POST['title'] ?? '');
        $book->setISBN($_POST['ISBN'] ?? '');
        $book->setAuthor($_POST['author'] ?? '');

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Ny bok "' . $_POST['title'] . '" skapad'
        );

        return $this->redirectToRoute('library_view_all');
    }


    #[Route('/library/update', name: 'library_update')]
    public function libraryUpdate(
        BookRepository $bookReposatory
    ): Response {
        $headers = $bookReposatory->getHeaders();

        $data = [
            'headers' => $headers,
            'type' => 'update'
        ];

        return $this->render('library/create.twig', $data);
    }

    #[Route('/library/update/post', name: 'library_update_post')]
    public function libraryUpdateInProgress(
        ManagerRegistry $doctrine
    ): Response {
        if(isset($_POST['id'])) {
            $entityManager = $doctrine->getManager();
            $book = $entityManager->getRepository(Book::class)->find($_POST['id']);

            if(!$book) {
                $this->addFlash(
                    'warning',
                    'Ingen bok har detta id'
                );

                return $this->redirectToRoute('library_update');
            }

            $book->setTitle($_POST['title'] ?? '');
            $book->setISBN($_POST['ISBN'] ?? '');
            $book->setAuthor($_POST['author'] ?? '');

            // tell Doctrine you want to (eventually) save the Product
            // (no queries yet)
            $entityManager->persist($book);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Updaterade boken "' . $_POST['title'] . '"'
            );

            return $this->redirectToRoute('library_view_all');
        }

        $this->addFlash(
            'warning',
            'Direkt åtkomst till den sidan är förbjuden'
        );

        return $this->redirectToRoute('library_update');
    }


    #[Route('/library/delete', name: 'library_delete')]
    public function libraryDelete(): Response {
        $data = [
            'title' => 'Radera',
            'placeholder' => 'Radera id',
            'type' => 'delete'
        ];

        return $this->render('library/search.twig', $data);
    }

    #[Route('/library/delete/post/{id}', name: 'library_delete_post')]
    public function libraryDeleteInProgress(
        ManagerRegistry $doctrine,
        int $bookId
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($bookId);

        $title = $book->getTitle();

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Boken "' . $title . '" har blivit raderad'
        );

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete/all/confirm', name: 'library_delete_all_confirm')]
    public function libraryDeleteAllConfirm(): Response {
        return $this->render('library/delete-confirm.twig');
    }

    #[Route('/library/delete/all', name: 'library_delete_all')]
    public function libraryDeleteAllInProgress(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $books = $entityManager->getRepository(Book::class)->findAll();

        foreach($books as $book) {
            $entityManager->remove($book);
        }

        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Alla böcker har raderas'
        );

        return $this->redirectToRoute('library');
    }

    private function getSearch($bookReposatory, $search, $type)
    {
        if($type == 'search') {
            $book = $bookReposatory->searchDb($search);

            if(!$book) {

                $this->addFlash(
                    'warning',
                    'Ingen bok matchade denna sökning'
                );

                return null;
            }

            $result = $book[0]['id'];
        } else {
            $result = $search;
        }

        $book = $bookReposatory->find($result);

        if(!$book) {

            $this->addFlash(
                'warning',
                'Ingen bok matchade detta id'
            );

            return null;
        }

        return $book;
    }
}
