<?php

namespace App\Controller;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\CardGame\CardGraphic;
use App\CardGame\CardHand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(SessionInterface $session): Response
    {
        return $this->render('card.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function card_deck(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $deck = $session->get('deck');

        $data = [
            'deck' => $deck->getAllSorted()
        ];

        return $this->render('card_deck.twig', $data);
    }

    #[Route("/card/shuffle", name: "card_shuffle")]
    public function card_shuffle(SessionInterface $session): Response
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
            'deck' => $deck->getAll()
        ];

        return $this->render('card_deck.twig', $data);
    }
}
