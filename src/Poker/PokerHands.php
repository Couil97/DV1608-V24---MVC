<?php
namespace App\Poker;

use App\Poker\Hands\FiveOfAKind;
use App\Poker\Hands\StraightFlush;
use App\Poker\Hands\FourOfAKind;
use App\Poker\Hands\FullHouse;
use App\Poker\Hands\Flush;
use App\Poker\Hands\Straight;
use App\Poker\Hands\ThreeOfAKind;
use App\Poker\Hands\TwoPairs;
use App\Poker\Hands\OnePair;
use App\Poker\Hands\HighCard;

class PokerHands
{
    public static function getHighestPokerHand(array $hand): PokerHand {
        $pokerHands = [
            new FiveOfAKind(),
            new StraightFlush(),
            new FourOfAKind(),
            new FullHouse(),
            new Flush(),
            new Straight(),
            new ThreeOfAKind(),
            new TwoPairs(),
            new OnePair(),
            new HighCard(),
        ];

        foreach ($pokerHands as $key => $pokerHand) {
            if($pokerHand->handEquals($hand)) return $pokerHand;
        }
    }
}
