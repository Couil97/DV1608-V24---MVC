<?php
namespace App\Helpers;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LibraryHelpers extends AbstractController
{
    public function validateData(BookRepository $bookReposatory, string $type) : array {
        $data = ['error' => 0];
        
        if(isset($_POST['search'])) {
            $book = $this->getSearch($bookReposatory, $_POST['search'], $type);
            if(!$book) return ['error' => 1];
            
            $data = [
                'book' => $book,
                'type' => $type,
                'bookId' => $_POST['search'],
                'error' => -1
            ];
        }

        return $data;
    }

    public function handleBook(ManagerRegistry $doctrine, Book $book = new Book()) : int {
        $entityManager = $doctrine->getManager();

        if($_POST['title'] == "") {
            $this->addFlash(
                'warning',
                'Boken behöver en titel'
            );

            return -1;
        }
        
        $book->setTitle($_POST['title'] ?? '');
        $book->setISBN($_POST['ISBN'] ?? '');
        $book->setAuthor($_POST['author'] ?? '');

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return 0;
    }

    public function validateId() {
        $this->addFlash(
            'warning',
            'Direkt åtkomst till den sidan är förbjuden'
        );

        return isset($_POST['id']);
    }

    public function validateBook(Book $book) {
        if($book == null) {
            $this->addFlash(
                'warning',
                'Ingen bok har detta id'
            );
        }

        return $book;
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

    public function deleteOne(ManagerRegistry $doctrine, int $bookId) {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($bookId);

        $title = $book->getTitle();

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Boken "' . $title . '" har blivit raderad'
        );

    }

    public function deleteAll(ManagerRegistry $doctrine) {
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
    }
}
