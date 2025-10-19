<?php


function error(string $field): ?string
{
    if (! isset($_SESSION['errors'][$field])) {
        return null;
    }

    $error = $_SESSION['errors'][$field];
    unset($_SESSION['errors'][$field]);

    return $error;
}