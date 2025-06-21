<?php

function connectDatabase(): PDO {
    $databaseFile = __DIR__ . '/database.json';

    if (! file_exists($databaseFile)) {
        $databaseFile = __DIR__ . '/database.example.json';
    }

    if (! file_exists($databaseFile)) {
        throw new RuntimeException('Database configuration file not found.');
    }

    $database = json_decode(
        file_get_contents($databaseFile), true
    );

    if ($database === null) {
        throw new RuntimeException('Invalid JSON in configuration file.');
    }

    return new PDO(
        'mysql:host=' . $database['host'] . ';port=' . $database['port'] . ';dbname=' . $database['dbname'] . ';charset=' . $database['charset'],
        $database['username'],
        $database['password'],
        $database['options']
    );
}