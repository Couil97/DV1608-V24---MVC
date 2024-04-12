<?php

namespace App\CardGame;
use App\CardGame\Card;

class CardDeck
{
    private $deck = [];

    public function add(Card $card) : void {
        $this->deck[] = $card;
    }

    public function reset() : void {
        for ($i=0; $i < 52; $i++) {
            $this->add(new Card($i, 'spade'));
        }
    }

    public function getNumberOfCards() : int {
        return count($this->deck);
    }

    public function getCardsInDeck() : array {
        return $this->deck;
    }

    public function getCardAt(int $i) : Card {
        return $this->deck[$i];
    }
}