<?php

if (isset($_POST['registration_user'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    include 'validate/registration_form_validate.php';

    $mistakes = validate(
        $name,
        $surname,
        $username,
        $email,
        $password,
        $password2
    );

    if (empty($mistakes)) {
        $local_error = array();
        $main_error = array();
        include 'connect_db.php';

        //   
        $check_query = $connect->prepare("SELECT `username`, `email` FROM Users WHERE username=? OR email=?");
        $check_query->bind_param("ss", $username, $email);
        $check_query->execute();
        $check_query->store_result();

        $check_query->bind_result($existingUsername, $existingEmail);
        while ($check_query->fetch()) {
            if ($existingUsername == $username) {
                $local_error['username_exist'] = "Such username already exists";
                header('Location:'. $_SERVER['PHP_SELF']);
            }
            if ($existingEmail == $email) {
                $local_error['email_exist'] = "Such email already exists";
                header('Location:'. $_SERVER['PHP_SELF']);
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
                header('Location:'. $_SERVER['PHP_SELF']);
            }

            $create_user_query->close();
        }

        $check_query->close();
        $connect->close();
    } else {
        foreach ($mistakes as $key => $value) {
            $main_error[$key] = $value;
    }
        header('Location:'. $_SERVER['PHP_SELF']);
    }
}





if (isset($_POST['authorization_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    include 'validate/login_form_validate.php';

    $mistakes = validate(
        $username,
        $password,
    );

    if (empty($mistakes)) {
        $local_error = array();
        $main_error = array();
        include 'connect_db.php';
        include_once 'auth_user.php';
    } else {
        foreach ($mistakes as $key => $value) {
            $main_error[$key] = $value;
        }
        header('Location:'. $_SERVER['PHP_SELF']);
    }
}





if (isset($_POST['update_user_data'])) {

    $local_error = array();
    $main_error = array();
    $main_success = array();
    
    $new_name = $_POST['name'];
    $new_surname = $_POST['surname'];
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_city = $_POST['city'];
    $new_postcode = $_POST['postcode'];
    $new_country = $_POST['country'];

    $new_data = [$new_name,$new_surname,$new_username,$new_email,$new_address,$new_city,$new_postcode,$new_country ];

    $session_id = $_SESSION['id'];
    $session_name = $_SESSION['name'];
    $session_surname = $_SESSION['surname'];
    $session_username = $_SESSION['username'];
    $session_email = $_SESSION['email'];
    $session_address = $_SESSION['address'];
    $session_city = $_SESSION['city'];
    $session_postcode = $_SESSION['postcode'];
    $session_country = $_SESSION['country'];

    $session_data = [$session_name,$session_surname,$session_username,$session_email,$session_address,$session_city,$session_postcode,$session_country];

    $differences = array_diff_assoc($new_data, $session_data);

    if (empty($differences)) {
            $main_error['no_changes'] = 'There were no changes';
    } else {

        include 'validate/profile_form_validate.php';

        $mistakes = validate(
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
        include 'connect_db.php';

        if ($new_email != $session_email) {
            $check_email = $connect->prepare("SELECT `email` FROM Users WHERE email=?");
            $check_email->bind_param("s", $new_email);
            $check_email->execute();
            $check_email->store_result();

            $check_email->bind_result($existingEmail);
            $check_email->fetch();
                if ($existingEmail == $new_email) {
                    $local_error['email'] = "Such email already exists";
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
            }
        }

        if(empty($local_error)) {
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
        } else {

        }

        } else {
            foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
                }
            }


        
        
    }
    
}





if (isset($_POST['update_user_password'])) {

    $local_error = array();
    $main_error = array();
    $main_success = array();
    
    $new_password = $_POST['password'];
    $new_password_again = $_POST['password2'];

    if (password_verify($new_password, $_SESSION['password'])) {
        $main_error['error_change_password'] = 'This is password not new';
    }

    $session_password = $_SESSION['password'];
    
    if (empty($main_error)) {
        include 'validate/password_form_validate.php';

        $mistakes = validate(
            $new_password, $new_password_again
    );

    if (empty($mistakes)) {
        include 'connect_db.php';
        $session_id = $_SESSION['id'];
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_password = $connect->prepare("UPDATE Users SET password=? WHERE id=?");
        $update_password->bind_param("si", $hashed_new_password, $session_id);
        $update_password->execute();
        
        $_SESSION['password'] = $hashed_new_password;
    
        $main_success['success_change_password'] = 'Your password has been changed';

    } else {
        foreach ($mistakes as $key => $value) {
                $main_error[$key] = $value;
        }
    }

    }
    
}
