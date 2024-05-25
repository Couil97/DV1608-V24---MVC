<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Helpers\LibraryHelpers;

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

    #[Route('/library/view/{bookId}', name: 'library_view_one')]
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
    public function librarySearch(): Response
    {
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
        LibraryHelpers $helpers,
        string $type
    ): Response {
        $data = $helpers->validateData($bookReposatory, $type);

        switch($data['error']) {
            case 0:
                $this->addFlash(
                    'warning',
                    'Direkt åtkomst till den sidan är förbjuden'
                );

                return $this->redirectToRoute('library_search');
            case 1:
                switch($type) {
                    case 'search':
                        return $this->redirectToRoute('library_search');
                    case 'update':
                        return $this->redirectToRoute('library_update');
                    case 'delete':
                        return $this->redirectToRoute('library_delete');
                    default:
                        return $this->redirectToRoute('library_view_all');
                }
                // no break
            default:
                return $this->render('library/view-one.twig', $data);
        };
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
        ManagerRegistry $doctrine,
        LibraryHelpers $helpers
    ): Response {
        $error = $helpers->handleBook($doctrine);

        if($error < 0) {
            return $this->redirectToRoute('library_create');
        }

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

    #[Route('/library/update/change', name: 'library_update_id')]
    public function libraryUpdateId(
        BookRepository $bookReposatory,
        LibraryHelpers $helpers
    ): Response {
        if(!$helpers->validateId()) {
            return $this->redirectToRoute('library_update');
        }

        $book = $bookReposatory->find($_POST['id']);
        if($book == null) {
            return $this->redirectToRoute('library_update');
        }

        $data = [
            'headers' => $bookReposatory->getHeaders(),
            'book' => $bookReposatory->toArray([$book])[0] ,
            'type' => 'update'
        ];

        return $this->render('library/update.twig', $data);
    }

    #[Route('/library/update/post', name: 'library_update_post')]
    public function libraryUpdateInProgress(
        ManagerRegistry $doctrine,
        LibraryHelpers $helpers
    ): Response {
        if(!$helpers->validateId()) {
            return $this->redirectToRoute('library_update');
        }

        $book = $helpers->validateBook($doctrine->getManager()->getRepository(Book::class)->find($_POST['id']));
        if($book == null) {
            return $this->redirectToRoute('library_update');
        }

        if($helpers->handleBook($doctrine, $book) == 1) {
            return $this->redirectToRoute('library_update');
        }

        $this->addFlash(
            'notice',
            'Updaterade boken "' . $_POST['title'] . '"'
        );

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete', name: 'library_delete')]
    public function libraryDelete(): Response
    {
        $data = [
            'title' => 'Radera',
            'placeholder' => 'Radera id',
            'type' => 'delete'
        ];

        return $this->render('library/search.twig', $data);
    }

    #[Route('/library/delete/post/{bookId}', name: 'library_delete_post')]
    public function libraryDeleteInProgress(
        ManagerRegistry $doctrine,
        LibraryHelpers $helpers,
        int $bookId
    ): Response {
        $helpers->deleteOne($doctrine, $bookId);
        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete/all/confirm', name: 'library_delete_all_confirm')]
    public function libraryDeleteAllConfirm(): Response
    {
        return $this->render('library/delete-confirm.twig');
    }

    #[Route('/library/delete/all', name: 'library_delete_all')]
    public function libraryDeleteAllInProgress(
        ManagerRegistry $doctrine,
        LibraryHelpers $helpers
    ): Response {
        $helpers->deleteAll($doctrine);
        return $this->redirectToRoute('library');
    }
}
