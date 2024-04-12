<?php

namespace App\CardGame;

class CardGraphic extends Card
{
    // A -> 9 = 0-8 (+1)
    // 10 = A, J = B, Q = D, K = E

    private $spade =    "♠";
    private $hearts =   "♥";
    private $diamonds = "♦";
    private $clubs =    "♣";

    private $king =     "♔";
    private $queen =    "♕";
    private $jack =     "J";

    private $char;
    private $suit;

    public function __construct(int $value, string $color)
    {
        parent::__construct($value, $color); // Gets parent constructor

        if($value == 1) {
            $this->char = '';
        } elseif($value < 11) {
            $this->char = (string) $value;
        } else {
            switch($this->getValue()) {
                case 11:
                    $this->char = $this->jack;
                    break;
                case 12:
                    $this->char = $this->queen;
                    break;
                case 13:
                    $this->char = $this->king;
                    break;
            }
        }

        switch($color) {
            case 'spade':
                $this->suit = $this->spade;
                break;
            case 'hearts':
                $this->suit = $this->hearts;
                break;
            case 'clubs':
                $this->suit = $this->clubs;
                break;
            case 'diamonds':
                $this->suit = $this->diamonds;
                break;
        }
    }

    public function getChar(): string
    {
        return $this->char or '';
    }

    public function getValues() : array {
        return ["{$this->char}", "{$this->suit}"];
    }

    public function __toString(): string
    {
        return "{$this->char}" . "{$this->suit}";
    }
}
