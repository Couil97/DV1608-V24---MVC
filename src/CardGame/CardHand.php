<?php

namespace App\CardGame;
use App\CardGame\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card) : void {
        $this->hand[] = $card;
    }

    public function remove(Card $card) : void {
        for($i = 0; i < count($this->hand); $i++) {
            if( $card->getValue() == $this->hand[$i]->getValue() 
            &&  $card->getColor() == $this->hand[$i]->getColor()) {
                unset($this->hand[$i]);
            }
        }
    }

    public function getNumberOfCards() : int {
        return count($this->hand);
    }

    public function getCardsInHand() : array {
        return $this->hand;
    }

    public function getCardAt(int $i) : Card {
        return $this->hand[$i];
    }
}