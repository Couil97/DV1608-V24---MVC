<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class FiveOfAKind.
 */
class FiveOfAKindTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class FiveOfAKind.
    */
    public function testConstruct()
    {
        $pokerHand = new FiveOfAKind();
        $this->assertInstanceOf("\App\Poker\Hands\FiveOfAKind", $pokerHand);
    }

    /**
     * Validates that FiveOfAKind stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new FiveOfAKind();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 1);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new FiveOfAKind();
        
        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(2,  "black_spade"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(2, "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 10);

        $cards = [
            new CardGraphic(2,  "red_diamonds"),
            new CardGraphic(2,  "black_spade"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(2, "red_diamonds"),
            new CardGraphic(10, "black_spade")
        ];
        
        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(13,  "red_diamonds"),
            new CardGraphic(13,  "black_spade"),
            new CardGraphic(13,  "red_hearts"),
            new CardGraphic(13, "red_diamonds"),
            new CardGraphic(13, "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 65);

        $cards = [
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(9,  "red_hearts"),
            new CardGraphic(10,  "red_hearts"),
            new CardGraphic(9,  "red_hearts"),
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
        $pokerHand = new FiveOfAKind();
        
        $cards = [
            new CardGraphic(13,  "red_diamonds"),
            new CardGraphic(13,  "black_spade"),
            new CardGraphic(13,  "red_hearts"),
            new CardGraphic(13, "red_diamonds"),
            new CardGraphic(13, "black_spade")
        ];

        $pokerHand->handEquals($cards);

        $this->assertIsString("" . $pokerHand);
    }
}