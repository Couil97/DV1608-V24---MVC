<?php
namespace App\Helpers;

use App\CardGame\CardDeck;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameHelpers
{
    public static function validateSession(SessionInterface $session) {
        if(!$session->isStarted()) {
            $session->start();
        }

        if(!$session->has('deck')) {
            $session->set('deck', new CardDeck());
        }
    }
}
