<?php

namespace App\Poker\Hands;
use App\Poker\PokerHand;

class FullHouse extends PokerHand
{
    public function __construct()
    {
        parent::__construct(4);
    }

    public function countCards(array $cards) : array {
        $hashmap = array();
        $output = array();
        
        for ($i = 0; $i < count($cards); $i++) {
            $key = strval($cards[$i]->getValue());
            if(!array_key_exists($key, $hashmap)) $hashmap += [$key => array($cards[$i])];
            else array_push($hashmap[$key], $cards[$i]);
        }

        foreach ($hashmap as $key => $values) {
            if(count($values) == 2) $output = array_merge($output, $values);
            if(count($values) == 3) $output = array_merge($output, $values);
        }

        return (count($output) == 5) ? $output : [];
    }
}