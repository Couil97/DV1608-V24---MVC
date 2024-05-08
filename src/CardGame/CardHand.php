<?php

namespace App\CardGame;

use App\CardGame\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberOfCards(): int
    {
        return count($this->hand);
    }

    public function getCardsInHand(): array
    {
        return $this->hand;
    }

    public function getSum(): int
    {
        $sum = 0;
        $aces = 0;

        for($i = 0; $i < $this->getNumberOfCards(); $i++) {
            if($this->hand[$i]->getValue() == 1) {
                $aces += 1;
                continue;
            }

            $sum += $this->hand[$i]->getValue();
        }

        while($aces > 0) {
            $sum += 14;
            $aces -= 1;

            if($sum + $aces * 14 > 21) {
                $sum -= 13;
            }
        }

        return $sum;
    }

    public function getAll(): array
    {
        $copy = $this->hand;

        $values = [];
        foreach ($copy as $card) {
            $values[] = $card->getValues();
        }

        return $values;
    }

    public function getCardAt(int $index): Card
    {
        return $this->hand[$index];
    }

    public function __toString(): string
    {
        $result = '';
        foreach ($this->hand as $card) {
            $result .= $card;
        }

        return $result;
    }
}
