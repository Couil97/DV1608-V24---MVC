<?php

namespace App\Poker;
use App\CardGame\Card;

class PlayerHand
{
    private $cardLimit;
    private $hand;

    public function __construct(int $cardLimit = 5) {
        $this->cardLimit = $cardLimit;
        $this->hand = array();
    }

    public function removeCard(array $indices): void {
        rsort($indices);

        for ($i=0; $i < count($indices); $i++) { 
            array_splice($this->hand, $indices[$i], 1);
        }
    }

    public function addCard(Card $addedCard): void {
        if(count($this->hand) < $this->cardLimit) {
            array_push($this->hand, $addedCard);
        }
    }

    public function getCount(): int
    {
        return count($this->hand);
    }

    public function getCard(int $index): Card
    {
        return $this->hand[$index];
    }

    public function getHand(): array {
        return $this->hand;
    }

    public function reset(): void {
        $this->hand = [];
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
