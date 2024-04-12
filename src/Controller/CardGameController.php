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
    public function lucky(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }

        $session->get('deck')->showAll();

        $data = [
        ];

        return $this->render('card.twig', $data);
    }
}
