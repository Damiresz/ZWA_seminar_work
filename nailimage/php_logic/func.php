<?php

/**
 * Nastaví údaje uživatele do relačních proměnných při úspěšném přihlášení nebo registraci.
 *
 * @param array|null $userData Pole obsahující údaje o uživateli nebo null, pokud údaje nejsou k dispozici.
 */
function setSessionSuccess($userData = null)
{
   // Kontrola, zda jsou poskytnuty údaje o uživateli
   if ($userData !== null) {
      // Nastavení jednotlivých relačních proměnných s údaji o uživateli
      
      $_SESSION['id'] = $userData['id'];
      $_SESSION['name'] = $userData['name'];
      $_SESSION['surname'] = $userData['surname'];
      $_SESSION['username'] = $userData['username'];
      $_SESSION['email'] = $userData['email'];
      $_SESSION['address'] = $userData['address'];
      $_SESSION['city'] = $userData['city'];
      $_SESSION['postcode'] = $userData['postcode'];
      $_SESSION['country'] = $userData['country'];
      $_SESSION['isAdmin'] = $userData['isAdmin'];
   }
}

/**
 * Nastaví relační proměnné pro uchování chyb a dat ve relaci.
 *
 * @param array|null $local_error Pole s lokálními chybami nebo null, pokud žádné neexistují.
 * @param array|null $main_error Pole s hlavními chybami nebo null, pokud žádné neexistují.
 */
function setErrorSession($local_error = null, $main_error = null)
{
   // Kontrola, zda jsou poskytnuty lokální chyby
   if ($local_error !== null) {
      // Nastavení relační proměnné pro lokální chyby
      $_SESSION['local_error'] = $local_error;
   }

   // Kontrola, zda jsou poskytnuty hlavní chyby
   if ($main_error !== null) {
      // Nastavení relační proměnné pro hlavní chyby
      $_SESSION['main_error'] = $main_error;
   }

   // Nastavení relační proměnné pro uchování dat formuláře
   $_SESSION['postData'] = $_POST;
}

/**
 * Odstraní relační proměnné uchovávající informace o chybách a úspěších ve relaci.
 */
function removeErrorSession()
{
   // Odstranění relační proměnné pro uchování dat formuláře
   unset($_SESSION['postData']);

   // Odstranění relační proměnné pro hlavní chyby
   unset($_SESSION['main_error']);

   // Odstranění relační proměnné pro lokální chyby
   unset($_SESSION['local_error']);

   // Odstranění relační proměnné pro hlavní úspěchy
   unset($_SESSION['main_success']);
   unset($_SESSION['search_input']);
}

/**
 * Zobrazí stránku s chybovým kódem 404 (Not Found) a ukončí běh skriptu.
 */
function Not_Found()
{
   // Nastavení HTTP kódu odpovědi na 404
   http_response_code(404);
   // Vložení obsahu stránky s chybou 404
   include_once BASE_DIR . 'templates/404.php';
   // Ukončení běhu skriptu
   exit();
}

/**
 * Přesměruje na předchozí URL adresu. Pokud není dostupná, zobrazí stránku s chybou 404.
 */
function reverseUrl()
{  // Získání předchozí URL adresy z hlavičky 'HTTP_REFERER'
   $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
   // Pokud je k dispozici předchozí URL adresa, provede přesměrování
   if ($referrer) {
      // Nastavení hlavičky pro přesměrování
      header('Location:' . $referrer);
      exit;
   } else {
      // Pokud předchozí URL adresa není k dispozici, zobrazí stránku s chybou 404
      Not_Found();
   }
}


/**
 * Kontroluje a odstraňuje soubory v adresáři, které nejsou zaznamenány v databázi.
 */
function checkAndDeleteFiles()
{
   require_once 'connect_db.php';
   $connect = connectToDatabase();

    // Získání všech záznamů o souborech z databáze
   $sql = "SELECT photo_path FROM Products";
   $photos_path_db = $connect->query($sql);

  // Inicializace pole pro uchování cest ze databáze
   $photos_path = array();

   if ($photos_path_db->num_rows > 0) {
      while ($photo_path = $photos_path_db->fetch_assoc()) {
         $photos_path[] = $photo_path['photo_path'];
      }
   }

    // Adresář, kde se nacházejí soubory
   $directoryPath = BASE_DIR . 'image/products/';
   $filesInDirectory = array_diff(scandir($directoryPath), array('..', '.'));

  // Porovnání každého souboru v adresáři s cestami z databáze
   foreach ($filesInDirectory as $file) {
      $filePath = $directoryPath . $file;

      if (!in_array($filePath, $photos_path)) {
         // Soubor v adresáři není zaznamenán v databázi, odstraňujeme ho
         unlink($filePath);
      }
   }

   // Zavření spojení s databází
   $connect->close();
}


function clean_uri($uri)
{
   // Проверка наличия "/category" в строке
   if (strstr($uri, 'category')) {
      // Удаление подстроки "/category" и все после неё
      $uri = strstr($uri, 'category', true);
   }

   // Проверка наличия "?page=" в строке
   if (strstr($uri, '?page=')) {
      // Удаление подстроки "?page=" и все после неё
      $uri = explode('?page=', $uri)[0];
   }
   // Проверка наличия "?product=" в строке
   if (strstr($uri, '?product=')) {
      // Удаление подстроки "?page=" и все после неё
      $uri = explode('?product=', $uri)[0];
   }
// Vrácení výsledků
   return $uri;
}

/**
 * Čistí URI od určitých parametrů.
 *
 * @param string $uri Vstupní URI
 * @return string Čisté URI
 */
function paramsPage($uri)
{
   $matches = array();

     // Odstranění podřetězce "?page=" a všeho za ním
   if (preg_match("/page\/(\d+)/", $uri, $pageMatches)) {
      $matches['page'] = $pageMatches[1];
   }

  // Odstranění podřetězce "/category" a všeho za ním
   if (preg_match("/category\/(\w+(?:-\w+)?)/", $uri, $categoryMatches)) {
      $matches['get_category'] = $categoryMatches[1];
   }

    // Odstranění podřetězce "?product=" a všeho za ním
   if (preg_match("/product=(\d+)/", $uri, $productMatches)) {
      $matches['get_product'] = $productMatches[1];
   }

   // Přenese do GET parametry
   foreach ($matches as $key => $value) {
      $_GET[$key] = $value;
   }
   // Vrácení GET parametry
   return $matches;
}


/**
 * Formátuje datum a čas ve specifickém formátu.
 *
 * @param string $datetime_str Vstupní řetězec s datem a časem.
 * @return string Formátovaný řetězec.
 */
function format_datetime($datetime_str)
{
   $datetime_object = new DateTime($datetime_str);
   $today = new DateTime();
   $yesterday = (new DateTime())->sub(new DateInterval('P1D'));

   if ($datetime_object->format('Y-m-d') === $today->format('Y-m-d')) {
      return 'Today at ' . $datetime_object->format('H:i');
   } elseif ($datetime_object->format('Y-m-d') === $yesterday->format('Y-m-d')) {
      return 'Yesterday at ' . $datetime_object->format('H:i');
   } else {
      return $datetime_object->format('d.m.y H:i');
   }
}
