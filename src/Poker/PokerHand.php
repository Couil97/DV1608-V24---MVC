<?php

namespace App\Poker;

use App\Poker\PokerHand;

abstract class PokerHand
{
    protected int $rank;
    protected int $value;

    public function __construct(int $rank)
    {
        $this->rank = $rank;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(array $cards) : string
    {
        $sum = 0;
        foreach ($cards as $key => $card) {
            $sum += $card->getValue();
        }

        $value = $sum;
    }

    function handEquals(array $cards) : bool {
        $equals = false;
        
        // Sorting highest to lowest
        usort($cards, fn($a, $b) => $a->getValue() - $b->getValue());

        $countedCards = $this->countCards($cards);

        $this->setCardValue($countedCards);
        return count($countedCards) > 0;
    }

    abstract function countCards(array $cards) : array;

    public function __toString(): string
    {
        return "Rank: " . strval($rank) . "\nValue: " . strval($value);
    }
}
