<?php

namespace App\Poker\Hands;

class FullHouse extends PokerHand
{
    public function __construct()
    {
        parent::__construct(4);
    }

    public function handEquals(array $cards) : bool {
        $equals = false;
        $leftOver = [];

        foreach ($cards as $key => $card) {
            $numberOfKindIndex = -1;

            for ($i = 0; $i < count($cards); $i++) { 
                if($i == $key) continue;

                if($card->getValue() == $cards[$i]->getValue()) {   
                    if($numberOfKindIndex != -1) {
                        $leftOver = array_diff($countedCards, $card, $cards[$i], $cards[$numberOfKindIndex]);
                        break;
                    }

                    $numberOfKindIndex = $i;
                }
            }

            if(count($leftOver) > 0) break;
        }

        if($leftOver[0]->getValue() == $leftOver[1]->getValue()) $equals = true;

        return ($equals) ? $cards : [];
    }
}