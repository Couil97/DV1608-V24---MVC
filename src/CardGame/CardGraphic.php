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

    private $char =     "";
    private $graphicSuit;
    private $color;

    public function __construct(int $value, string $suit)
    {
        parent::__construct($value, $suit); // Gets parent constructor

        $this->setSuit($suit);
        $this->setValue($value);
    }

    private function setSuit($suit): void 
    {
        switch($suit) {
            case 'black_spade':
                $this->graphicSuit = $this->spade;
                $this->color = "black";
                break;
            case 'red_hearts':
                $this->graphicSuit = $this->hearts;
                $this->color = "red";
                break;
            case 'black_clubs':
                $this->graphicSuit = $this->clubs;
                $this->color = "black";
                break;
            case 'red_diamonds':
                $this->graphicSuit = $this->diamonds;
                $this->color = "red";
                break;
        }
    }

    private function setValue($value): void 
    {
        if($value == 1) {
            $this->char = "A";
        } elseif($value < 11) {
            $this->char = (string) $value;
        }
        
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

    public function getColor(): string 
    {
        return $this->color;
    }

    public function getGraphicSuit(): string 
    {
        return $this->graphicSuit;
    }

    public function getChar(): string
    {
        return $this->char;
    }

    public function getValues(): array
    {
        return [
            "char" => "{$this->char}",
            "suit" => "{$this->graphicSuit}",
            "color" => "{$this->color}"
        ];
    }

    public function __toString(): string
    {
        return "{$this->suit}" . " " . "{$this->char}";
    }
}
