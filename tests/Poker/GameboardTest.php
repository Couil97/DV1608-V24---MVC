<?php

namespace App\Poker;
use App\CardGame\CardDeck;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Gameboard.
 */
class GameboardTest extends TestCase
{
    /**
     * Construct object and verify that the object is of class Gameboard.
    */
    public function testConstruct()
    {
        $gameboard = new Gameboard();
        $this->assertInstanceOf("\App\Poker\Gameboard", $gameboard);
    }

    /**
     * Verify that the gameboard can start and that all the variables are correct
    */
    public function testStart()
    {
        $gameboard = new Gameboard();

        $gameboard->start();

        $this->assertInstanceOf("\App\CardGame\CardDeck", $gameboard->deck);
        $this->assertEquals($gameboard->pot, 0);
        $this->assertEquals($gameboard->getStatus(), 1);
    }

    /**
     * Verify that the gameboard can add a player
    */
    public function testAddPlayer()
    {
        $gameboard = new Gameboard();
        $gameboard->start();

        $gameboard->addPlayer('player', 'Anton');

        $players = $gameboard->getPlayers();

        $this->assertEquals(count($players), 1);
        $this->assertEquals($players[0]->name, 'Anton');

        $gameboard->addPlayer('npc', 'CPU 1');

        $players = $gameboard->getPlayers();

        $this->assertEquals(count($players), 2);
        $this->assertEquals($players[1]->name, 'CPU 1');
    }

    /**
     * Verify that the gameboard can draw cards for the player
    */
    public function testDraw()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');

        $gameboard->draw(0, 5);
        $numberOfCards = $gameboard->getPlayers()[0]->hand->getCount();
        $this->assertEquals($numberOfCards, 5);

        $gameboard->draw(0, 5);
        $numberOfCards = $gameboard->getPlayers()[0]->hand->getCount();
        $this->assertEquals($numberOfCards, 5);
    }

    /**
     * Verify that the gameboard can remove cards for the player
    */
    public function testRemove()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');

        $gameboard->draw(0, 5);
        $numberOfCards = $gameboard->getPlayers()[0]->hand->getCount();
        $this->assertEquals($numberOfCards, 5);

        $gameboard->remove(0, [0,1,2]);
        $numberOfCards = $gameboard->getPlayers()[0]->hand->getCount();
        $this->assertEquals($numberOfCards, 2);
    }

    /**
     * Verify that ending a round works as it should
    */
    public function testEndRound()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');
        $gameboard->addPlayer('player', 'Johan');

        $gameboard->placeBet(0, 50);
        $gameboard->placeBet(1, 50);

        $gameboard->draw(0, 5);
        $gameboard->draw(1, 5);

        $gameboard->calculateAllHands();

        $gameboard->debugSetRankAndValue(0, 9, 12);
        $gameboard->debugSetRankAndValue(1, 10, 8);
        $gameboard->endRound();

        $players = $gameboard->getPlayers();

        $this->assertEquals($players[0]->playerBank->tokensLeft, 350);
        $this->assertEquals($players[1]->playerBank->tokensLeft, 250);

        $this->assertEquals($players[0]->currentBet, 0);
        $this->assertEquals($players[1]->currentBet, 0);

        $this->assertEquals($players[0]->getRank(), 99);
        $this->assertEquals($players[0]->getValue(), -1);

        $this->assertEquals($players[1]->getRank(), 99);
        $this->assertEquals($players[1]->getValue(), -1);
        
        $this->assertEquals($players[0]->hand->getCount(), 0);
        $this->assertEquals($players[1]->hand->getCount(), 0);
    }

    /**
     * Verify that finish works as it should
    */
    public function testFinish()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');
        $gameboard->addPlayer('player', 'Johan');

        for ($i=0; $i < 3; $i++) {
            $gameboard->placeBet(0, 50);
            $gameboard->placeBet(1, 50);
    
            $gameboard->draw(0, 5);
            $gameboard->draw(1, 5);
    
            $gameboard->calculateAllHands();
    
            $gameboard->debugSetRankAndValue(0, 9, 12);
            $gameboard->debugSetRankAndValue(1, 10, 8);
            $gameboard->endRound();
        }

        $this->assertIsObject($gameboard->gameWinner);
        $this->assertEquals($gameboard->gameWinner->id, 0);
        $this->assertEquals($gameboard->gameWinner->playerBank->tokensLeft, 450);
        $this->assertEquals($gameboard->getStatus(), 2);
    }

    /**
     * Validates that the toString method returns a string
    */
    public function testToString()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');
        $gameboard->addPlayer('player', 'Johan');

        $this->assertIsString("" . $gameboard);
    }
}