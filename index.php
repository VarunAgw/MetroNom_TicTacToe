<?php

require 'vendor/autoload.php';

use VarunAgw\TicTacToe;

// Creating Players
$player1 = new TicTacToe\HumanPlayer('O');
$player2 = new TicTacToe\ComputerPlayer('X');
$player3 = new TicTacToe\ComputerPlayer('Y');

// Initializing the Game
$game = new TicTacToe\Game(5, $player1, $player2, $player3);

// Starting the Game
$game->startGame();
