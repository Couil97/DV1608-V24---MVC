<?php

namespace App\Poker\Hands;

class Flush extends PokerHand
{
    public function __construct()
    {
        parent::__construct(5);
    }

    public function countCards(array $cards) : bool {
        $equals = true;

        for ($i = 0; $i < count($cards) - 1; $i++) { 
            if($cards[$i]->getSuit() != $cards[$i+1]->getSuit()) $equals = false;

            if(!$equals) return [];
        }

        return $cards;
    }
}