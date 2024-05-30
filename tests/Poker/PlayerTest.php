<?php

namespace App\Poker;

use App\CardGame\CardDeck;
use App\CardGame\CardGraphic;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class Player.
    */
    public function testConstruct()
    {
        $player = new Player('player', 'Anton', 1);
        $this->assertInstanceOf("\App\Poker\Player", $player);

        $this->assertEquals($player->name, 'Anton');
        $this->assertEquals($player->id, 1);
        $this->assertEquals($player->playerType, 'player');
        $this->assertEquals($player->currentBet, 0);

        $this->assertInstanceOf("\App\Poker\PlayerBank", $player->playerBank);
    }

    /**
     * Verify that Player can place bets and that currentBet + tokensLeft updates
    */
    public function testPlaceBet()
    {
        $player = new Player('player', 'Anton', 1);
        $tokensLeft = $player->playerBank->tokensLeft;

        $player->placeBet(50);

        $this->assertEquals($player->playerBank->tokensLeft, $tokensLeft - 50);
        $this->assertEquals($player->currentBet, 50);

        $tokensLeft = $player->playerBank->tokensLeft;

        $player->placeBet(50);

        $this->assertEquals($player->playerBank->tokensLeft, $tokensLeft - 50);
        $this->assertEquals($player->currentBet, 100);

        $tokensLeft = $player->playerBank->tokensLeft;

        $player->placeBet(50);

        $this->assertEquals($player->playerBank->tokensLeft, $tokensLeft - 50);
        $this->assertEquals($player->currentBet, 150);
    }

    /**
     * Verify that setCurrentPokerHand sets the correct pokerHand
    */
    public function testSetCurrentPokerHand()
    {
        $player = new Player('player', 'Anton', 1);
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\FourOfAKind", $player->currentPokerHand);
        
        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\FullHouse", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(1,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\Flush", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_diamonds"));
        $player->hand->addCard(new CardGraphic(1,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\TwoPairs", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(2,  "red_diamonds"));
        $player->hand->addCard(new CardGraphic(1,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\OnePair", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(2,  "red_diamonds"));
        $player->hand->addCard(new CardGraphic(1,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(3,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\HighCard", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_diamonds"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(3,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\ThreeOfAKind", $player->currentPokerHand);

        $player->reset();

        $player->hand->addCard(new CardGraphic(1,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(2,  "red_diamonds"));
        $player->hand->addCard(new CardGraphic(3,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(4,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertInstanceOf("\App\Poker\Hands\Straight", $player->currentPokerHand);
    }

    /**
     * Verify that Player can reset itself
    */
    public function testReset()
    {
        $player = new Player('player', 'Anton', 1);
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));

        $player->setCurrentPokerHand();
        $player->placeBet(50);

        $this->assertEquals($player->hand->getCount(), 5);
        $this->assertEquals($player->currentBet, 50);
        $this->assertInstanceOf("\App\Poker\Hands\FiveOfAKind", $player->currentPokerHand);

        $player->reset();

        $this->assertEquals($player->currentBet, 0);
        $this->assertEquals($player->hand->getCount(), 0);
        $this->assertInstanceOf("\App\Poker\Hands\DefaultHand", $player->currentPokerHand);
    }

    /**
     * Verify that getRank() returns the correct rank
    */
    public function testGetRank()
    {
        $player = new Player('player', 'Anton', 1);
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertEquals($player->getData()['rank'], 3);
    }

    /**
     * Verify that getValue() returns the correct value
    */
    public function testGetValue()
    {
        $player = new Player('player', 'Anton', 1);
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(10,  "red_hearts"));
        $player->hand->addCard(new CardGraphic(5,  "red_hearts"));

        $player->setCurrentPokerHand();

        $this->assertEquals($player->getData()['value'], 40);
    }

    /**
     * Verify that isEqual only returns equal on the correct object
    */
    public function testIsEqual()
    {
        $player1 = new Player('player', 'Anton', 0);
        $player2 = new Player('player', 'Karl', 1);

        $this->assertTrue($player1->isEqual($player1));
        $this->assertFalse($player1->isEqual($player2));
    }

    /**
     * Checks if toString returns a string
    */
    public function testToString()
    {
        $player = new Player('player', 'Anton', 1);

        $this->assertIsString("" . $player);
    }
}

