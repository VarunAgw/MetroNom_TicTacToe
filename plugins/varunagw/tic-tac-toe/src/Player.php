<?php

namespace VarunAgw\TicTacToe;

class Player {

    protected $symbol;

    /**
     * Create a player with symbol
     * @param string|int $symbol Unique symbol of that player
     */
    public function __construct($symbol) {
        if (1 != strlen($symbol) || ' ' == $symbol) {
            throw new \Exception('Invalid Symbol');
        }
        $this->symbol = $symbol;
    }

    /**
     * @return string|int return symbol used by player
     */
    public function getSymbol() {
        return $this->symbol;
    }

    public function __toString() {
        return $this->symbol;
    }

}
