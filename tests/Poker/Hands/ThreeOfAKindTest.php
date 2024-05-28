<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ThreeOfAKind.
 */
class ThreeOfAKindTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class ThreeOfAKind.
    */
    public function testConstruct()
    {
        $pokerHand = new ThreeOfAKind();
        $this->assertInstanceOf("\App\Poker\Hands\ThreeOfAKind", $pokerHand);
    }

    /**
     * Validates that ThreeOfAKind stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new ThreeOfAKind();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 7);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new ThreeOfAKind();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(8,  "red_hearts"),
            new CardGraphic(8,  "red_diamonds"),
            new CardGraphic(8,  "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 24);

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
            new CardGraphic(6,  "red_hearts"),
            new CardGraphic(7, "red_diamonds"),
            new CardGraphic(8, "red_diamonds"),
            new CardGraphic(9,  "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(14,  "red_diamonds"),
            new CardGraphic(14,  "red_hearts"),
            new CardGraphic(14, "red_diamonds"),
            new CardGraphic(2, "red_diamonds"),
            new CardGraphic(2,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 42);

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
        $pokerHand = new ThreeOfAKind();
        
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