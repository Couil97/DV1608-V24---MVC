<?php

namespace App\Poker\Hands;
use App\Poker\PokerHand;

class DefaultHand extends PokerHand
{
    public function __construct()
    {
        parent::__construct(99, 'Default');
        $this->value = -1;
    }

    public function countCards(array $cards) : array {
        return [];
    }
}