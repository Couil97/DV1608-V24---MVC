<?php

namespace App\Poker;

use App\CardGame\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PlayerHand.
 */
class PlayerHandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class PlayerHand.
    */
    public function testConstruct()
    {
        $playerHand = new PlayerHand();
        $this->assertInstanceOf("\App\Poker\PlayerHand", $playerHand);
    }

    /**
     * Validates that PlayerHand can add and remove cards
     */
    public function testRemoveAndAddCard()
    {
        $playerHand = new PlayerHand();

        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        
        $this->assertEquals($playerHand->getCount(), 1);
        $this->assertInstanceOf("\App\CardGame\Card", $playerHand->getCard(0));

        $playerHand->removeCard([0]);

        $this->assertEquals($playerHand->getCount(), 0);
        $this->assertEquals($playerHand->getHand(), []);

        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));

        $this->assertEquals($playerHand->getCount(), 5); // Not 6

        $playerHand->removeCard([0]);
        $playerHand->removeCard([0]);
        $playerHand->removeCard([0]);
        $playerHand->removeCard([0]);
        $playerHand->removeCard([0]);
        $playerHand->removeCard([0]);

        $this->assertEquals($playerHand->getCount(), 0);
        $this->assertEquals($playerHand->getHand(), []);
    }

    /**
     * Validates that PlayerHand returns the correct card with the getCard() method
     */
    public function testGetCard()
    {
        $playerHand = new PlayerHand();
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        
        $this->assertInstanceOf("\App\CardGame\Card", $playerHand->getCard(0));
        $this->assertEquals($playerHand->getCard(0)->getSuit(), "red_hearts");
        $this->assertEquals($playerHand->getCard(0)->getValue(), 10);

        $playerHand->addCard(new CardGraphic(2,  "black_spade"));
        
        $this->assertInstanceOf("\App\CardGame\Card", $playerHand->getCard(1));
        $this->assertEquals($playerHand->getCard(1)->getSuit(), "black_spade");
        $this->assertEquals($playerHand->getCard(1)->getValue(), 2);
    }

    /**
     * Validates that PlayerHand returns the full and correct hand with getHand() method
     */
    public function testGetHand()
    {
        $playerHand = new PlayerHand();
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));
        
        $hand = $playerHand->getHand();

        $this->assertIsArray($hand);
        $this->assertEquals($hand[0]->getSuit(), "red_hearts");
        $this->assertEquals($hand[0]->getValue(), 10);

        $playerHand->addCard(new CardGraphic(2,  "black_spade"));

        $hand = $playerHand->getHand();

        $this->assertIsArray($hand);
        $this->assertEquals($hand[1]->getSuit(), "black_spade");
        $this->assertEquals($hand[1]->getValue(), 2);
    }

    /*
    * Validates that PlayerHand->reset() resets hand
    */
    public function testReset()
    {
        $playerHand = new PlayerHand();
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));

        $playerHand->reset();
        
        $hand = $playerHand->getHand();

        $this->assertIsArray($hand);
        $this->assertEquals($hand, []);
    }

    /*
    * Validates that toString() returns a string
    */
    public function testToString()
    {
        $playerHand = new PlayerHand();
        $playerHand->addCard(new CardGraphic(10,  "red_hearts"));

        $this->assertIsString("" . $playerHand);
    }
}