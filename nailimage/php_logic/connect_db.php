<?php

/**
 * Funkce connectToDatabase() vytváří spojení s databází s použitím mutexu (semafóru) pro zajištění bezpečnosti vláken.
 *
 * @return mysqli Objekt připojení k databázi (mysqli).
 */
function connectToDatabase()
{
    // Získání mutexu (semafóru) pro zajištění bezpečnosti vláken
    $mutex = sem_get(ftok(__FILE__, 'a'));

    // Získání zámku mutexu
    sem_acquire($mutex);

    // Parametry připojení k databázi
    $localhost = "localhost";
    $username_db = "abduldam";
    $password_db = "Derevo1602";
    $db = "abduldam";

    // Vytvoření objektu připojení k databázi
    $connect = new mysqli($localhost, $username_db, $password_db, $db);

    // Kontrola úspěšného připojení
    if ($connect->connect_error) {
        die("Error connect to database: " . $connect->connect_error);
    }

    // Uvolnění zámku mutexu
    sem_release($mutex);
    // Vrácení objektu připojení k databázi
    return $connect;
}
