<?php
namespace App\Poker;

use App\CardGame\Card;
use App\CardGame\CardHand;

use App\Poker\Hands\DefaultHand;
use App\Poker\PokerHands;
use App\Poker\PokerHand;
use App\Poker\PlayerBank;

class Player
{

    public PokerHand $currentPokerHand;
    public PlayerBank $playerBank;
    public int $currentBet;

    public PlayerHand $hand;

    public string $playerType;
    public string $name;
    public int $id;

    public function __construct(string $type = 'npc', string $name = 'default', int $id = -1)
    {
        $this->playerType = $type;
        $this->name = $name;
        $this->id = $id;
        $this->playerBank = new PlayerBank();
        $this->hand = new PlayerHand();
        $this->currentPokerHand = new DefaultHand();

        $this->currentBet = 0;
    }

    public function reset() {
        $this->currentBet = 0;
        $this->currentPokerHand = new DefaultHand();
        $this->hand->reset();
    }

    public function placeBet($amt) {
        $this->playerBank->place($amt);
        $this->currentBet += $amt;
    }

    public function isEqual(Player $player): bool {
        return $this->id == $player->id;
    }
    
    public function setCurrentPokerHand(): void {
        $this->currentPokerHand = PokerHands::getHighestPokerHand($this->hand->getHand());
    }

    private function getRank(): int {
        return $this->currentPokerHand->getRank();
    }

    private function getValue(): int {
        return $this->currentPokerHand->getValue();
    }

    public function getData(): array {
        return [
            'name' => $this->name,
            'type' => $this->playerType,
            'chips' => $this->playerBank->tokensLeft,
            'bet' => $this->currentBet,
            'hand' => $this->hand->getHand(),
            'handSize' => count($this->hand->getHand()),
            'rank' => $this->getRank(),
            'value' => $this->getValue(),
            'pokerHand' => $this->currentPokerHand->getName()
        ];
    }

    public function __toString(): string
    {
        return $this->name . ":" . $this->playerType;
    }
}
