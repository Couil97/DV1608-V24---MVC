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
        $this->assertEquals($gameboard->getData()['status'], 1);
    }

    /**
     * Verify that the gameboard can add a player
    */
    public function testAddPlayer()
    {
        $gameboard = new Gameboard();
        $gameboard->start();

        $gameboard->addPlayer('player', 'Anton');

        $players = $gameboard->getData()['players'];

        $this->assertEquals(count($players), 1);
        $this->assertEquals($players[0]['name'], 'Anton');

        $gameboard->addPlayer('npc', 'CPU 1');

        $players = $gameboard->getData()['players'];

        $this->assertEquals(count($players), 2);
        $this->assertEquals($players[1]['name'], 'CPU 1');
    }

    /**
     * Verify that the gameboard can draw cards for the player
    */
    public function testDraw()
    {
        $gameboard = new Gameboard();
        $gameboard->start();
        $gameboard->addPlayer('player', 'Anton');

        $gameboard->drawAll();
        $numberOfCards = count($gameboard->getData()['players'][0]['hand']);
        $this->assertEquals($numberOfCards, 5);

        $gameboard->drawAll();
        $numberOfCards = count($gameboard->getData()['players'][0]['hand']);
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

        $gameboard->drawAll();
        $numberOfCards = count($gameboard->getData()['players'][0]['hand']);
        $this->assertEquals($numberOfCards, 5);

        $gameboard->remove(0, [0,1,2]);
        $numberOfCards = count($gameboard->getData()['players'][0]['hand']);
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

        for ($i=0; $i < 3; $i++) { 
            $gameboard->drawAll(true);
        }

        $players = $gameboard->getData()['players'];

        $this->assertEquals($players[0]['chips'], 350);
        $this->assertEquals($players[1]['chips'], 250);
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