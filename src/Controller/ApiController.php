<?php

namespace App\Controller;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\CardGame\CardGraphic;
use App\CardGame\CardHand;

use App\Entity\Book;
use App\Repository\BookRepository;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api-home.twig');
    }

    #[Route("/api/quote", name: "quote")]
    public function quote(): Response
    {
        $random = random_int(0, 3);
        date_default_timezone_set('Europe/Stockholm');

        $quotes = [
                "Idag är en av dagarna någonsin",
                "Imorgon kan vara idag, om idag är imorgon",
                "Gårdagens idag är dagens gårdag",
                "Övermorgon är dagen efter imorgondagens morgon"
        ];

        $data = [
            'qoute' => $quotes[$random],
            'date' => date("d-m-y"),
            'timestamp' => date('H:i:s')
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck", name: "api_card_deck")]
    public function deck(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $deck = $session->get('deck');

        $data = [
            'cards' => $deck->getAllSorted(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_card_shuffle")]
    public function deckShuffle(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $deck = $session->get('deck');
        $deck->shuffle();

        $data = [
            'cards' => $deck->getAll(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw", name: "api_card_draw")]
    public function deckDraw(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $deck = $session->get('deck');
        $card = $deck->draw();

        $data = [
            'cards' => $card,
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_card_draw_multiple")]
    public function deckDrawMultiple(SessionInterface $session, int $num): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $deck = $session->get('deck');
        $card = $deck->drawMultiple($num);

        $data = [
            'cards' => $card,
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/game", name: "api_game")]
    public function game(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('game-deck') || !$session->has('game-hand') || !$session->has('game-bank_hand')) {
            $cardDeck = new CardDeck();
            $cardDeck->shuffle();

            $session->set('game-hand', new CardHand());
            $session->set('game-deck', $cardDeck);
            $session->set('game-bank_hand', new CardHand());
            $session->set('game-status', "Running");
            $session->set('game-current_player', "Player");
        }

        $playerHand = $session->get('game-hand');
        $bankHand = $session->get('game-bank_hand');
        $status = $session->get('game-status');

        $data = [
            'player_value' => $playerHand->getSum(),
            'bank_value' => $bankHand->getSum(),
            'player_card_amount' => $playerHand->getNumberOfCards(),
            'bank_card_amount' => $bankHand->getNumberOfCards(),
            'game_status' => $status
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

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
