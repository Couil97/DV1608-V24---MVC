<?php

namespace App\CardGame;

use App\CardGame\CardHand;

class Card
{
    /**
     * Cards number value
    */
    protected int $value;
    /**
     * Cards suit value
     */
    protected string $suit;

    /**
     * Constructor for Card. Takes values at initialization and applies it to the object
    */
    public function __construct(int $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * Gets the value of the card (number)
     * @return int
    */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Gets the current suit of the card
     * @return string
    */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Change cards value
    */
    public function changeValue(int $value): void
    {
        $this->value = $value;
    }

    public function isEqual(Card $card) {
        return $this->value == $card->getValue() && $this->suit == $card->getSuit();
    }

    /**
     * Converts the card into a readable string
     * @return string
    */
    public function __toString(): string
    {
        return $this->suit . " " . $this->value;
    }
}
