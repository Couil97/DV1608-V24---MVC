<?php

namespace App\Poker\Hands;
use App\Poker\PokerHand;

class Flush extends PokerHand
{
    public function __construct()
    {
        parent::__construct(5, 'Flush');
    }

    public function countCards(array $cards) : array {
        $equals = true;

        for ($i = 0; $i < count($cards) - 1; $i++) { 
            if($cards[$i]->getSuit() != $cards[$i+1]->getSuit()) $equals = false;

            if(!$equals) return [];
        }

        return $cards;
    }
}