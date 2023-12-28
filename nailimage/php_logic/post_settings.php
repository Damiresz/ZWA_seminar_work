<?php
include_once 'connect_db.php';
include_once 'get_data.php';
include_once 'validate/validate.php';
include_once 'func.php';

/**
 * Autentizace uživatele.
 *
 * Tato funkce ověřuje poskytnuté přihlašovací údaje uživatele
 * a v případě úspěšné autentizace nastavuje relaci a přesměrovává
 * uživatele na domovskou stránku. V opačném případě je generována chyba
 * a uživatel je přesměrován zpět s odpovídající zprávou.
 *
 * @param string $username Uživatelské jméno pro autentizaci.
 * @param string $password Heslo pro autentizaci.
 *
 */
function AuthUser($username, $password)
{
    // Pole pro uchovávání chyb
    $local_error = array();
    // Připojení k databazi
    $connect = connectToDatabase();
    // Příprava SQL dotazu pro ověření existence úžívatelu
    $sql_user = "SELECT * FROM Users WHERE `username` = ?";
    $stmt = $connect->prepare($sql_user);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userData = $stmt->get_result();

    if ($userData && $userData->num_rows > 0) {
        $userData = $userData->fetch_assoc();
        // Authorizace úžívatelu
        if (password_verify($password, $userData['password'])) {
            setSessionSuccess($userData);
            header('Location:' . BASE_DIR_URL);
            exit();
        } else {
            // Generovaní chyb jestli authorizace úžívatelu nejde
            $userData = array();
            $main_error['login_main_error'] = 'Incorrect password';
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    } else {
        // Generovaní chyb jestli neexistuje úžívatel
        $userData = array();
        $main_error['login_main_error'] = 'User is not registrated';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    }
}

/**
 * Registrace uživatele.
 *
 * Tato funkce zpracovává žádosti o registraci uživatele, ověřuje správnost CSRF tokenu,
 * provádí validaci na straně serveru a vytváří nový účet, pokud jsou všechny podmínky splněny.
 * V případě chyby generuje odpovídající chybové zprávy a provádí zpětné přesměrování.
 *
 * @param string $name Jméno uživatele.
 * @param string $surname Příjmení uživatele.
 * @param string $username Uživatelské jméno.
 * @param string $email E-mailová adresa.
 * @param string $password Heslo.
 * @param string $password2 Potvrzení hesla.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function RegistrationUser($name, $surname, $username, $email, $password, $password2, $submittedCSRF)
{
    // Pole pro uchovávání chyb
    $local_error = array();
    $main_error = array();
    // Oveření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace na straně serveru
        $mistakes = validateRegistration(
            $name,
            $surname,
            $username,
            $email,
            $password,
            $password2
        );

        if (empty($mistakes)) {
            // Připojení k databazi
            $connect = connectToDatabase();
            // Příprava SQL dotazu pro ověření existence e-mailu nebo username
            $check_query = $connect->prepare("SELECT `username`, `email` FROM Users WHERE username=? OR email=?");
            $check_query->bind_param("ss", $username, $email);
            $check_query->execute();
            $check_query->store_result();

            $check_query->bind_result($existingUsername, $existingEmail);
            // Generovaní chyb jestli existuje e-mailu nebo username v databazi
            while ($check_query->fetch()) {
                if ($existingUsername == $username) {
                    $local_error['username'] = "Such username already exists";
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
                if ($existingEmail == $email) {
                    $local_error['email'] = "Such email already exists";
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
            }

            if (empty($local_error)) {
                // Vytvaření hash hesla pomocí funkce password_verify
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $create_user_query = $connect->prepare("INSERT INTO `Users` (`name`, `surname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
                $create_user_query->bind_param("sssss", $name, $surname, $username, $email, $hashed_password);

                if ($create_user_query->execute()) {
                    // Uspěšna registrace a authorizace pomocí funkce AuthUser
                    AuthUser($username, $password);
                } else {
                    // Generovaní chyb jestli to nešlo
                    $main_error['connect_error'] = $connect->error;
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }

                $create_user_query->close();
            }

            $check_query->close();
            $connect->close();
        } else {
            // Generování chyb v případě neúspěchu validace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        }
    }
}

/**
 * Přihlášení uživatele.
 *
 * Tato funkce zpracovává žádosti o přihlášení uživatele, ověřuje správnost CSRF tokenu
 * a provádí validaci na straně serveru. V případě úspěšné autentizace uživatele
 * přesměrovává na domovskou stránku. V případě chyby generuje odpovídající chybové zprávy
 * a provádí zpětné přesměrování.
 *
 * @param string $username Uživatelské jméno.
 * @param string $password Heslo.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function LoginUser($username, $password, $submittedCSRF)
{
    // Pole pro uchovávání chyb
    $local_error = array();
    $main_error = array();
    // Oveření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace na straně serveru
        $mistakes = validateLogin(
            $username,
            $password,
        );

        if (empty($mistakes)) {
            // Autharizace úžívatelu
            AuthUser($username, $password);
        } else {
            // Generovaní chyb autharizace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        }
    }
}

/**
 * Aktualizace uživatelských údajů.
 *
 * Tato funkce zpracovává žádosti o aktualizaci uživatelských údajů, ověřuje správnost CSRF tokenu,
 * provádí validaci na straně serveru a aktualizuje údaje v databázi. V případě úspěchu
 * generuje odpovídající úspěšné zprávy, v opačném případě chybové zprávy a provádí zpětné přesměrování.
 *
 * @param string $new_name Nové jméno uživatele.
 * @param string $new_surname Nové příjmení uživatele.
 * @param string $new_username Nové uživatelské jméno.
 * @param string $new_email Nová e-mailová adresa.
 * @param string $new_address Nová adresa uživatele.
 * @param string $new_city Nové město uživatele.
 * @param string $new_postcode Nový poštovní kód uživatele.
 * @param string $new_country Nová země uživatele.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function UpdateUserData($new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {

        // Získání nových údajů z formuláře
        $new_name = $_POST['name'];
        $new_surname = $_POST['surname'];
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_address = $_POST['address'];
        $new_city = $_POST['city'];
        $new_postcode = $_POST['postcode'];
        $new_country = $_POST['country'];

        $new_data = [$new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country];
        
        // Získání údajů z session
        $requiredKeys = ['id', 'name', 'surname', 'username', 'email', 'address', 'city', 'postcode', 'country'];
        if (array_reduce($requiredKeys, function ($carry, $key) {
            return $carry && isset($_SESSION[$key]);
        }, true)) {
            foreach ($requiredKeys as $key) {
                ${"session_$key"} = $_SESSION[$key];
            }
            $session_data = [$session_name, $session_surname, $session_username, $session_email, $session_address, $session_city, $session_postcode, $session_country];
        } else {
            Not_Found();
        }

        // Porovnání nových údajů s aktuálními
        $differences = array_diff_assoc($new_data, $session_data);

        if (empty($differences)) {
            $main_error['no_changes'] = 'There were no changes';
            setErrorSession($local_error, $main_error);
            reverseUrl();
        } else {

            // Validace nových údajů
            $mistakes = validateProfile(
                $new_name,
                $new_surname,
                $new_username,
                $new_email,
                $new_address,
                $new_city,
                $new_postcode,
                $new_country
            );
            if (empty($mistakes)) {
                // Připojení k databázi
                $connect = connectToDatabase();
                if ($new_email != $session_email) {
                    // Kontrola existence e-mailu v případě změny e-mailu
                    $check_email = $connect->prepare("SELECT `email` FROM Users WHERE email=?");
                    $check_email->bind_param("s", $new_email);
                    $check_email->execute();
                    $check_email->store_result();

                    $check_email->bind_result($existingEmail);
                    $check_email->fetch();
                    if ($existingEmail == $new_email) {
                        $connect->close();
                        $local_error['email'] = "Such email already exists";
                        setErrorSession($local_error, $main_error);
                        reverseUrl();
                    }
                }

                if ($new_username != $session_username) {
                    // Kontrola existence username v případě změny username
                    $check_username = $connect->prepare("SELECT `username` FROM Users WHERE username=?");
                    $check_username->bind_param("s", $new_username,);
                    $check_username->execute();
                    $check_username->store_result();
                    $check_username->bind_result($existingUsername);
                    $check_username->fetch();
                    if ($existingUsername == $new_username) {
                        $connect->close();
                        $local_error['username'] = "Such username already exists";
                        setErrorSession($local_error, $main_error);
                        reverseUrl();
                    }
                }

                if (empty($local_error)) {
                    // Aktualizace údajů v databázi
                    $sql = "UPDATE Users SET name=?, surname=?, username=?, email=?,  address=?, city=?, postcode=?, country=? WHERE id=?";
                    $update_data = $connect->prepare($sql);
                    $update_data->bind_param("ssssssssi", $new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country, $session_id);
                    $update_data->execute();
                    // Aktualizace údajů v session
                    if ($currentSessionId == session_id()) {
                        $_SESSION['name'] = $new_name;
                        $_SESSION['surname'] = $new_surname;
                        $_SESSION['username'] = $new_username;
                        $_SESSION['email'] = $new_email;
                        $_SESSION['address'] = $new_address;
                        $_SESSION['city'] = $new_city;
                        $_SESSION['postcode'] = $new_postcode;
                        $_SESSION['country'] = $new_country;
                        // Úspěšná změna údajů
                        $main_success['success_change_data'] = 'The data has been reset';
                        setErrorSession($local_error, $main_error);
                        $_SESSION['main_success'] = $main_success;
                        $connect->close();
                        reverseUrl();
                    } else {
                        $connect->close();
                        Not_Found();
                    }
                } else {
                    foreach ($mistakes as $key => $value) {
                        $local_error[$key] = $value;
                        setErrorSession($local_error, $main_error);
                        $connect->close();
                        reverseUrl();
                    }
                }
            } else {
                // Generování chyb v případě neúspěchu validace
                foreach ($mistakes as $key => $value) {
                    $main_error[$key] = $value;
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
            }
        }
    }
}


/**
 * Aktualizace hesla uživatele.
 *
 * Tato funkce zpracovává žádosti o aktualizaci hesla uživatele, ověřuje správnost CSRF tokenu,
 * provádí validaci na straně serveru a aktualizuje heslo v databázi. V případě úspěchu
 * generuje odpovídající úspěšné zprávy, v opačném případě chybové zprávy a provádí zpětné přesměrování.
 *
 * @param string $new_password Nové heslo uživatele.
 * @param string $new_password_again Potvrzení nového hesla uživatele.
 * @param string $submittedCSRF Předložený CSRF token.
 * @param bool $adminMode Režim administrátora.
 * @param string|null $username Uživatelské jméno uživatele v režimu administrátora (volitelné).
 *
 * @return void
 */
function UpdateUserPassword($new_password, $new_password_again, $submittedCSRF, $adminMode, $username = null)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace nového hesla
        $mistakes = validatePassword(
            $new_password,
            $new_password_again
        );

        if (empty($mistakes) && isset($_SESSION['id'])) {
            // Získání ID uživatele z relace
            $session_id = $_SESSION['id'];
            // Připojení k databázi
            $connect = connectToDatabase();
            if (!$adminMode) {
                // Kontrola, zda nové heslo není shodné s aktuálním heslem
                $check_password = $connect->prepare("SELECT password FROM Users WHERE id=?");
                $check_password->bind_param("i", $session_id);
                $check_password->execute();
                $check_password->bind_result($hashed_password);
                $check_password->fetch();
                $check_password->close();

                if (password_verify($new_password, $hashed_password)) {
                    $connect->close();
                    $main_error['error_change_password'] = 'This is the current password';
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
                // Aktualizace hesla v databázi
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
                $update_password->bind_param("si", $hashed_new_password, $session_id);
                $update_password->execute();
                // Úspěšná změna hesla
                $main_success['success_change_password'] = 'Your password has been changed';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            } elseif ($adminMode === true) {
                // Získání uživatelských dat v režimu administrátora
                $user_data = $connect->prepare("SELECT * FROM Users WHERE username=?");
                $user_data->bind_param("s", $username);
                $user_data->execute();
                $result_user_data = $user_data->get_result();

                if ($result_user_data->num_rows > 0) {
                    // Aktualizace hesla uživatele
                    $user = $result_user_data->fetch_assoc();
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
                    $update_password->bind_param("si", $hashed_new_password, $user['id']);
                    $update_password->execute();
                    // Úspěšná změna hesla uživatele
                    $main_success['success_change_password'] = 'Password has been changed';
                    $_SESSION['main_success'] = $main_success;
                    $user_data->close();
                    $connect->close();
                    reverseUrl();
                } else {
                    // Uživatel neexistuje
                    $main_error['error'] = 'User is no exist';
                    setErrorSession($local_error, $main_error);
                    $user_data->close();
                    $connect->close();
                    reverseUrl();
                }
            }
        } else {
            // Generování chyb v případě neúspěchu validace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
            }
        }
    }
}


