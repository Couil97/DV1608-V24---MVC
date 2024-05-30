<?php
namespace App\Poker;

abstract class PokerHand
{
    protected int $rank;
    protected int $value = 0;
    protected string $name;

    public function __construct(int $rank, string $name)
    {
        $this->rank = $rank;
        $this->name = $name;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getName(): string {
        return $this->name;
    }

    public function debugSetRank(int $rank) {
        $this->rank = $rank;
    }

    public function debugSetValue(int $value) {
        $this->value = $value;
    }

    private function setValue(array $cards): void
    {
        $sum = 0;
        foreach ($cards as $key => $card) {
            $sum += $card->getValue();
        }

        $this->value = $sum;
    }

    function handEquals(array $originalCards): bool {
        // Eftersom att det är 5-kort poker måste det alltid finnas 5 kort.
        if(count($originalCards) < 5) {
            $this->setValue([]);
            return false;
        }
        $cards = array_merge(array(), $originalCards);
        
        foreach ($cards as $key => $card) {
            if($card->getValue() == 1) $card->changeValue(14);
        }

        $equals = false;
        
        // Sorting highest to lowest
        usort($cards, fn($a, $b) => $b->getValue() - $a->getValue());

        $countedCards = $this->countCards($cards);
        $this->setValue($countedCards);

        return count($countedCards) > 0;
    }

    abstract function countCards(array $cards): array;

    public function __toString(): string
    {
        return "Rank: " . strval($this->rank) . "\nValue: " . strval($this->value);
    }
}
