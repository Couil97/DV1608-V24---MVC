<?php

namespace App\Controller\API;

use App\CardGame\CardDeck;
use App\CardGame\CardHand;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiGameController extends AbstractController
{
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
}