<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardDeck.
 */
class CardDeckTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class CardDeck.
     */
    public function testConstruct()
    {
        $deck = new CardDeck();
        $this->assertInstanceOf("\App\CardGame\CardDeck", $deck);
        $this->assertIsObject($deck);
    }

    /**
     * Check that deck contains 52 Cards on reset
     */
    public function testResetDeck()
    {
        $deck = new CardDeck();

        $deck->reset();
        $exp = 52;

        $this->assertEquals(52, $deck->getNumberOfCards());

        foreach ($deck->getCardsInDeck() as $card) {
            $this->assertInstanceOf("\App\CardGame\Card", $card);
        }
    }

    /**
     * Validate that remove() only removes 1 card
     */
    public function testRemoveCard()
    {
        $deck = new CardDeck();

        $deck->remove($deck->getCardsInDeck()[0]);
        $exp = 51;

        $this->assertEquals($exp, $deck->getNumberOfCards());
    }

    /**
     * Validates card is in deck function
     */
    public function testCardInDeck()
    {
        $deck = new CardDeck();

        $array = [
            "char" => "A",
            "suit" => "♠",
            "color" => "black"
        ];

        $this->assertTrue($deck->cardInDeck($array));
    }

    /**
     * Validate that draw() draws a card and removes it from the deck
     */
    public function testDrawCard()
    {
        $deck = new CardDeck();

        $card = $deck->draw();
        $exp = 51;

        $this->assertEquals($exp, $deck->getNumberOfCards());
        $this->assertTrue(!$deck->cardInDeck($card[0]));

        $deck = new CardDeck();

        $card = $deck->drawCard();
        $exp = 51;

        $this->assertEquals($exp, $deck->getNumberOfCards());
        $this->assertInstanceOf("\App\CardGame\Card", $card);
    }

    /**
     * Validate that drawMultiple() draws multiple cards and removes them from the deck
     * Also validates that when the deck has less than desired amount, it returns only the remaining cards
     */
    public function testDrawMultipleCards() {
        $deck = new CardDeck();
        $card = $deck->drawMultiple(52);

        $exp = 52;

        $this->assertEquals($exp, sizeOf($card));
        $this->assertEquals(0, $deck->getNumberOfCards());

        $card = $deck->draw();

        $exp = [];
        $this->assertEquals($exp, $card);

        $card = $deck->drawMultiple(2);

        $exp = [];
        $this->assertEquals($exp, $card);
    }
    
    /**
     * Validates that shuffle actually shuffles cards
     */
    public function testShuffle() {
        $first  = new CardDeck();
        $second = new CardDeck();

        $this->assertEquals($first, $second);

        $second->shuffle();

        $this->assertTrue($first != $second);
    }

    /**
     * Validates that getAll() gets all remaning cards in the deck and returns their values
     */
    public function testGetAll() {
        $deck = new CardDeck();

        $exp = 52;

        $all = $deck->getAll();
        $this->assertEquals($exp, sizeOf($all));

        $exp = 3;

        foreach ($all as $card) {
            $this->assertEquals($exp, sizeOf($card));
        }
    }

    /**
     * Validates that getAllSorted() gets all remaning cards in the deck and returns their values in a sorted manner
     * If two decks get sorted, they should equal eachother
     */
    public function testGetAllSorted() {
        $first  = new CardDeck();
        $second = new CardDeck();

        $first->shuffle();
        $second->shuffle();

        $this->assertTrue($first != $second);

        $firstAll = $first->getAllSorted();
        $secondAll = $second->getAllSorted();

        $this->assertTrue($firstAll == $secondAll);
    }

    /**
     * Validates that showAll() returns a string of all cards in the deck (this is used for debugging only)
     */
    public function testShowAll() {
        $deck  = new CardDeck();

        $this->assertIsString($deck->showAll());
    }

    /**
     * Validates that getCardAt() returns object of type Card and that the card exists in the deck
     */
    public function testGetCardAt() {
        $deck  = new CardDeck();

        $card = $deck->getCardAt(0);

        $exp = 52;

        $this->assertEquals($exp, $deck->getNumberOfCards());
        $this->assertTrue($deck->cardInDeck($card->getValues()));
    }

    /**
     * Validates that getCardAt() returns object of type Card and that the card exists in the deck
     */
    public function testToString() {
        $deck  = new CardDeck();

        $this->assertIsString("" . $deck);
    }
}