<?php
/**
 * Odhlášení uživatele a přesměrování na domovskou stránku.
 *
 * Tento soubor obsahuje kód pro zrušení relace uživatele a následné přesměrování
 * na domovskou stránku aplikace.
 */
session_destroy();
header('Location:'.BASE_DIR_URL);
exit();