<?php

namespace App\Helpers;

use App\Poker\Gameboard;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerHelpers
{
    public static function startGame(SessionInterface $session, int $playerCount, string $playerName) {
        self::resetGameboard($session);
        
        $cheating = false;

        foreach ($_POST as $key => $value) {
            if($key == 'numberOfPlayers' && $value)   $playerCount = $value;
            if($key == 'cheating' && $value)          $cheating = $value;
            if($key == 'name' && $value)              $playerName = $value;
        }

        $gameboard = new Gameboard();
        $gameboard->start($cheating);

        for ($i=0; $i < $playerCount; $i++) { 
            if($i == 0) $gameboard->addPlayer('player', $playerName);
            else $gameboard->addPlayer('CPU', 'CPU ' . $i - 1);
        }

        $gameboard->drawAll();
        self::save($session, $gameboard);

        return $gameboard->getData();
    }

    public static function drawCards(SessionInterface $session) {
        if(self::validateSession($session)) {
            $gameboard = self::getGameboard($session);

            if($gameboard == null) return [];

            $cards = [];

            foreach ($_POST as $key => $value) {
                array_push($cards, $value);
            }

            // Random remove function for CPUs
            for ($i=0; $i < $gameboard->getData()['playerCount'] - 1; $i++) {
                $numbers = range(0, 5);
                shuffle($numbers);
                $numbers = array_slice($numbers, 0, rand(0,5));

                $gameboard->remove($i+1, $numbers);
                $gameboard->placeBet($i+1, rand(0,50));
            }

            if(count($cards) > 0) $gameboard->remove(0, $cards);
            $gameboard->drawAll();

            self::save($session, $gameboard);
            return $gameboard->getData();
        }

        return [];
    }

    public static function endRound(SessionInterface $session) {
        if(self::validateSession($session)) {
            $gameboard = self::getGameboard($session);

            if($gameboard == null) return [];
            
            $counter = 0;

            while($gameboard->getData()['status'] == 1 && $counter < 5) {
                // Random remove function for CPUs
                for ($i=0; $i < $gameboard->getData()['playerCount'] - 1; $i++) {
                    $numbers = range(0, 5);
                    shuffle($numbers);
                    $numbers = array_slice($numbers, 0, rand(0,5));

                    $gameboard->remove($i+1, $numbers);
                    $gameboard->placeBet($i+1, rand(0,50));
                }

                $gameboard->drawAll();

                $counter += 1;
            }

            self::save($session, $gameboard);
            return $gameboard->getData();
        }

        return [];
    }

    public static function bet(SessionInterface $session) {
        if(self::validateSession($session)) {
            $gameboard = self::getGameboard($session);
            $bet = 0;

            foreach ($_POST as $key => $value) {
                if($key == 'bet' && $value != '' && $value) $bet = $value; 
            }

            $gameboard->placeBet(0, $bet);
            self::save($session, $gameboard);

            return $gameboard->getData();
        }

        return [];
    }

    private static function resetGameboard(SessionInterface $session) {
        $session->remove('gameboard');
    }

    private static function save(SessionInterface $session, Gameboard $gameboard) {
        //self::validateSession($session);
        self::setGameboard($gameboard, $session);
    }

    private static function validateSession(SessionInterface $session): bool {
        $valid = true;
        
        if(!$session->isStarted()) {
            $session->start();
            //$valid = false;
        }

        return $valid;
    }

    private static function setGameboard(Gameboard $gameboard, SessionInterface $session) {
        $session->set('gameboard', $gameboard);
    }

    private static function getGameboard($session) {
        return $session->get('gameboard');
    }
}