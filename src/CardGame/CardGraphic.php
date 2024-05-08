<?php

namespace App\CardGame;

class CardGraphic extends Card
{
    /**
     * The cards possible graphical suits
     * 1. Spade
     * 2. Hearts
     * 3. Diamonds
     * 4. Clover
     */
    private $spade =    "♠";
    private $hearts =   "♥";
    private $diamonds = "♦";
    private $clubs =    "♣";

    /**
     * Graphical representaion of the a cards value. Numbers use the numbers 2-10 whlies face cards and aces use their graphical representation
     */
    private $king =     "♔";
    private $queen =    "♕";
    private $jack =     "J";
    private $ace =      "A";

    /**
     * Local variable for storing the character
     */
    private $char =     "";
    /**
     * Local variable for storing the cards graphical representation
     */
    private $graphicSuit;
    /**
     * Local variable for storing the color
     */
    private $color;

    /**
     * Constructor. Initializes the object and sets its values
     */
    public function __construct(int $value, string $suit)
    {
        parent::__construct($value, $suit); // Gets parent constructor

        $this->setSuit($suit);
        $this->setValue($value);
    }

    /**
     * Sets the graphical suit of the card based on suit given in the constructor
     */
    private function setSuit($suit): void
    {
        switch($suit) {
            case 'black_spade':
                $this->graphicSuit = $this->spade;
                $this->color = "black";
                break;
            case 'red_hearts':
                $this->graphicSuit = $this->hearts;
                $this->color = "red";
                break;
            case 'black_clubs':
                $this->graphicSuit = $this->clubs;
                $this->color = "black";
                break;
            case 'red_diamonds':
                $this->graphicSuit = $this->diamonds;
                $this->color = "red";
                break;
        }
    }

    /**
     * Sets the character of the card based on value given in the constructor
     */
    private function setValue($value): void
    {
        if($value == 1) {
            $this->char = $this->ace;
        } elseif($value < 11) {
            $this->char = (string) $value;
        }

        switch($this->getValue()) {
            case 11:
                $this->char = $this->jack;
                break;
            case 12:
                $this->char = $this->queen;
                break;
            case 13:
                $this->char = $this->king;
                break;
        }
    }

    /**
     * Gets the color of the card
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Gets the graphical suit of the card
     * @return string
     */
    public function getGraphicSuit(): string
    {
        return $this->graphicSuit;
    }

    /**
     * Gets the character of the card
     * @return string
     */
    public function getChar(): string
    {
        return $this->char;
    }

    /**
     * Gets all values of the card (character, graphical suit and color)
     * @return array
     */
    public function getValues(): array
    {
        return [
            "char" => "{$this->char}",
            "suit" => "{$this->graphicSuit}",
            "color" => "{$this->color}"
        ];
    }

    /**
     * Generates a string that represents the card and its values
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->suit}" . " " . "{$this->char}";
    }
}
