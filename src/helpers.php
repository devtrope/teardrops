<?php

function old(string $field): ?string
{
    if (! isset($_SESSION['old'][$field])) {
        return null;
    }

    $old = $_SESSION['old'][$field];
    unset($_SESSION['old'][$field]);

    return $old;
}

function error(string $field): ?string
{
    if (! isset($_SESSION['errors'][$field])) {
        return null;
    }

    $error = $_SESSION['errors'][$field];
    unset($_SESSION['errors'][$field]);

    return $error;
}