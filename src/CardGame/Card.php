<?php

namespace App\CardGame;
use App\Dice\CardHand;

class Card
{
    protected $value;
    protected $color;

    public function __construct(string $value, string $color)
    {
        $this->value = $value;
        $this->color = $color;
    }

    public function getValue() {
        return $this->value;
    }
    
    public function getColor() {
        return $this->color;
    }

    public function getString() : string {
        return $this->value;
    }
}