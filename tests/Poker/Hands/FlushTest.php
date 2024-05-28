<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Flush.
 */
class FlushTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class Flush.
    */
    public function testConstruct()
    {
        $pokerHand = new Flush();
        $this->assertInstanceOf("\App\Poker\Hands\Flush", $pokerHand);
    }

    /**
     * Validates that Flush stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new Flush();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 5);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new Flush();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(8,  "red_diamonds"),
            new CardGraphic(12, "red_diamonds"),
            new CardGraphic(1,  "red_diamonds"),
            new CardGraphic(4,  "red_diamonds")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 40);

        $cards = [
            new CardGraphic(1,  "red_diamonds"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(9,  "red_diamonds"),
            new CardGraphic(9,  "red_diamonds"),
            new CardGraphic(9,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(5,  "black_spade"),
            new CardGraphic(6,  "black_spade"),
            new CardGraphic(7,  "black_spade"),
            new CardGraphic(8,  "black_spade"),
            new CardGraphic(10, "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 36);

        $cards = [
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 50);

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
        $pokerHand = new Flush();
        
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