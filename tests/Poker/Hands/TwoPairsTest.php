<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class TwoPairs.
 */
class TwoPairsTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class TwoPairs.
    */
    public function testConstruct()
    {
        $pokerHand = new TwoPairs();
        $this->assertInstanceOf("\App\Poker\Hands\TwoPairs", $pokerHand);
    }

    /**
     * Validates that TwoPairs stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new TwoPairs();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 8);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new TwoPairs();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 26);

        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(9, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(14,  "red_diamonds"),
            new CardGraphic(14,  "red_hearts"),
            new CardGraphic(2, "red_diamonds"),
            new CardGraphic(2, "red_diamonds"),
            new CardGraphic(2,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(10,  "red_diamonds"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(2,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

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
        $pokerHand = new TwoPairs();
        
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