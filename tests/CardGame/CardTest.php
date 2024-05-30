<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class Card.
     */
    public function testConstruct()
    {
        $card = new Card(12, "black_spade");
        $this->assertInstanceOf("\App\CardGame\Card", $card);
    }

    /**
     * Validates that Card can store and return value and suit
     */
    public function testValues()
    {
        $card = new Card(12, "black_spade");

        $this->assertIsInt($card->getValue());
        $this->assertIsString($card->getSuit());
    }

    /**
     * Validates that Card->isEqual() works as intended
     */
    public function testIsEqual()
    {
        $card1 = new Card(12, "black_spade");
        $card2 = new Card(11, "black_spade");

        $this->assertTrue($card1->isEqual($card1));
        $this->assertFalse($card1->isEqual($card2));
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $card = new Card(12, "black_spade");

        $this->assertIsString("" . $card);
    }
}
