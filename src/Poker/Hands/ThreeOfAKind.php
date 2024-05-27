<?php

namespace App\Poker\Hands;

class ThreeOfAKind extends PokerHand
{
    public function __construct()
    {
        parent::__construct(7);
    }

    public function handEquals(array $cards) : bool {
        $equals = false;
        $countedCards = [];
        
        foreach ($cards as $key => $card) {
            $numberOfKindIndex = -1;

            for ($i = 0; $i < count($cards); $i++) { 
                if($i == $key) continue;

                if($card->getValue() == $cards[$i]->getValue()) {   
                    if($numberOfKindIndex != -1) {
                        $equals = true;
                        
                        array_push($countedCards, $card, $cards[$i], $cards[$numberOfKindIndex]);
                        break;
                    }

                    $numberOfKindIndex = $i;
                }
            }

            if($equals) break;
        }

        return ($equals) ? $countedCards : [];
    }
}