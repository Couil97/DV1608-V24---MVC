<?php

namespace App\Controller\API;

use App\CardGame\CardDeck;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDeckController extends AbstractController
{
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
}
