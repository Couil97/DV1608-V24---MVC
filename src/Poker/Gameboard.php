<?php
namespace App\Poker;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\Poker\Player;

class Gameboard
{
    private int $maxRounds = 3;

    protected array $players = array();
    protected int $status = 0;
    protected int $rounds = 0;

    public CardDeck $deck;
    public int $pot;

    public Player $gameWinner;

    public function start(): void {
        $this->deck = new CardDeck();
        $this->deck->shuffle();

        $this->pot = 0;
        $this->status = 1;
    }

    public function addPlayer(string $type, string $name): void
    {
        array_push($this->players, new Player($type, $name, count($this->players)));
    }

    public function draw(int $playerId, int $amt): void {
        for ($i=0; $i < $amt; $i++) { 
            $this->players[$playerId]->hand->addCard($this->deck->drawCard());
        }
    }

    public function remove(int $playerId, array $cards): void {
        $this->players[$playerId]->hand->removeCard($cards);
    }

    public function endRound(): void {
        $winner = new Player();

        foreach ($this->players as $key => $player) {
            if($player->getRank() < $winner->getRank()) {
                $winner = $player;
            }

            if($player->getRank() == $winner->getRank()) {
                if($player->getValue() > $winner->getValue()) $winner = $player;
            }
        }

        $winner->playerBank->gain($this->pot);
        $this->pot = 0;

        foreach ($this->players as $key => $player) {
            $player->reset();
        }

        if(++$this->rounds == $this->maxRounds) {
            $this->finish();
        }
    }

    public function finish() : void {
        $winner = new Player();

        foreach ($this->players as $key => $player) {
            if($player->playerBank->tokensLeft > $winner->playerBank->tokensLeft) {
                $winner = $player;
            }
        }

        $this->gameWinner = $winner;
        $this->status = 2;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getPlayers() {
        return $this->players;
    }

    public function placeBet(int $playerId, int $amt): void {
        $this->players[$playerId]->placeBet($amt);
        $this->pot += $amt;
    }

    public function calculateAllHands(): void {
        foreach ($this->players as $key => $player) {
            $player->setCurrentPokerHand();
        }
    }

    public function debugSetRankAndValue(int $playerId, int $rank, int $value): void {
        $this->players[$playerId]->currentPokerHand->debugSetRank($rank);
        $this->players[$playerId]->currentPokerHand->debugSetValue($value);
    }

    public function __toString(): string
    {
        return implode([
            'status' => $this->status,
            '#players' => count($this->players),
            '#cards' => $this->deck->getNumberOfCards()
        ]);
    }
}
