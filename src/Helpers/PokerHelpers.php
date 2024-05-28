<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerHelpers
{
    private function save(SessionInterface $session, Gameboard $gameboard) {
        $status = $this->validateSession($session);
        if($status) $this->setGameboard($gameboard, $session);
        else /* Something */;
    }

    public static function validateSession(SessionInterface $session): bool {
        $valid = true;

        if(!$session->isStarted()) {
            $session->start();
            $valid = false;
        }

        return $valid;
    }

    public static function setGameboard(Gameboard $gameboard, SessionInterface $session) {
        $session->set('gameboard', $gameboard);
    }

    public static function resetSession(SessionInterface $session) {
        $session->invalidate();
        
        $this->validateSession();
    }
}