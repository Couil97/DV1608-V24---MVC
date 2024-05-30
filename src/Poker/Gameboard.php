<?php
namespace App\Poker;

use App\CardGame\Card;
use App\CardGame\CardDeck;
use App\Poker\Player;

class Gameboard
{
    private int $cheating   = 0;
    private int $maxPlayers = 4;
    private int $maxRounds  = 3;
    private int $maxDraws   = 3;

    protected array $players = array();
    protected   int $status = 0;
    protected   int $rounds = 0;
    protected   int $draws = 0;

    public CardDeck $deck;
    public int $pot;

    public Player $winner;

    public function start(bool $cheating = false): void {
        $this->deck = new CardDeck();
        $this->deck->shuffle();

        $this->pot = 0;
        $this->status = 1;
        if($cheating) $this->cheating = 1;

        $this->winner = new Player();
    }

    public function addPlayer(string $type, string $name): void
    {
        if(count($this->players) < $this->maxPlayers) array_push($this->players, new Player($type, $name, count($this->players)));
    }

    public function drawAll(bool $debug = false): void {
        if($this->draws >= $this->maxDraws) $this->reset();

        foreach ($this->players as $playerId => $player) {
            $amt = 5 - $player->hand->getCount();
            $this->draw($playerId, $amt);
            $this->calculateHand($playerId);
            if($debug) $this->debugSetRankAndValue($playerId, [$playerId + 1, 12 - $playerId]);
        }

        if(++$this->draws == $this->maxDraws) {
            $this->status = 2;
            $this->endRound();
        }
    }

    private function draw(int $playerId, int $amt): void {
        for ($i=0; $i < $amt; $i++) { 
            $this->players[$playerId]->hand->addCard($this->deck->drawCard());
        }
    }

    public function remove(int $playerId, array $cards): void {
        $this->players[$playerId]->hand->removeCard($cards);
    }

    public function placeBet(int $playerId, int $amt): void {
        if($amt > $this->players[$playerId]->getData()['chips']) {
            $amt = $this->players[$playerId]->getData()['chips'];
        }

        $this->players[$playerId]->placeBet($amt);
        $this->pot += $amt;
    }

    public function getData(): array {
        $playersData = [];

        foreach ($this->players as $key => $player) {
            array_push($playersData, $player->getData());
        }

        return [
            'pot' => $this->pot,
            'status' => $this->status,
            'cheating' => $this->cheating,
            'players' => $playersData,
            'drawCount' => $this->draws,
            'roundCount' => $this->rounds,
            'playerCount' => count($this->players),
            'winner' => $this->winner->getData(),
        ];
    }

    private function endRound(): void {
        $this->winner = new Player();

        foreach ($this->players as $key => $player) {
            $playerData = $player->getData();
            $winnerData = $this->winner->getData();

            if($playerData['rank'] < $winnerData['rank']) {
                $this->winner = $player;
            }

            if($playerData['rank'] == $winnerData['rank']) {
                if($playerData['value'] > $winnerData['value']) $this->winner = $player;
            }
        }

        $this->winner->playerBank->gain($this->pot);
        
        if(++$this->rounds == $this->maxRounds) {
            $this->finish();
        }
    }

    private function reset(): void {
        $this->pot = 0;
        $this->draws = 0;
        $this->status = 1;

        foreach ($this->players as $key => $player) {
            $player->reset();
        }

        $this->deck = new CardDeck();
        $this->deck->shuffle();
    }

    private function finish() : void {
        $this->winner = new Player();

        foreach ($this->players as $key => $player) {
            if($player->playerBank->tokensLeft >= $this->winner->playerBank->tokensLeft) {
                $this->winner = $player;
            }
        }

        $this->status = 3;
    }

    private function calculateHand(int $id): void {
        $this->players[$id]->setCurrentPokerHand();
    }

    private function debugSetRankAndValue(int $playerId, array $values): void {
        if(count($values) == 0) return;

        $this->players[$playerId]->currentPokerHand->debugSetRank($values[0]);
        $this->players[$playerId]->currentPokerHand->debugSetValue($values[1]);
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