/**
 * Přidání produktu.
 *
 * Tato funkce zpracovává žádosti o přidání nového produktu, ověřuje správnost CSRF tokenu,
 * provádí validaci na straně serveru a v případě úspěchu přidává produkt do databáze.
 * V případě chyby generuje odpovídající chybové zprávy a provádí zpětné přesměrování.
 *
 * @param string $productName Název produktu.
 * @param string $productImgUrl URL obrázku produktu.
 * @param string $productDiscription Popis produktu.
 * @param float $productPrice Cena produktu.
 * @param int $productCategory ID kategorie produktu.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function AddProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace vstupních dat produktu
        $mistakes = validateProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory);

        if (empty($mistakes)) {
            // Sankce URL obrázku produktu
            $productImgUrl = filter_var($productImgUrl, FILTER_SANITIZE_URL);

            // Kontrola existence souboru na serveru
            if (file_exists($productImgUrl)) {
                $date_creation = date("Y-m-d H:i:s");
                $connect = connectToDatabase();

                // Příprava a provedení připraveného SQL dotazu
                $sql_write = "INSERT INTO Products (name, photo_path,discription, price, date_update, category_id)
                          VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $connect->prepare($sql_write);
                $stmt->bind_param("sssisi", $productName, $productImgUrl, $productDiscription, $productPrice, $date_creation, $productCategory);

                // Provedení připraveného dotazu
                if ($stmt->execute()) {
                    $main_success['success_writting_file'] = 'The product has been added';
                    $_SESSION['main_success'] = $main_success;
                    setErrorSession($local_error, $main_error);
                    $stmt->close();
                    $connect->close();
                    header('Location:' . PRODUCT_SETTINGS_URL);
                    exit;
                } else {
                    // Chyba při provádění dotazu
                    $main_error['erroe_stmt'] = 'Error adding the file';
                    setErrorSession($local_error, $main_error);
                    $stmt->close();
                    $connect->close();
                    reverseUrl();
                }
                $stmt->close();
            } else {
                // Chyba zápisu souboru
                $main_error['write_error'] = 'Error writing the file';
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        } else {
            // Generování chyb v případě neúspěchu validace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        }
    }
}

/**
 * Úprava informací o produktu.
 *
 * Tato funkce zpracovává žádosti o úpravu informací o existujícím produktu, ověřuje správnost CSRF tokenu,
 * provádí validaci na straně serveru a v případě úspěchu aktualizuje informace o produktu v databázi.
 * V případě chyby generuje odpovídající chybové zprávy a provádí zpětné přesměrování.
 *
 * @param int $product_id ID produktu, který se má upravit.
 * @param string $productName Název produktu.
 * @param string $productImgUrl URL obrázku produktu.
 * @param string $productDiscription Popis produktu.
 * @param float $productPrice Cena produktu.
 * @param int $productCategory ID kategorie produktu.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function ModifyProduct($product_id, $productName, $productImgUrl, $productDiscription, $productPrice, $productCategory, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['csrf_error'] = 'Error CSRF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace vstupních dat produktu
        $mistakes = validateProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory);

        if (empty($mistakes)) {
            // Připojení k databázi
            $connect = connectToDatabase();

            // Kontrola změněných údajů před provedením dotazu UPDATE
            $check_changes_query = $connect->prepare("SELECT name, photo_path, discription, price, category_id FROM Products WHERE id = ?");
            $check_changes_query->bind_param("i", $product_id);
            $check_changes_query->execute();
            $check_changes_query->store_result();

            if ($check_changes_query->num_rows > 0) {
                $check_changes_query->bind_result($existingName, $existingImgUrl, $existingDescription, $existingPrice, $existingCategory);

                if ($check_changes_query->fetch()) {
                    if ($existingName == $productName && $existingImgUrl == $productImgUrl && $existingDescription == $productDiscription && $existingPrice == $productPrice && $existingCategory == $productCategory) {
                        // Data nebyla změněna, vrácení zprávy o úspěšném aktualizování
                        $main_success['success_message'] = 'No changes were made';
                        $_SESSION['main_success'] = $main_success;
                        $connect->close();
                        header('Location:' . PRODUCT_SETTINGS_URL);
                        exit;
                    }
                }
            }

            // Pokračování s aktualizací informací o produktu v databázi
            $date_update = date("Y-m-d H:i:s");
            $update_product = $connect->prepare("UPDATE Products SET name = ?, photo_path = ?, discription = ?, price = ?, date_update = ?, category_id = ? WHERE id = ?");
            $update_product->bind_param("sssdsii", $productName, $productImgUrl, $productDiscription, $productPrice, $date_update, $productCategory, $product_id);

            if ($update_product->execute() === false) {
                // Chyba při aktualizaci produktu
                $local_error['update_error'] = 'Error updating product';
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            } else {
                // Úspěšná aktualizace produktu
                $main_success['success_message'] = 'Product updated successfully';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                header('Location:' . PRODUCT_SETTINGS_URL);
                exit;
            }
        } else {
            // Generování chyb v případě neúspěchu validace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
            }
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    }
}


/**
 * Smazání produktu.
 *
 * Tato funkce zpracovává žádosti o smazání existujícího produktu, ověřuje správnost CSRF tokenu
 * a v případě úspěchu odstraní produkt z databáze. V případě chyby generuje odpovídající chybové zprávy
 * a provádí zpětné přesměrování.
 *
 * @param int $product_id ID produktu, který se má smazat.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function DeleteProduct($product_id, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Kontrola existence ID produktu
        if (isset($product_id)) {
            // Připojení k databázi
            $connect = connectToDatabase();
            // Sestavení a provedení SQL dotazu pro smazání produktu
            $sql_del = "DELETE FROM Products WHERE id = $product_id";
            // Kontrola úspěšnosti provedení dotazu
            if ($connect->query($sql_del) === TRUE) {
                // Úspěch při mazání produktu
                $main_success['success_delete'] = 'The product deleted';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            }
            // Chyba při mazání produktu
            $main_error['delete_error'] = 'Error deleted';
            setErrorSession($local_error, $main_error);
            $connect->close();
            reverseUrl();
        }
    }
}




function AddCategory($categoryName, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validateCategory($categoryName);

        if (empty($mistakes)) {
            $connect = connectToDatabase();
            $check_category = $connect->prepare("SELECT name_category FROM Categories WHERE name_category = ?");
            $check_category->bind_param("s", $categoryName);
            $check_category->execute();
            $check_category->store_result();

            if ($check_category->num_rows > 0) {
                $main_error['category'] = "Such category already exists";
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
            if (empty($local_error)) {
                $update_data = $connect->prepare("INSERT INTO Categories (name_category) VALUES (?)");
                $update_data->bind_param("s", $categoryName);
                if ($update_data->execute()) {
                    $main_success['success_add_category'] = 'The category has been added';
                    $_SESSION['main_success'] = $main_success;
                    $connect->close();
                    header('Location:' . CATEGORY_SETTINGS_URL);
                    exit;
                } else {
                    $main_error['Execute_error'] = 'Execute_error';
                    setErrorSession($local_error, $main_error);
                    $connect->close();
                    reverseUrl();
                }
            } else {
                foreach ($mistakes as $key => $value) {
                    $main_error[$key] = $value;
                    setErrorSession($local_error, $main_error);
                    $connect->close();
                    reverseUrl();
                }
            }
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        }
    }
}

/**
 * Přidání nové kategorie.
 *
 * Tato funkce zpracovává žádosti o přidání nové kategorie, ověřuje správnost CSRF tokenu,
 * provede validaci na straně serveru a v případě úspěchu přidá novou kategorii do databáze.
 * V případě chyby generuje odpovídající chybové zprávy a provádí zpětné přesměrování.
 *
 * @param string $categoryName Název nové kategorie.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function ChangeCategory($categoryName_new, $categoryName_old, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['csrf_error'] = 'Error CSRF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Validace názvu nové kategorie
        if ($categoryName_old == $categoryName_new) {
            $main_success['success_category'] = 'There were no change';
            $_SESSION['main_success'] = $main_success;
            header('Location:' . CATEGORY_SETTINGS_URL);
            exit;
        }

        $mistakes = validateCategory($categoryName_new);

        if (empty($mistakes)) {
            // Připojení k databázi
            $connect = connectToDatabase();
            // Kontrola existence kategorie se stejným názvem
            $check_category = $connect->prepare("SELECT name_category FROM Categories WHERE name_category = ?");
            $check_category->bind_param("s", $categoryName_old);
            $check_category->execute();
            $check_category->store_result();

            if ($check_category->num_rows == 0) {
                // Kategorie se stejným názvem již existuje
                $main_error['category_error'] = "You are trying to change a non-existent category";
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }

            $check_category->bind_result($category_db);

            if ($check_category->fetch()) {
                // Přidání nové kategorie do databáze
                $update_data = $connect->prepare("UPDATE Categories SET name_category=? WHERE name_category=?");
                $update_data->bind_param("ss", $categoryName_new, $categoryName_old);

                if ($update_data->execute()) {
                    // Úspěšné přidání kategorie
                    $main_success['success_add_category'] = 'The category has been changed';
                    $_SESSION['main_success'] = $main_success;
                    $connect->close();
                    header('Location:' . CATEGORY_SETTINGS_URL);
                    exit;
                } else {
                    // Chyba při provedení exikuce
                    $main_error['execute_error'] = 'Execute error';
                    setErrorSession($local_error, $main_error);
                    $connect->close();
                    reverseUrl();
                }
            } else {
                // Chyba při provedení dotazu
                $main_error['category_error'] = "Error fetching category details";
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        } else {
            // Generování chyb v případě neúspěchu validace
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
            }
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    }
}

/**
 * Smazání kategorie.
 *
 * Tato funkce zpracovává žádosti o smazání existující kategorie, ověřuje správnost CSRF tokenu,
 * a v případě úspěchu odstraní kategorii z databáze. Pokud kategorie obsahuje produkty, generuje
 * odpovídající chybovou zprávu. V případě chyby generuje další chybové zprávy a provádí zpětné přesměrování.
 *
 * @param int $category_id ID kategorie, kterou chcete smazat.
 * @param string $submittedCSRF Předložený CSRF token.
 *
 * @return void
 */
