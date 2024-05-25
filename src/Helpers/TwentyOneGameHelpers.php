<?php
namespace App\Helpers;

use App\CardGame\CardDeck;
use App\CardGame\CardHand;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwentyOneGameHelpers
{
    public function validateSession(SessionInterface $session) : bool
    {
        if($session == null) {
            return false;
        }

        $cardDeck = $session->get('game-deck');
        $cardHand = $session->get('game-hand');
        $bankHand = $session->get('game-bank_hand');

        // Revalidates session (incase someone leaves the game open long enough for the session to expire)
        if(!$cardDeck || !$cardHand || !$bankHand) {
            return false;
        }

        return true;
    }

    public function resetHand(SessionInterface $session) {
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
    }

    public function drawCard(SessionInterface $session)
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

    public function getData(SessionInterface $session) : array {
        // Sets variables
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

        return $data;
    }
}
