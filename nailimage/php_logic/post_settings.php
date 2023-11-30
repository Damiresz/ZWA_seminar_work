<?php
include_once 'connect_db.php';
include_once 'validate/validate.php';
include_once 'func.php';

function RegistrationUser($name, $surname, $username, $email, $password, $password2, $submittedCSRF)
{
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validateRegistration(
            $name,
            $surname,
            $username,
            $email,
            $password,
            $password2
        );

        if (empty($mistakes)) {
            $connect = connectToDatabase();

            //   
            $check_query = $connect->prepare("SELECT `username`, `email` FROM Users WHERE username=? OR email=?");
            $check_query->bind_param("ss", $username, $email);
            $check_query->execute();
            $check_query->store_result();

            $check_query->bind_result($existingUsername, $existingEmail);
            while ($check_query->fetch()) {
                if ($existingUsername == $username) {
                    $local_error['username'] = "Such username already exists";
                    setErrorSession($local_error, $main_error);
                    header('Location:' . REGISTRATION_URL);
                }
                if ($existingEmail == $email) {
                    $local_error['email'] = "Such email already exists";
                    setErrorSession($local_error, $main_error);
                    header('Location:' . REGISTRATION_URL);
                }
            }

            if (empty($local_error)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $create_user_query = $connect->prepare("INSERT INTO `Users` (`name`, `surname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
                $create_user_query->bind_param("sssss", $name, $surname, $username, $email, $hashed_password);

                if ($create_user_query->execute()) {
                    include_once 'auth_user.php';
                } else {
                    $main_error['connect_error'] = $connect->error;
                    setErrorSession($local_error, $main_error);
                    header('Location:' . REGISTRATION_URL);
                }

                $create_user_query->close();
            }

            $check_query->close();
            $connect->close();
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                header('Location:' . REGISTRATION_URL);
                $connect->close();
                exit();
            }
            header('Location:' . REGISTRATION_URL);
            $connect->close();
            exit();
        }
    }
}

function AuthUser($username, $password, $submittedCSRF)
{
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {

        $mistakes = validateLogin(
            $username,
            $password,
        );

        if (empty($mistakes)) {
            $connect = connectToDatabase();
            include_once 'auth_user.php';
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            }
        }
    }
}

function UpdateUserData($new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {

        $new_name = $_POST['name'];
        $new_surname = $_POST['surname'];
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_address = $_POST['address'];
        $new_city = $_POST['city'];
        $new_postcode = $_POST['postcode'];
        $new_country = $_POST['country'];

        $new_data = [$new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country];

        $session_id = $_SESSION['id'];
        $session_name = $_SESSION['name'];
        $session_surname = $_SESSION['surname'];
        $session_username = $_SESSION['username'];
        $session_email = $_SESSION['email'];
        $session_address = $_SESSION['address'];
        $session_city = $_SESSION['city'];
        $session_postcode = $_SESSION['postcode'];
        $session_country = $_SESSION['country'];

        $session_data = [$session_name, $session_surname, $session_username, $session_email, $session_address, $session_city, $session_postcode, $session_country];

        $differences = array_diff_assoc($new_data, $session_data);

        if (empty($differences)) {
            $main_error['no_changes'] = 'There were no changes';
            setErrorSession($local_error, $main_error);
            header('Location:' . PROFILE_URL);
            exit();
        } else {


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
                $connect = connectToDatabase();
                if ($new_email != $session_email) {
                    $check_email = $connect->prepare("SELECT `email` FROM Users WHERE email=?");
                    $check_email->bind_param("s", $new_email);
                    $check_email->execute();
                    $check_email->store_result();

                    $check_email->bind_result($existingEmail);
                    $check_email->fetch();
                    if ($existingEmail == $new_email) {
                        $local_error['email'] = "Such email already exists";
                        setErrorSession($local_error, $main_error);
                        header('Location:' . PROFILE_URL);
                        exit();
                    }
                }

                if ($new_username != $session_username) {
                    $check_username = $connect->prepare("SELECT `username` FROM Users WHERE username=?");
                    $check_username->bind_param("s", $new_username,);
                    $check_username->execute();
                    $check_username->store_result();
                    $check_username->bind_result($existingUsername);
                    $check_username->fetch();
                    if ($existingUsername == $new_username) {
                        $local_error['username'] = "Such username already exists";
                        setErrorSession($local_error, $main_error);
                        header('Location:' . PROFILE_URL);
                        exit();
                    }
                }

                if (empty($local_error)) {
                    $sql = "UPDATE Users SET name=?, surname=?, username=?, email=?,  address=?, city=?, postcode=?, country=? WHERE id=?";
                    $update_data = $connect->prepare($sql);
                    $update_data->bind_param("ssssssssi", $new_name, $new_surname, $new_username, $new_email, $new_address, $new_city, $new_postcode, $new_country, $session_id);
                    $update_data->execute();

                    $_SESSION['name'] = $new_name;
                    $_SESSION['surname'] = $new_surname;
                    $_SESSION['username'] = $new_username;
                    $_SESSION['email'] = $new_email;
                    $_SESSION['address'] = $new_address;
                    $_SESSION['city'] = $new_city;
                    $_SESSION['postcode'] = $new_postcode;
                    $_SESSION['country'] = $new_country;

                    $main_success['success_change_data'] = 'The data has been reset';
                    setErrorSession($local_error, $main_error);
                    $_SESSION['main_success'] = $main_success;
                    header('Location:' . PROFILE_URL);
                    $connect->close();
                    exit();
                } else {
                    foreach ($mistakes as $key => $value) {
                        $local_error[$key] = $value;
                        setErrorSession($local_error, $main_error);
                        header('Location:' . PROFILE_URL);
                        $connect->close();
                        exit();
                    }
                }
            } else {
                foreach ($mistakes as $key => $value) {
                    $main_error[$key] = $value;
                    setErrorSession($local_error, $main_error);
                    header('Location:' . PROFILE_URL);
                    exit();
                }
            }
        }
    }
}

