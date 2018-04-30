<?php

namespace VarunAgw\TicTacToe;

class Game {

    protected $board;
    protected $boardSize;
    protected $players;
    protected $turnId;

    /**
     * Initialize the game
     * @param int $boardSize Board Size
     * @param \VarunAgw\TicTacToe\Player $players List of Players
     */
    public function __construct(int $boardSize, Player ...$players) {
        $this->boardSize = $boardSize;

        // Initialize 2 dimensional board with null values
        $this->board = array_pad([], $boardSize, array_pad([], $boardSize, null));

        // Validate duplicate players
        $symbols = [];
        foreach ($players as $player) {
            $symbols[] = $player->getSymbol();
        }
        if (count($symbols) != count(array_unique($symbols))) {
            throw new \Exception("Multiple player with same symbol is against the rule");
        }

        // Shuffle players to change first player
        shuffle($players);
        $this->players = $players;

        // After shuffle, player 0 will be first
        $this->turnId = 0;
    }

    /**
     * Announcing the start of game
     */
    protected function announceStart() {
        $playersSymbols = [];
        foreach ($this->players as $player) {
            $playersSymbols[] = $player->getSymbol();
        }

        echo "\nWelcome To World Famous Tic-Tac-Toe\n"
        . "A big round of applause for our current players ("
        . implode(', ', $playersSymbols) . ")\n"
        . "Let's began the game!\n";
    }

    /**
     * Print board
     */
    protected function printBoard() {
        echo "\n";
        for ($i = 0; $i < $this->boardSize; $i++) {
            for ($j = 0; $j < $this->boardSize; $j++) {
                if (null == $this->board[$i][$j]) {
                    echo '-';
                } else {
                    echo $this->board[$i][$j]->getSymbol();
                }
            }
            echo "\n";
        }
    }

    /**
     * Get list of all possible turns
     * @return array list of possible turns
     */
    protected function getAllowedTurns() {
        $turns = [];
        for ($i = 0; $i < $this->boardSize; $i++) {
            for ($j = 0; $j < $this->boardSize; $j++) {
                if (null == $this->board[$i][$j]) {
                    $turns[] = [$i, $j];
                }
            }
        }
        return $turns;
    }

    /**
     * Announce a player turn
     * @param Player $player
     */
    protected function announceTurn($player) {
        echo "Player {$player->getSymbol()} turn\n";
    }

    /**
     * Ask user to play his turn
     */
    protected function playTurn() {
        $player = $this->players[$this->turnId];
        $allowedTurnes = $this->getAllowedTurns();

        $this->announceTurn($player);
        while (true) {
            $playerTurn = $player->playTurn($this->board, $allowedTurnes);
            if (in_array($playerTurn, $allowedTurnes)) {
                break;
            }
        }

        /*
         * Update turn to next user and returns  to fist player after a round
         */
        $this->board[$playerTurn[0]][$playerTurn[1]] = $player;
        $this->turnId++;
        if ($this->turnId > count($this->players) - 1) {
            $this->turnId = 0;
        }
    }

    /**
     * Check the status of game
     * @return boolean false if game is still playable, result if game is over
     */
    protected function isGameOver() {
        /*
         * Winning Strategy: Horizontal/vetical rows
         */
        for ($i = 0; $i < $this->boardSize; $i++) {
            $horizontalPattern = [];
            $verticalPattern = [];

            for ($j = 0; $j < $this->boardSize; $j++) {
                $horizontalPattern[] = $this->board[$i][$j];
                $verticalPattern[] = $this->board[$j][$i];
            }

            if (1 == count(array_unique($horizontalPattern)) && null !== $horizontalPattern[0]) {
                return (object) ['result' => 'WIN', 'player' => $horizontalPattern[0]];
            }
            if (1 == count(array_unique($verticalPattern)) && null !== $verticalPattern[0]) {
                return (object) ['result' => 'WIN', 'player' => $verticalPattern[0]];
            }
        }

        /*
         * Winning Strategy: diagonals
         */
        $diagonal1 = [];
        $diagonal2 = [];
        for ($i = 0; $i < $this->boardSize; $i++) {
            $diagonal1[] = $this->board[$i][$i];
            $diagonal2[] = $this->board[$this->boardSize - 1 - $i][$this->boardSize - 1 - $i];
        }
        if (1 == count(array_unique($diagonal1)) && null !== $diagonal1[0]) {
            return (object) ['result' => 'WIN', 'player' => $diagonal1[0]];
        }
        if (1 == count(array_unique($diagonal2)) && null !== $diagonal2[0]) {
            return (object) ['result' => 'WIN', 'player' => $diagonal2[0]];
        }

        // Board is full already
        if (0 == count($this->getAllowedTurns())) {
            return (object) ['result' => 'DRAW', 'reason' => 'BOARD_FULL'];
        }

        return false;
    }

    protected function announceResult($result) {
        switch ($result->result) {
            case 'DRAW':
                echo "\nDRAW: Reason - " . $result->reason;
                break;
            case 'WIN':
                echo "\nWIN: Player - " . $result->player->getSymbol();
                break;
        }
    }

    public function startGame() {
        $this->announceStart();

        while (true) {
            $this->printBoard();

            if ($result = $this->isGameOver()) {
                $this->announceResult($result);
                break;
            } else {
                $this->playTurn();
            }
        }
    }

}
