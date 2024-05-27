<?php

namespace App\Poker\Hands;
use App\CardGame\CardGraphic;

class OnePair extends PokerHand
{
    public function __construct()
    {
        parent::__construct(9);
    }

    public function handEquals(array $cards) : bool {
        $equals = false;
        $countedCards = [];
        
        foreach ($cards as $key => $card) {
            for ($i = 0; $i < count($cards); $i++) { 
                if($i == $key) continue;

                if($card->getValue() == $cards[$i]->getValue()) {
                    $equals = true;
                    $countedCards = [$card, $cards[$i]];
                    break;
                }
            }

            if($equals) break;
        }

        return ($equals) ? $countedCards : [];
    }
}