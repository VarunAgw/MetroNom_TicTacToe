<?php

namespace VarunAgw\TicTacToe;

class HumanPlayer extends Player implements PlayerInterface {

    public function playTurn($board, $allowedTurns) {

        while (true) {
            echo "Input (x,y) position (board starts from 0,0)? ";
            $turn = explode(',', rtrim(fgets(STDIN)));

            if (!in_array($turn, $allowedTurns)) {
                echo "Invalid Turn. Try again!\n\n";
            } else {
                return [(int) $turn[0], (int) $turn[1]];
            }
        }
    }

}
