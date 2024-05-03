<?php

namespace App\Controller;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\CardGame\CardGraphic;
use App\CardGame\CardHand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(SessionInterface $session): Response
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

        return $this->render('card_deck.twig', $data);
    }

    #[Route("/card/shuffle", name: "card_shuffle")]
    public function cardShuffle(SessionInterface $session): Response
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

        return $this->render('card_deck.twig', $data);
    }

    #[Route("/card/draw", name: "card_draw")]
    public function cardDraw(SessionInterface $session): Response
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

        return $this->render('card_deck.twig', $data);
    }

    #[Route("/card/draw/{num<\d+>}", name: "card_draw_multiple")]
    public function cardDrawMultiple(SessionInterface $session, int $num): Response
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

        return $this->render('card_deck.twig', $data);
    }
}
