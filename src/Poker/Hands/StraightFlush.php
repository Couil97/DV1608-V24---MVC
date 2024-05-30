<?php

namespace App\Poker\Hands;
use App\Poker\PokerHand;

class StraightFlush extends PokerHand
{
    public function __construct()
    {
        parent::__construct(2, 'Straight flush');
    }

    public function countCards(array $cards) : array {
        $equals = true;

        // Kollar om korten innehåller ett ace och en kung
        if($cards[0]->getValue() == 14 && $cards[4]->getValue() == 2) {
            $cards[0]->changeValue(1);
            
            // Sorting highest to lowest
            usort($cards, fn($a, $b) => $b->getValue() - $a->getValue());
        }

        for ($i = 0; $i < count($cards) - 1; $i++) { 
            if($cards[$i]->getValue() - $cards[$i+1]->getValue() != 1)  $equals = false;
            if($cards[$i]->getSuit() != $cards[$i+1]->getSuit())        $equals = false;

            if(!$equals) return [];
        }

        return $cards;
    }
}