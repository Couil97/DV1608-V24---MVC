<?php

namespace App\Controller;

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
        $i = random_int(0, 3);
        date_default_timezone_set('Europe/Stockholm');

        $quotes = [
                "Idag är en av dagarna någonsin",
                "Imorgon kan vara idag, om idag är imorgon",
                "Gårdagens idag är dagens gårdag",
                "Övermorgon är dagen efter imorgondagens morgon"
        ];

        $data = [
            'qoute' => $quotes[$i],
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
    public function deck_shuffle(SessionInterface $session): Response
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
    public function deck_draw(SessionInterface $session): Response
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
    public function deck_draw_multiple(SessionInterface $session, int $num): Response
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