function DeleteCategory($category_id, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    // Ověření CSRF tokenu
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        // Kontrola existence ID kategorie
        if (isset($category_id)) {
            // Připojení k databázi
            $connect = connectToDatabase();
            // Kontrola existence produktů v kategorii
            $products = getProducts(null, null, $category_id);
            if (count($products) > 0) {
                // Kategorie obsahuje produkty, nelze ji smazat
                $main_error['error_delete'] = 'You cannot delete a category that contains products';
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            }
            // Sestavení a provedení SQL dotazu pro smazání kategorie
            $sql_del = "DELETE FROM Categories WHERE id_category = $category_id";
            // Kontrola úspěšnosti provedení dotazu
            if ($connect->query($sql_del) === TRUE) {
                // Úspěch při mazání kategorie
                $main_success['success_delete'] = 'The category deleted';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            } else {
                // Chyba při mazání kategorie
                $main_error['delete_error'] = 'Error deleted';
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            }
        }
    }
}






/**
 * Zpracování žádostí o akce na základě odeslaných formulářů.
 *
 * Tato funkce zpracovává obsah pole $_POST a volá odpovídající funkce pro provedení příslušné akce
 * na základě odeslaných formulářů. Kontroluje také oprávnění pro některé akce.
 *
 * @param array $POST Asociativní pole obsahující data odeslaná formulářem pomocí metody POST.
 *
 * @return void
 */
