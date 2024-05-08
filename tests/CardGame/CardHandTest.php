<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class CardHand.
     */
    public function testConstruct()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\CardGame\CardHand", $hand);
        $this->assertIsObject($hand);
    }

    /**
     * Validates that a card can be added to the hand and that the card is correct
     */
    public function testCardAdd()
    {
        $hand = new CardHand();
        $card = new CardGraphic(1, "red_diamonds");

        $hand->add($card);

        $this->assertEquals(1, $hand->getNumberOfCards());
        $this->assertEquals($hand->getCardsInHand()[0]->getColor(), "red");
        $this->assertEquals($hand->getCardsInHand()[0]->getGraphicSuit(), "♦");
        $this->assertEquals($hand->getCardsInHand()[0]->getValue(), 1);
    }

    /**
     * Validates that the program can accuratly calculate the sum of the cards (in different situations)
     */
    public function testSumOfCards()
    {
        $hand = new CardHand();
        $hand->add(new CardGraphic(2, "red_diamonds"));
        $hand->add(new CardGraphic(4, "red_diamonds"));
        $hand->add(new CardGraphic(6, "red_diamonds"));
        $hand->add(new CardGraphic(10, "red_diamonds"));

        $exp = 22;

        $this->assertEquals($hand->getSum(), $exp);

        $hand = new CardHand();
        $hand->add(new CardGraphic(1, "red_diamonds")); // Ace -> 14
        $hand->add(new CardGraphic(4, "red_diamonds"));
        $hand->add(new CardGraphic(3, "red_diamonds"));

        $exp = 21;

        $this->assertEquals($hand->getSum(), $exp);

        $hand = new CardHand();
        $hand->add(new CardGraphic(1, "red_diamonds")); // Ace -> 1 (since it's over 21 otherwise)
        $hand->add(new CardGraphic(4, "red_diamonds"));
        $hand->add(new CardGraphic(4, "red_diamonds"));

        $exp = 9;

        $this->assertEquals($hand->getSum(), $exp);

        $hand = new CardHand();
        $hand->add(new CardGraphic(13, "red_diamonds"));
        $hand->add(new CardGraphic(12, "red_diamonds"));
        $hand->add(new CardGraphic(1, "red_diamonds")); // Ace -> 1 (since it's over 21 otherwise)

        $exp = 26;

        $this->assertEquals($hand->getSum(), $exp);
    }

    /**
     * Validates that class can return all values of cards in hand
     */
    public function testGetAllValues()
    {
        $hand = new CardHand();
        $hand->add(new CardGraphic(2, "red_diamonds"));
        $hand->add(new CardGraphic(3, "black_clubs"));
        $hand->add(new CardGraphic(4, "red_hearts"));
        $hand->add(new CardGraphic(5, "black_spade"));

        $all = $hand->getAll();

        $this->assertIsArray($all);
        $this->assertEquals(sizeOf($all), 4);

        $this->assertEquals("red", $all[0]["color"]);
        $this->assertEquals("black", $all[1]["color"]);
        $this->assertEquals("red", $all[2]["color"]);
        $this->assertEquals("black", $all[3]["color"]);
    }

    /**
     * Validates that getCardAt returns the correct card
     */
    public function testGetCardAt()
    {
        $hand = new CardHand();
        $hand->add(new CardGraphic(1, "black_clubs"));
        $hand->add(new CardGraphic(2, "black_clubs"));
        $hand->add(new CardGraphic(10, "black_clubs"));
        $hand->add(new CardGraphic(11, "black_clubs"));

        $this->assertEquals($hand->getCardAt(2), $hand->getCardsInHand()[2]);
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $hand = new CardHand();
        $this->assertIsString("" . $hand);

        $hand->add(new CardGraphic(13, "black_spade"));
        $this->assertIsString("" . $hand);
    }
}
