<?php

namespace App\Poker\Hands;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HighCard.
 */
class HighCardTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class HighCard.
    */
    public function testConstruct()
    {
        $pokerHand = new HighCard();
        $this->assertInstanceOf("\App\Poker\Hands\HighCard", $pokerHand);
    }

    /**
     * Validates that HighCard stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new HighCard();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 10);
    }

    /**
     * Validates that Card can store and return value and suit
    */
    public function testEqualsAndValue()
    {
        $pokerHand = new HighCard();
        
        $cards = [
            new CardGraphic(5,  "red_diamonds"),
            new CardGraphic(2,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(10, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 11);

        $cards = [
        ];

        $this->assertFalse($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 0);

        $cards = [
            new CardGraphic(12,  "red_diamonds"),
            new CardGraphic(11,  "red_hearts"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(11, "red_diamonds"),
            new CardGraphic(7,  "black_spade")
        ];
        
        $this->assertTrue($pokerHand->handEquals($cards));
        $this->assertEquals($pokerHand->getValue(), 12);
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $pokerHand = new HighCard();
        
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
