<?php

namespace App\CardGame;

use App\CardGame\Card;

class CardDeck
{
    private $deck = [];

    public function __construct()
    {
        $this->reset();
    }

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function remove(Card $card): void
    {
        for($i = 0; i < count($this->deck); $i++) {
            if($card->getValue() == $this->deck[$i]->getValue()
            &&  $card->getColor() == $this->deck[$i]->getColor()) {
                unset($this->deck[$i]);
                break;
            }
        }
    }

    public function draw(CardHand $hand): void
    {
        $card = $this->deck[0];

        $this->remove($card);
        $hand->add($card);
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function getAll(): array
    {
        $copy = $this->deck;

        $values = [];
        foreach ($copy as $card) {
            $values[] = $card->getValues();
        }

        return $values;
    }


    public function getAllSorted(): array
    {
        $copy = $this->deck;

        usort($copy, function ($a, $b) {
            if($a->getSuit() == $b->getSuit()) {
                return $a->getValue() > $b->getValue();
            }
            return strcmp($a->getSuit(), $b->getSuit());
        });

        $values = [];
        foreach ($copy as $card) {
            $values[] = $card->getValues();
        }

        return $values;
    }

    public function showAll(): string
    {
        $result = '';
        foreach ($this->deck as $card) {
            $result .= $card;
        }

        return $result;
    }

    public function reset(): void
    {
        for ($i = 0; $i < 52; $i++) {
            switch(true) {
                case ($i < 13):
                    $this->add(new CardGraphic((($i % 13) + 1), 'black_spade'));
                    break;
                case ($i >= 13 && $i < 26):
                    $this->add(new CardGraphic((($i % 13) + 1), 'red_hearts'));
                    break;
                case ($i >= 26 && $i < 39):
                    $this->add(new CardGraphic((($i % 13) + 1), 'red_diamonds'));
                    break;
                case ($i >= 39):
                    $this->add(new CardGraphic((($i % 13) + 1), 'black_clubs'));
                    break;
            }
        }
    }

    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }

    public function getCardsInDeck(): array
    {
        return $this->deck;
    }

    public function getCardAt(int $i): Card
    {
        return $this->deck[$i];
    }

    public function __toString(): string
    {
        return $this->showAll();
    }
}
