<?php

namespace App\Controller;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\CardGame\CardGraphic;
use App\CardGame\CardHand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

enum GameStatus
{
    case Running;
    case Won;
    case Lost;
}

enum Player
{
    case Player;
    case Bank;
}

class TwentyOneGameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/home.twig');
    }

    #[Route("/game/start", name: "game_start")]
    public function gameStart(SessionInterface $session): Response
    {
        // Resets if session is missing variables
        $this->validateSession($session);

        $cardDeck = $session->get('game-deck');
        $cardHand = $session->get('game-hand');
        $bankHand = $session->get('game-bank_hand');

        // Revalidates session (incase someone leaves the game open long enough for the session to expire)
        if(!$cardDeck || !$cardHand || !$bankHand) {
            $this->redirectToRoute('game_reset');
        }

        $data = [
            "hand" => $cardHand->getAll(),
            "bank" => $bankHand->getAll(),
            "hand_value" => $cardHand->getSum(),
            "bank_value" => $bankHand->getSum(),
            "cards_left" => $cardDeck->getNumberOfCards(),
            "status" => $session->get("game-status"),
            "player" => $session->get("game-current_player")
        ];

        return $this->render('game/gameboard.twig', $data);
    }

    #[Route("/game/draw", name: "game_draw")]
    public function gameDraw(SessionInterface $session): Response
    {
        // Resets if session is missing variables
        $this->validateSession($session);

        // Checks if user has already won/lost
        if($session->get('game-status') != "Running") {
            // Sets variables
            $cardDeck = $session->get('game-deck');
            $cardHand = $session->get('game-hand');
            $bankHand = $session->get('game-bank_hand');

            // Revalidates session (incase someone leaves the game open long enough for the session to expire)
            if(!$cardDeck || !$cardHand || !$bankHand) {
                $this->redirectToRoute('game_reset');
            }

            $data = [
                "hand" => $cardHand->getAll(),
                "bank" => $bankHand->getAll(),
                "hand_value" => $cardHand->getSum(),
                "bank_value" => $bankHand->getSum(),
                "cards_left" => $cardDeck->getNumberOfCards(),
                "status" => $session->get("game-status"),
                "player" => $session->get("game-current_player")
            ];

            return $this->render('game/gameboard.twig', $data);
        }

        // Draw new card(s)
        $this->drawCard($session);

        // Sets variables
        $cardDeck = $session->get('game-deck');
        $cardHand = $session->get('game-hand');
        $bankHand = $session->get('game-bank_hand');

        $data = [
            "hand" => $cardHand->getAll(),
            "bank" => $bankHand->getAll(),
            "hand_value" => $cardHand->getSum(),
            "bank_value" => $bankHand->getSum(),
            "cards_left" => $session->get('game-deck')->getNumberOfCards(),
            "status" => $session->get("game-status"),
            "player" => $session->get("game-current_player")
        ];

        return $this->render('game/gameboard.twig', $data);
    }

    #[Route("/game/change_player", name: "game_change_player")]
    public function gameChangePlayer(SessionInterface $session): Response
    {
        $session->set('game-current_player', "bank");

        return $this->redirectToRoute('game_draw');
    }

    #[Route("/game/reset", name: "game_reset")]
    public function gameReset(SessionInterface $session): Response
    {
        if(!$session->isStarted()) {
            $session->start();
        }

        $cardDeck = new CardDeck();
        $cardDeck->shuffle();

        $session->set('game-hand', new CardHand());
        $session->set('game-deck', $cardDeck);
        $session->set('game-bank_hand', new CardHand());
        $session->set('game-status', "Running");
        $session->set('game-current_player', "Player");

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.twig');
    }

    public function validateSession($session)
    {
        if(!$session) {
            return $this->redirectToRoute('game_reset');
        }

        if(!$session->has('game-deck') || !$session->has('game-hand') || !$session->has('game-bank_hand')) {
            return $this->redirectToRoute('game_reset');
        }
    }

    public function drawCard($session)
    {
        // Sets variables
        $cardDeck = $session->get('game-deck');
        $cardHand = $session->get('game-hand');
        $bankHand = $session->get('game-bank_hand');

        if($session->get('game-current_player') == "Player") {
            $cardHand->add($cardDeck->drawCard());

            // Checks if players sum of cards if greater than 21
            // Since the player loses if their sum is greater than 21, set game-status to lost
            if($cardHand->getSum() > 21) {
                $session->set('game-status', "Lost");
            }
        }

        if ($session->get('game-current_player') != "Player") {
            // Bank draw cards until they're over 17
            while($bankHand->getSum() < 17) {
                $bankHand->add($cardDeck->drawCard());
            }

            $session->set('game-status', "Lost");

            // If bank goes over 21 or if bank has lower value than player, player wins
            if($bankHand->getSum() > 21 || $bankHand->getSum() < $cardHand->getSum()) {
                $session->set('game-status', "Won");
            }
        }

        $session->set('game-deck', $cardDeck);
        $session->set('game-hand', $cardHand);
        $session->set('game-bank_hand', $bankHand);
    }
}
