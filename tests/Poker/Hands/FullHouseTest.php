<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class FullHouse.
 */
class FullHouseTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class FullHouse.
    */
    public function testConstruct()
    {
        $pokerHand = new FullHouse();
        $this->assertInstanceOf("\App\Poker\Hands\FullHouse", $pokerHand);
    }

    /**
     * Validates that FullHouse stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new FullHouse();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 4);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new FullHouse();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(2,  "black_spade"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(10, "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 26);

        $cards = [
            new CardGraphic(1,  "red_diamonds"),
            new CardGraphic(2,  "black_spade"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(10, "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(12,  "red_diamonds"),
            new CardGraphic(12,  "black_spade"),
            new CardGraphic(13,  "red_hearts"),
            new CardGraphic(13, "red_diamonds"),
            new CardGraphic(13, "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 63);

        $cards = [
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(10,  "red_hearts")
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
        $pokerHand = new FullHouse();
        
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