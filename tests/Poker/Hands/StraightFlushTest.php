<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Straight.
 */
class StraightFlushTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class StraightFlush.
    */
    public function testConstruct()
    {
        $pokerHand = new StraightFlush();
        $this->assertInstanceOf("\App\Poker\Hands\StraightFlush", $pokerHand);
    }

    /**
     * Validates that StraightFlush stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new StraightFlush();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 2);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new StraightFlush();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(3,  "red_diamonds"),
            new CardGraphic(4,  "red_diamonds"),
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(6,  "red_diamonds")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 20);

        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(4,  "red_diamonds"),
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(6,  "red_diamonds")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(9,  "black_spade"),
            new CardGraphic(5,  "black_spade"),
            new CardGraphic(7,  "black_spade"),
            new CardGraphic(6,  "black_spade"),
            new CardGraphic(8,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 35);

        $cards = [
            new CardGraphic(1,  "red_hearts"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(4,  "red_hearts"),
            new CardGraphic(5,  "red_hearts")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 15);

        $cards = [
            new CardGraphic(1,  "red_hearts"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(4,  "red_hearts"),
            new CardGraphic(6,  "red_hearts")
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
        $pokerHand = new StraightFlush();
        
        $cards = [
            new CardGraphic(1,  "red_hearts"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(4,  "red_hearts"),
            new CardGraphic(6,  "red_hearts")
        ];

        $pokerHand->handEquals($cards);

        $this->assertIsString("" . $pokerHand);
    }
}