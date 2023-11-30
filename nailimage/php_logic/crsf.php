<?php 
function generateCSRFToken()
{
    $csrfToken = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrfToken;
    return $csrfToken;
}

function verifyCSRFToken($submittedToken)
{
    return (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $submittedToken));
}