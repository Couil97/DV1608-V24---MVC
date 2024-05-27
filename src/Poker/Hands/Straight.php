<?php

namespace App\Poker\Hands;

class Straight extends PokerHand
{
    public function __construct()
    {
        parent::__construct(6);
    }

    public function countCards(array $cards) : bool {
        $equals = true;

        for ($i = 0; $i < count($cards) - 1; $i++) { 
            if($cards[$i]->getValue() - $cards[$i+1]->getValue() != 1) $equals = false;

            if(!$equals) return [];
        }

        return $cards;
    }
}