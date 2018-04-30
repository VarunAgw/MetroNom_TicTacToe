<?php

namespace VarunAgw\TicTacToe;

interface PlayerInterface {

    public function __construct($symbol);

    public function getSymbol();

    public function __toString();

    /**
     * 
     * @param type $board 2-dimensional array containing board information
     * @param type $allowedTurns array of possible turns allowed
     */
    public function playTurn($board, $allowedTurns);
}
