<?php

namespace App\Poker\Hands;
use App\CardGame\CardGraphic;

class HighCard extends PokerHand
{
    public function __construct()
    {
        parent::__construct(10);
    }

    public function handEquals(array $cards) : bool {
        $equals = false;
        $countedCards = [];

        if(count($cards) > 0) {
            $equals = true;
            array_push($countedCards, $cards[0]);
        }

        return ($equals) ? $countedCards : [];
    }
}