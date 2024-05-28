<?php
namespace App\Poker\Hands;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DefaultHand.
 */
class DefaultHandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class DefaultHand.
    */
    public function testConstruct()
    {
        $pokerHand = new DefaultHand();
        $this->assertInstanceOf("\App\Poker\Hands\DefaultHand", $pokerHand);
    }

    /**
     * Validates that DefaultHand stores the correct rank after initialization
     */
    public function testRank()
    {
        $pokerHand = new DefaultHand();

        $this->assertIsInt($pokerHand->getRank());
        $this->assertEquals($pokerHand->getRank(), 99);
    }

    /**
     * Validates that DefaultHand stores the correct value after initialization
    */
    public function testValue()
    {
        $pokerHand = new DefaultHand();

        $this->assertIsInt($pokerHand->getValue());
        $this->assertEquals($pokerHand->getValue(), -1);
    }

    /**
     * Validates that DefaultHand returns empty on countCards()
    */
    public function testCountCards()
    {
        $pokerHand = new DefaultHand();

        $this->assertEquals($pokerHand->countCards(array()), []);
    }

    /**
     * Validates that the toString method returns a string
     */
    public function testToString()
    {
        $pokerHand = new DefaultHand();
        $this->assertIsString("" . $pokerHand);
    }
}