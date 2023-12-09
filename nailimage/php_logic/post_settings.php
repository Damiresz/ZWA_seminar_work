<?php
include_once 'connect_db.php';
include_once 'get_data.php';
include_once 'validate/validate.php';
include_once 'func.php';


function AuthUser($username, $password)
{
    $local_error = array();
    $connect = connectToDatabase();
    $sql_user = "SELECT * FROM Users WHERE `username` = ?";
    $stmt = $connect->prepare($sql_user);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userData = $stmt->get_result();

    if ($userData && $userData->num_rows > 0) {
        $userData = $userData->fetch_assoc();
        if (password_verify($password, $userData['password'])) {
            setSessionSuccess($userData);
            header('Location:' . BASE_DIR_URL);
            exit();
        } else {
            $userData = array();
            $main_error['login_main_error'] = 'Incorrect password';
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    } else {
        $userData = array();
        $main_error['login_main_error'] = 'User is not registrated';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    }
}

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
                    reverseUrl();
                }
                if ($existingEmail == $email) {
                    $local_error['email'] = "Such email already exists";
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
            }

            if (empty($local_error)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $create_user_query = $connect->prepare("INSERT INTO `Users` (`name`, `surname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
                $create_user_query->bind_param("sssss", $name, $surname, $username, $email, $hashed_password);

                if ($create_user_query->execute()) {
                    AuthUser($username, $password);
                } else {
                    $main_error['connect_error'] = $connect->error;
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }

                $create_user_query->close();
            }

            $check_query->close();
            $connect->close();
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        }
    }
}

function LoginUser($username, $password, $submittedCSRF)
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
            AuthUser($username, $password);
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
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
            reverseUrl();
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
                        reverseUrl();
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
                        reverseUrl();
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
                    $connect->close();
                    reverseUrl();
                } else {
                    foreach ($mistakes as $key => $value) {
                        $local_error[$key] = $value;
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
}

function UpdateUserPassword($new_password, $new_password_again, $submittedCSRF, $adminMode, $username = null)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validatePassword(
            $new_password,
            $new_password_again
        );

        if (empty($mistakes)) {
            $session_id = $_SESSION['id'];
            $connect = connectToDatabase();
            if (!$adminMode) {
                $check_password = $connect->prepare("SELECT password FROM Users WHERE id=?");
                $check_password->bind_param("i", $session_id);
                $check_password->execute();
                $check_password->bind_result($hashed_password);
                $check_password->fetch();
                $check_password->close();
                
                if (password_verify($new_password, $hashed_password)) {
                    $main_error['error_change_password'] = 'This is the current password';
                    setErrorSession($local_error, $main_error);
                    reverseUrl();
                }
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
                $update_password->bind_param("si", $hashed_new_password, $session_id);
                $update_password->execute();

                $main_success['success_change_password'] = 'Your password has been changed';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            } 
            elseif ($adminMode === true) {
                $user_data = $connect->prepare("SELECT * FROM Users WHERE username=?");
                $user_data->bind_param("s", $username);
                $user_data->execute();
                $result_user_data = $user_data->get_result();

                if ($result_user_data->num_rows > 0) {
                    $user = $result_user_data->fetch_assoc();
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
                    $update_password->bind_param("si", $hashed_new_password, $user['id']);
                    $update_password->execute();
                    $main_success['success_change_password'] = 'Your password has been changed';
                    $_SESSION['main_success'] = $main_success;
                    $user_data->close();
                    $connect->close();
                    reverseUrl();
                } else {
                    $main_error['error'] = 'User is no exist';
                    setErrorSession($local_error, $main_error);
                    $user_data->close();
                    $connect->close();
                    reverseUrl();
                }
            }
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                setErrorSession($local_error, $main_error);
            }
        }
    }
}



function AddProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validateProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory);

        if (empty($mistakes)) {

            $productImgUrl = filter_var($productImgUrl, FILTER_SANITIZE_URL);

            // Проверяем наличие файла на сервере
            if (file_exists($productImgUrl)) {
                $date_creation = date("Y-m-d H:i:s");
                $connect = connectToDatabase();

                // Используйте подготовленный запрос
                $sql_write = "INSERT INTO Products (name, photo_path,discription, price, date_creation, category_id)
                          VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $connect->prepare($sql_write);
                $stmt->bind_param("sssisi", $productName, $productImgUrl, $productDiscription, $productPrice, $date_creation, $productCategory);

                // Выполнение подготовленного запроса
                if ($stmt->execute()) {
                    $main_success['success_writting_file'] = 'The product has been added';
                    $_SESSION['main_success'] = $main_success;
                    setErrorSession($local_error, $main_error);
                    $stmt->close();
                    $connect->close();
                    header('Location:' . PRODUCT_SETTINGS_URL);
                    exit;
                } else {
                    // Обработка ошибки
                    $main_error['erroe_stmt'] = 'Error adding the file';
                    setErrorSession($local_error, $main_error);
                    $stmt->close();
                    $connect->close();
                    reverseUrl();
                }
                $stmt->close();
            } else {
                $main_error['write_error'] = 'Error writing the file';
                setErrorSession($local_error, $main_error);
                reverseUrl();
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


function ModifyProduct($product_id, $productName, $productImgUrl, $productDiscription, $productPrice, $productCategory, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();

    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['csrf_error'] = 'Error CSRF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        $mistakes = validateProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory);

        if (empty($mistakes)) {
            $connect = connectToDatabase();

            // Проверяем, изменились ли данные перед выполнением запроса UPDATE
            $check_changes_query = $connect->prepare("SELECT name, photo_path, discription, price, category_id FROM Products WHERE id = ?");
            $check_changes_query->bind_param("i", $product_id);
            $check_changes_query->execute();
            $check_changes_query->store_result();

            if ($check_changes_query->num_rows > 0) {
                $check_changes_query->bind_result($existingName, $existingImgUrl, $existingDescription, $existingPrice, $existingCategory);

                if ($check_changes_query->fetch()) {
                    if ($existingName == $productName && $existingImgUrl == $productImgUrl && $existingDescription == $productDiscription && $existingPrice == $productPrice && $existingCategory == $productCategory) {
                        // Данные не изменились, возвращаем сообщение об успешном обновлении
                        $main_success['success_message'] = 'No changes were made';
                        $_SESSION['main_success'] = $main_success;
                        $connect->close();
                        header('Location:' . PRODUCT_SETTINGS_URL);
                        exit;
                    }
                }
            }

            // Продолжаем с обновлением данных продукта в базе данных
            $update_product = $connect->prepare("UPDATE Products SET name = ?, photo_path = ?, discription = ?, price = ?, category_id = ? WHERE id = ?");
            $update_product->bind_param("sssdii", $productName, $productImgUrl, $productDiscription, $productPrice, $productCategory, $product_id);

            if ($update_product->execute() === false) {
                $local_error['update_error'] = 'Error updating product';
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            } else {
                $main_success['success_message'] = 'Product updated successfully';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                header('Location:' . PRODUCT_SETTINGS_URL);
                exit;
            }
        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
            }
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    }
}



function DeleteProduct($product_id, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        if (isset($product_id)) {
            $connect = connectToDatabase();
            $sql_del = "DELETE FROM Products WHERE id = $product_id";
            if ($connect->query($sql_del) === TRUE) {
                $main_success['success_delete'] = 'The product deleted';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            }
            $connect->close();
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

function ChangeCategory($categoryName_new, $categoryName_old, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();

    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['csrf_error'] = 'Error CSRF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        if ($categoryName_old == $categoryName_new) {
            $main_success['success_category'] = 'There were no change';
            $_SESSION['main_success'] = $main_success;
            header('Location:' . CATEGORY_SETTINGS_URL);
            exit;
        }

        $mistakes = validateCategory($categoryName_new);

        if (empty($mistakes)) {
            $connect = connectToDatabase();
            $check_category = $connect->prepare("SELECT name_category FROM Categories WHERE name_category = ?");
            $check_category->bind_param("s", $categoryName_old);
            $check_category->execute();
            $check_category->store_result();

            if ($check_category->num_rows == 0) {
                $main_error['category_error'] = "You are trying to change a non-existent category";
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }

            $check_category->bind_result($category_db);

            if ($check_category->fetch()) {
                $update_data = $connect->prepare("UPDATE Categories SET name_category=? WHERE name_category=?");
                $update_data->bind_param("ss", $categoryName_new, $categoryName_old);

                if ($update_data->execute()) {
                    $main_success['success_add_category'] = 'The category has been changed';
                    $_SESSION['main_success'] = $main_success;
                    $connect->close();
                    header('Location:' . CATEGORY_SETTINGS_URL);
                    exit;
                } else {
                    $main_error['execute_error'] = 'Execute error';
                    setErrorSession($local_error, $main_error);
                    $connect->close();
                    reverseUrl();
                }
            } else {
                $main_error['category_error'] = "Error fetching category details";
                setErrorSession($local_error, $main_error);
                reverseUrl();
            }
        } else {
            foreach ($mistakes as $key => $value) {
                $local_error[$key] = $value;
            }
            setErrorSession($local_error, $main_error);
            reverseUrl();
        }
    }
}


function DeleteCategory($category_id, $submittedCSRF)
{
    $main_success = array();
    $local_error = array();
    $main_error = array();
    if (!verifyCSRFToken($submittedCSRF)) {
        $main_error['crsf_error'] = 'Error CRSF token';
        setErrorSession($local_error, $main_error);
        reverseUrl();
    } else {
        if (isset($category_id)) {
            $connect = connectToDatabase();
            $products = getProducts(null, null, $category_id);
            if (count($products) > 0) {
                $main_error['error_delete'] = 'You cannot delete a category that contains products';
                setErrorSession($local_error, $main_error);
                $connect->close();
                reverseUrl();
            }
            $sql_del = "DELETE FROM Categories WHERE id_category = $category_id";
            if ($connect->query($sql_del) === TRUE) {
                $main_success['success_delete'] = 'The category deleted';
                $_SESSION['main_success'] = $main_success;
                $connect->close();
                reverseUrl();
            }
            $connect->close();
        }
    }
}




function postWhat($POST)
{
    if (isset($POST['authorization_user'])) {
        LoginUser($POST['username'], $_POST['password'], $POST['csrf_token']);
    }
    if (isset($POST['registration_user'])) {
        RegistrationUser($POST['name'], $POST['surname'], $POST['username'], $POST['email'], $POST['password'], $POST['password2'], $POST['csrf_token']);
    }
    if (isset($POST['update_user_password'])) {
        if ($_SESSION['id'])
            UpdateUserPassword($POST['password'], $POST['password2'], $POST['csrf_token'], false);
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
    if (isset($POST['users_settings'])) {
        if ($_SESSION['isAdmin'] == 1)
            UpdateUserPassword($POST['password'], $POST['password2'], $POST['csrf_token'], true, $POST['username']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['add_product'])) {
        if ($_SESSION['isAdmin'] == 1)
            AddProduct($POST['productName'], $POST['productImgUrl'], $POST['productDiscription'], $POST['productPrice'], $POST['productCategory'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['modify_product'])) {
        if ($_SESSION['isAdmin'] == 1)
            ModifyProduct($POST['productId'], $POST['productName'], $POST['productImgUrl'], $POST['productDiscription'], $POST['productPrice'], $POST['productCategory'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['delete_product'])) {
        if ($_SESSION['isAdmin'] == 1)
            DeleteProduct($POST['product_id'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['add_category'])) {
        if ($_SESSION['isAdmin'] == 1)
            AddCategory($POST['categoryName'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['change_category'])) {
        if ($_SESSION['isAdmin'] == 1)
            ChangeCategory($POST['categoryName'], $POST['categoryName_old'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    if (isset($POST['delete_category'])) {
        if ($_SESSION['isAdmin'] == 1)
            DeleteCategory($POST['category_id'], $POST['csrf_token']);
        else {
            reverseUrl();
        }
    }
    reverseUrl();
}
