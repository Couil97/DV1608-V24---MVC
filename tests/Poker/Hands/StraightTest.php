<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Straight.
 */
class StraightTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class Straight.
    */
    public function testConstruct()
    {
        $pokerHand = new Straight();
        $this->assertInstanceOf("\App\Poker\Hands\Straight", $pokerHand);
    }

    /**
     * Validates that Straight stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new Straight();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 6);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new Straight();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(3,  "red_hearts"),
            new CardGraphic(4,  "red_diamonds"),
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(6,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 20);

        $cards = [
            new CardGraphic(13,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(4, "red_diamonds"),
            new CardGraphic(7, "red_diamonds"),
            new CardGraphic(8,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(6,  "red_hearts"),
            new CardGraphic(7, "red_diamonds"),
            new CardGraphic(8, "red_diamonds"),
            new CardGraphic(10,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(9,  "red_diamonds"),
            new CardGraphic(5,  "red_hearts"),
            new CardGraphic(7, "red_diamonds"),
            new CardGraphic(6, "red_diamonds"),
            new CardGraphic(8,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 35);

        $cards = [
            new CardGraphic(1,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(3, "red_diamonds"),
            new CardGraphic(4, "red_diamonds"),
            new CardGraphic(5,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 15);

        $cards = [
            new CardGraphic(1,  "red_diamonds"),
            new CardGraphic(13,  "red_hearts"),
            new CardGraphic(12, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(10,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 60);

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
        $pokerHand = new Straight();
        
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