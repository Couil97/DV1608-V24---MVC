<?php

namespace App\Poker\Hands;
use App\CardGame\CardGraphic;

class TwoPairs extends PokerHand
{
    public function __construct()
    {
        parent::__construct(8);
    }

    public function handEquals(array $cards) : bool {
        $equals = false;
        $countedCards = [];
        
        foreach ($cards as $key => $card) {
            for ($i = 0; $i < count($cards); $i++) { 
                if($i == $key) continue;

                if($card->getValue() == $cards[$i]->getValue()) {                    
                    if(count($countedCards) != 0 && $card->getValue() != $countedCards[0]->getValue()) {
                        $equals = true;
                        
                        array_push($countedCards, $card, $cards[$i]);
                        break;
                    }

                    $countedCards = [$card, $cards[$i]];
                }
            }

            if($equals) break;
        }

        return ($equals) ? $countedCards : [];
    }
}