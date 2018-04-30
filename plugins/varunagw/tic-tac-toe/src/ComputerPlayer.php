<?php

namespace VarunAgw\TicTacToe;

class ComputerPlayer extends Player implements PlayerInterface {

    public function playTurn($board, $allowedTurns) {
        /*
         * Just choose any possible random turn
         */
        $randomTurn = array_rand($allowedTurns);
        return $allowedTurns[$randomTurn];
    }

}
