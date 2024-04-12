<?php

namespace App\CardGame;

use App\Dice\CardHand;

class Card
{
    protected int $value;
    protected string $color;

    public function __construct(int $value, string $color)
    {
        $this->value = $value;
        $this->color = $color;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function __toString(): string
    {
        return $this->value . ' ' . $this->color;
    }
}
