<?php

namespace App\Poker;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PlayerBankBank.
 */
class PlayerBankTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class PlayerBank.
    */
    public function testConstruct()
    {
        $playerBank = new PlayerBank();
        $this->assertInstanceOf("\App\Poker\PlayerBank", $playerBank);
        $this->assertEquals($playerBank->tokensLeft, 300);
    }

    /**
     * Verify that place() removes tokens from tokensLeft
    */
    public function testPlace()
    {
        $amt = 50;

        $playerBank = new PlayerBank();
        $tokensLeft = $playerBank->tokensLeft;

        $playerBank->place($amt);
        $this->assertEquals($playerBank->tokensLeft, $tokensLeft - $amt);

        $playerBank->place($amt);
        $this->assertEquals($playerBank->tokensLeft, $tokensLeft - $amt - $amt);
    }

    /**
     * Verify that gain() adds tokens to tokensLeft
    */
    public function testGain()
    {
        $amt = 50;

        $playerBank = new PlayerBank();
        $tokensLeft = $playerBank->tokensLeft;

        $playerBank->gain($amt);
        $this->assertEquals($playerBank->tokensLeft, $tokensLeft + $amt);

        $playerBank->gain($amt);
        $this->assertEquals($playerBank->tokensLeft, $tokensLeft + $amt + $amt);
    }

    /**
     * Checks if toString returns a string
    */
    public function testToString()
    {
        $player = new PlayerBank('player', 'Anton', 1);

        $this->assertIsString("" . $player);
    }
}

