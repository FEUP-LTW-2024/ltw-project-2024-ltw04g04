<?php

function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function cleanIntInput($input) {
    $input = filter_var($input, FILTER_VALIDATE_INT);
    return $input;
}

?>

