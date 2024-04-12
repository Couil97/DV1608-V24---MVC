<?php

namespace App\CardGame;

class CardGraphic extends Card
{
    // A -> 9 = 1-9
    // 10 = A, J = B, Q = D, K = E

    private $spade =    "U+1F0A";
    private $hearts =   "U+1F0B";
    private $diamonds = "U+1F0C";
    private $clubs =    "U+1F0D";

    public function __construct()
    {
        parent::__construct(); // Gets parent constructor
    }

    public function getString() : string { // Overrides class from super class
        switch($this->getColor()) {
            case 'spade': 
                return $this->spade + $this->getValue();
            case 'hearts': 
                return $this->hearts + $this->getValue();
            case 'diamonds': 
                return $this->diamonds + $this->getValue();
            case 'clubs': 
                return $this->clubs + $this->getValue();
        }
    }
}