function UpdateUserPassword($new_password, $new_password_again, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {

        if (password_verify($new_password, $_SESSION['password'])) {
            $main_error['error_change_password'] = 'This is password not new';
            setErrorSession($local_error, $main_error);
            header('Location:' . PROFILE_URL);
            exit();
        }

        $session_password = $_SESSION['password'];

        if (empty($main_error)) {
            include 'validate/password_form_validate.php';

            $mistakes = validatePassword(
                $new_password,
                $new_password_again
            );

            if (empty($mistakes)) {
                $connect = connectToDatabase();
                $session_id = $_SESSION['id'];
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
                $update_password->bind_param("si", $hashed_new_password, $session_id);
                $update_password->execute();

                $_SESSION['password'] = $hashed_new_password;

                $main_success['success_change_password'] = 'Your password has been changed';
                $_SESSION['main_success'] = $main_success;
                header('Location:' . PROFILE_URL);
                $connect->close();
                exit();
            } else {
                foreach ($mistakes as $key => $value) {
                    $main_error[$key] = $value;
                    setErrorSession($local_error, $main_error);
                    header('Location:' . PROFILE_URL);
                    $connect->close();
                    exit();
                }
            }
        }
    }
}

function AddProduct($productName, $productImg, $productDescription, $productPrice, $productCategory, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validateProduct($productName, $productPrice, $productCategory);

        if (empty($mistakes)) {

            $productImgDir = BASE_DIR . "image/products/";
            // Создание уникального имени файла
            $productImgFile = $productImgDir . basename($productImg['name']);
            // Перемещение загруженного файла в указанную папку
            if (move_uploaded_file($productImg['tmp_name'], $productImgFile)) {
                $connect = connectToDatabase();

                // Используйте подготовленный запрос
                $sql_write = "INSERT INTO Products (name, photo_path,discription, price, id_category)
                          VALUES (?, ?, ?, ?, ?)";

                $stmt = $connect->prepare($sql_write);
                $stmt->bind_param("sssii", $productName, $productImgFile, $productDescription, $productPrice, $productCategory);

                // Выполнение подготовленного запроса
                if ($stmt->execute()) {
                    $main_success['success_writting_file'] = 'The product has been added';
                    setErrorSession($local_error, $main_error);
                    header('Location:' . ADD_PRODUCT);
                    $stmt->close();
                    $connect->close();
                    exit();
                } else {
                    // Обработка ошибки
                    $main_error['erroe_stmt'] = 'Error adding the file';
                    setErrorSession($local_error, $main_error);
                    header('Location:' . ADD_PRODUCT);
                    $stmt->close();
                    $connect->close();
                    exit();
                }
                $stmt->close();
            } else {
                $main_erro['write_error'] = 'Error writing the file';
                setErrorSession($local_error, $main_error);
                header('Location:' . ADD_PRODUCT);
                exit();
            }
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                header('Location:' . ADD_PRODUCT);
                exit();
            }
        }
    }
}


function postWhat($POST, $FILES)
{
    
    if (isset($POST['authorization_user'])) {
        AuthUser($POST['username'], $_POST['password'], $POST['csrf_token']);
    }
    if (isset($POST['registration_user'])) {
        RegistrationUser($POST['name'], $POST['surname'], $POST['username'], $POST['email'], $POST['password'], $POST['password2'], $POST['csrf_token']);
    }
    if (isset($POST['update_user_password'])) {
        if ($_SESSION['id'])
            UpdateUserPassword($POST['password'], $POST['password2'], $POST['csrf_token']);
        else {
            Not_Found();
        }
    }
    if (isset($POST['update_user_data'])) {
        if ($_SESSION['id'])
            UpdateUserData($POST['name'], $POST['surname'], $POST['username'], $POST['email'], $POST['address'], $POST['city'], $POST['postcode'], $POST['country'], $POST['csrf_token']);
        else {
            Not_Found();
        }
    }
    if (isset($POST['add_product'])) {
        if ($_SESSION['isAdmin'])
        AddProduct($POST['productName'], $FILES['productImg'], $POST['productDescription'], $POST['productPrice'], $POST['productCategory'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    reverseUrl();
}
