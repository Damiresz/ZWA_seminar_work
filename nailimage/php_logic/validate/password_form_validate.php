<?php
include_once 'validate.php';
function validate ($password, $password2) {
    $mistake = array();

    $password = trim ($password);
    $password2 = trim ($password2);

    // Pwd
    if (!isset($password) & $password === null ) {
        
    }
    elseif ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    }

    elseif (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    // Pwd2
    if (!isset($password2) & $password2 === null ) {
        
    }
    elseif ($password && !isset($password2)) {
      exit;
    }
    elseif ($password2 !== $password) {
                $mistake['password2'] = "Passwords don't match";
        
    } elseif ($password2 === "") {
        $mistake['password2'] = "Entity cannot be empty";
    }
    
    elseif (!isValidPwd($password2)) {
        $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    return $mistake;
}

?>