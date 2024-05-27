<?php

namespace App\Helpers;

use App\CardGame\CardDeck;
use App\CardGame\CardHand;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TwentyOneGameHelpers
{
    public function validateSession(SessionInterface $session): bool
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
}