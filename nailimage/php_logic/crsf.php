<?php

/**
 * Generuje a ukládá CSRF token pro ochranu před útoky typu Cross-Site Request Forgery (CSRF).
 *
 * @return string Náhodně vygenerovaný CSRF token.
 * 
 */
function generateCSRFToken()
{
    // Používá funkci random_bytes() k vygenerování náhodné posloupnosti bytů
    $csrfToken = bin2hex(random_bytes(32));
    // CSRF token je uložen v session pro pozdější kontrolu
    $_SESSION['csrf_token'] = $csrfToken;
    // Vrátí se vygenerovaný CSRF token
    return $csrfToken;
}


/**
 * Funkce verifyCSRFToken() slouží k ověření platnosti CSRF tokenu.
 *
 * @param string $submittedToken Odeslaný CSRF token, který má být ověřen.
 *
 * @return bool Vrací `true`, pokud je CSRF token platný, a `false` v opačném případě.
 */
function verifyCSRFToken($submittedToken)
{
    // Zkontroluje, zda v session existuje CSRF token a zda je odeslaný token platný
    return (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $submittedToken));
}
