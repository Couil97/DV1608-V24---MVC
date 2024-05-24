<?php

namespace App\Controller\API;
    
use App\Repository\BookRepository;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiLibraryController extends AbstractController
{
    #[Route("/api/library/books", name: "api_library_books")]
    public function apiLibraryBooks(BookRepository $bookReposatory): Response
    {
        $books = $bookReposatory->findAll();

        $data = [
            'books' => $bookReposatory->toArray($books),
            'type' => 'showAll'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/library/book/{isbn}", name: "api_library_isbn_books")]
    public function apiLibraryISBNBooks(BookRepository $bookReposatory, string $isbn): Response
    {
        $books = $bookReposatory->searchISBN($isbn);

        $data = [
            'books' => $books,
            'type' => 'showISBN'
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}