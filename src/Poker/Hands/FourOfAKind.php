<?php

namespace App\Poker\Hands;

class FourOfAKind extends PokerHand
{
    public function __construct()
    {
        parent::__construct(3);
    }

    public function countCards(array $cards) : bool {
        $equals = false;
        $countedCards = [];
        
        foreach ($cards as $key => $card) {
            $numberOfKindIndex = [];

            for ($i = 0; $i < count($cards); $i++) { 
                if($i == $key) continue;

                if($card->getValue() == $cards[$i]->getValue()) {   
                    if(count($numberOfKindIndex) == 2) {
                        $equals = true;
                        
                        array_push($countedCards, $card, $cards[$i], $cards[$numberOfKindIndex[0]], $cards[$numberOfKindIndex[1]]);
                        break;
                    }

                    array_push($numberOfKindIndex, $i);
                }
            }

            if($equals) break;
        }

        return ($equals) ? $countedCards : [];
    }
}