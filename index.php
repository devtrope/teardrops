<?php

session_start();

require_once 'config/functions.php';

try {
    $database = connectDatabase();
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}