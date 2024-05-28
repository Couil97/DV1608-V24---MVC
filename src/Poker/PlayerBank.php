<?php
namespace App\Poker;

use App\CardGame\Card;
use App\Poker\PokerHands;
use App\Poker\PokerHand;

class PlayerBank
{
    public int $tokensLeft = 300;

    public function place(int $amt): int {
        return ($this->tokensLeft - $amt < 0) ? $this->tokensLeft = 0 : $this->tokensLeft -= $amt;
    }

    public function gain(int $amt): int {
        return $this->tokensLeft += $amt;
    }

    public function __toString(): string
    {
        return strval($this->tokensLeft);
    }
}
