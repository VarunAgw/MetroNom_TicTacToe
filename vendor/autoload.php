<?php

/**
 * A very simple PSR-4 autoloader
 * @author Varun Agrawal <Varun@VarunAgw.com>
 */
spl_autoload_register(function ($class) {

    $namespaces = [
        'VarunAgw\\TicTacToe\\' => 'plugins/varunagw/tic-tac-toe/src/',
    ];

    foreach ($namespaces as $namespace => $path) {
        if (strpos($class, $namespace) === 0) {
            $file = str_replace($namespace, $path, $class);

            if (file_exists($file . '.php')) {
                require_once $file . '.php';
            }
        }
    }
});
