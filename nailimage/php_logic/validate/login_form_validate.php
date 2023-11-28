<?php

include_once 'validate.php';

function validate ($username, $password) {
    $mistake = array();
    $username = trim ($username);
    $password = trim ($password);

    // Username
    if (!isset($username) & $username === null ) {
        
    } 
    elseif ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    }

    elseif (strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    }

    elseif (strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    elseif (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    
    // Pwd
    if (!isset($password) & $password === null ) {
        
    }
    elseif ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    }

    elseif (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    return $mistake;
}


?>