function postWhat($POST)
{
    // Přihlášení uživatele
    if (isset($POST['authorization_user'])) {
        LoginUser($POST['username'], $_POST['password'], $POST['csrf_token']);
    }
    // Registrace uživatele
    if (isset($POST['registration_user'])) {
        RegistrationUser($POST['name'], $POST['surname'], $POST['username'], $POST['email'], $POST['password'], $POST['password2'], $POST['csrf_token']);
    }
    // Aktualizace hesla uživatele
    if (isset($POST['update_user_password'])) {
        if (isset($_SESSION['id']))
            UpdateUserPassword($POST['password'], $POST['password2'], $POST['csrf_token'], false);
        else {
            Not_Found();
        }
    }
    // Aktualizace údajů uživatele
    if (isset($POST['update_user_data'])) {
        if (isset($_SESSION['id'])) {
            UpdateUserData($POST['name'], $POST['surname'], $POST['username'], $POST['email'], $POST['address'], $POST['city'], $POST['postcode'], $POST['country'], $POST['csrf_token']);
        } else {
            Not_Found();
        }
    }

    // Nastavení uživatelských hesel (pro administrátora)
    if (isset($POST['users_settings'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            UpdateUserPassword($POST['password'], $POST['password2'], $POST['csrf_token'], true, $POST['username']);
        else {
            reverseUrl();
        }
    }
    // Přidání produktu (pro administrátora)
    if (isset($POST['add_product'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            AddProduct($POST['productName'], $POST['productImgUrl'], $POST['productDiscription'], $POST['productPrice'], $POST['productCategory'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    // Úprava produktu (pro administrátora)
    if (isset($POST['modify_product'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            ModifyProduct($POST['productId'], $POST['productName'], $POST['productImgUrl'], $POST['productDiscription'], $POST['productPrice'], $POST['productCategory'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    // Smazání produktu (pro administrátora)
    if (isset($POST['delete_product'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            DeleteProduct($POST['product_id'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    // Přidání kategorie (pro administrátora)
    if (isset($POST['add_category'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            AddCategory($POST['categoryName'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    // Změna názvu kategorie (pro administrátora)
    if (isset($POST['change_category'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            ChangeCategory($POST['categoryName'], $POST['categoryName_old'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    // Smazání kategorie (pro administrátora)
    if (isset($POST['delete_category'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
            DeleteCategory($POST['category_id'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }

    // Hledaní productu (pro administrátora)
    if (isset($POST['search_admin'])) {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $_SESSION['search_input'] = $POST['search_input'];
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            reverseUrl();
        }
    }
}
