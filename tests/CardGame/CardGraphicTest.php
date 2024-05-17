<?php

namespace App\CardGame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class CardGraphic.
     */
    public function testConstruct()
    {
        $card = new CardGraphic(12, "black_spade");
        $this->assertInstanceOf("\App\CardGame\CardGraphic", $card);
    }

    /**
     * Validates that all suits can be set
     */
    public function testSuits()
    {
        $card = new CardGraphic(2, "black_spade");

        $this->assertEquals($card->getColor(), "black");
        $this->assertEquals($card->getGraphicSuit(), "♠");

        $card = new CardGraphic(4, "red_hearts");

        $this->assertEquals($card->getColor(), "red");
        $this->assertEquals($card->getGraphicSuit(), "♥");

        $card = new CardGraphic(6, "black_clubs");

        $this->assertEquals($card->getColor(), "black");
        $this->assertEquals($card->getGraphicSuit(), "♣");

        $card = new CardGraphic(8, "red_diamonds");

        $this->assertEquals($card->getColor(), "red");
        $this->assertEquals($card->getGraphicSuit(), "♦");
    }

    /**
     * Validate that all cards can be created and that they have the right char associated to them
     */
    public function testNumbers()
    {
        for($i = 1; $i < 14; $i++) {
            $card = new CardGraphic($i, "black_spade");

            if($i == 1) {
                $this->assertEquals($card->getChar(), "A");
                continue;
            }

            if($i < 11) {
                $this->assertEquals($card->getChar(), strval($i));
                continue;
            }

            if($i == 11) {
                $this->assertEquals($card->getChar(), "J");
                continue;
            }

            if($i == 12) {
                $this->assertEquals($card->getChar(), "♕");
                continue;
            }

            $this->assertEquals($card->getChar(), "♔");
        }
    }

    /**
     * Validate that getValues returns an array with 3 keys and that those keys are correct
     */
    public function testValues()
    {
        $card = new CardGraphic(1, "red_diamonds");

        $values = $card->getValues();

        $this->assertIsArray($values);

        $this->assertEquals($values['char'], "A");
        $this->assertEquals($values['suit'], "♦");
        $this->assertEquals($values['color'], "red");
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $card = new CardGraphic(12, "clubs");

        $this->assertIsString("" . $card);
    }
}
