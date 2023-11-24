<?php

function isValidUsername($element) {
    $regex = '/^[a-z0-9]{3,10}$/';
    return preg_match($regex, $element);
}

function isValidEmail($element) {
    $regex = '/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/';
    return preg_match($regex, $element);
}
function isValidPwd($element) {
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/';
    return preg_match($regex, $element);
}

function validate ($name, $surname, $username, $email, $password, $password2) {
    $mistake = array();
    // Name
    $name = trim($name);
    if ($name === "" ) {
        $mistake['name'] = "Entity cannot be empty"; 
    }

    if (mb_strlen($name) < 2) {
        $mistake['name'] = "Entity cannot be shorter than 2 characters";
    }

    if (mb_strlen($name) > 14) {
        $mistake['name'] = "Entity cannot be longer than 14 characters";
    }

    // Surname
    $surname = trim ($surname);
    if ($surname === "") {
        $mistake['surname'] = "Entity cannot be empty";
    }

    if (mb_strlen($surname) < 2) {
        $mistake['surname'] = "Entity cannot be shorter than 2 characters";
    }

    if (mb_strlen($surname) > 14) {
        $mistake['surname'] = "Entity cannot be longer than 14 characters";
    }

    // Username
    $username = trim ($username);
    if ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    }

    if (mb_strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    }

    if (mb_strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    if (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    // Email
    $email = trim ($email);
    if ($email === "") {
        $mistake['email'] = "Entity cannot be empty";
    }

    if (!isValidEmail($email)) {
        $mistake['email'] = "Incorrectly entered data";
    }

    // Pwd
    $password = trim ($password);
    if ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    }

    if (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    // Pwd2
    $password2 = trim ($password2);
    if ($password2 === "") {
        $mistake['password2'] = "Entity cannot be empty";
    }

    if (!isValidPwd($password2)) {
        $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    if ($password !== $password2) {
        $mistake['password2'] = "Passwords don't match";
    }

    return $mistake;
}
    
if (isset($_POST['submit'])) {
    // prave zpracovavam odeslani dat
    $mistakes = validate($_POST['name'],$_POST['surname'],$_POST['username'],$_POST['email'],$_POST['password'],$_POST['password2']);
        if (sizeof($mistakes) == 0) {
         // vse je ok, muzu prejit na stranku podekovani
         header('Location: index.php');
         exit();
        } else {
         // co udelame, kdyz validace neprosla
         // ...nic
        } 
     } else {
      // prni zobrazeni, zada data nemam
       // nebudu delat nic
     }




//     $code_cislo = (int)$code;
//     if ($code_cislo >= 1000 && $code_cislo <= 9999) {
//         // ok, kod je v poradku
//     } else {
//         // kod ma spatny rozsah cisla
//         $to_return['kod'] = "Kod musi byt v intervalu 1000 do 9999";
//     }

//     // cena stejne jako kod
//     return $to_return;
// }

// prvni zobrazeni?
// if (isset($_POST['odeslat'])) {
//    // prave zpracovavam odeslani dat
//    $pole_chyb = validate($_POST['nazev'],$_POST['kod'], $_POST['cena']);
//    if (sizeof($pole_chyb) == 0) {
//     // vse je ok, muzu prejit na stranku podekovani
//     header('Location: dekujeme.php');
//     exit();
//    } else {
//     // co udelame, kdyz validace neprosla
//     // ...nic
//    } 
// } else {
//  // prni zobrazeni, zada data nemam
//   // nebudu delat nic
// }


?>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    foreach ($pole_chyb as $chyba) {
        echo htmlspecialchars($chyba)."<br>";

    }
    ?>
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   <input type="text" name="nazev" value="<?php 
    if (isset($_POST['nazev'])) {
        echo htmlspecialchars($_POST['nazev']);
        } 
    ?>"><br>
    <input type="text" name="kod" value=""><br>
    <input type="text" name="cena" value=""><br>
    <input type="submit" name="odeslat" value="OK">
    </form>


</body>
</html> -->


<!--<input type="text" name="nazev" value="aaaa"> <script> alert("ahoj"); </script>&#039; &quot; x"><br>-->