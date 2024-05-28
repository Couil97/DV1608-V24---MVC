<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class OnePair.
 */
class OnePairTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class OnePair.
    */
    public function testConstruct()
    {
        $pokerHand = new OnePair();
        $this->assertInstanceOf("\App\Poker\Hands\OnePair", $pokerHand);
    }

    /**
     * Validates that OnePair stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new OnePair();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 9);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new OnePair();
        
        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 22);

        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(8, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(12,  "red_diamonds"),
            new CardGraphic(11,  "red_hearts"),
            new CardGraphic(4, "red_diamonds"),
            new CardGraphic(4, "red_diamonds"),
            new CardGraphic(2,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 8);

        $cards = [
        ];

        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $pokerHand = new OnePair();
        
        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];

        $pokerHand->handEquals($cards);

        $this->assertIsString("" . $pokerHand);
    }
}
