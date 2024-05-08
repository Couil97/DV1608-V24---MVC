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
     * Validates that the toString method returns a string
     */
    public function testToString() 
    {
        $card = new Card(12, "black_spade");

        $this->assertIsString("" . $card);
    }
}