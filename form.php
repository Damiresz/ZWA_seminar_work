<?php

function validate ($name, $code, $price) {
    $to_return = array();
    $name = trim($name);
    if ($name === "" ) {
        // name je spatne a vracim false
        $to_return['nazev'] = "Nazev musi byt vyplnen!"; 
    }

    $code = trim ($code);
    if ($code === "") {
        // mame spatne kod
        $to_return['kod'] = "Kod je povinna polozka!";
    }

    $code_cislo = (int)$code;
    if ($code_cislo >= 1000 && $code_cislo <= 9999) {
        // ok, kod je v poradku
    } else {
        // kod ma spatny rozsah cisla
        $to_return['kod'] = "Kod musi byt v intervalu 1000 do 9999";
    }

    // cena stejne jako kod
    return $to_return;
}

// prvni zobrazeni?
if (isset($_POST['odeslat'])) {
   // prave zpracovavam odeslani dat
   $pole_chyb = validate($_POST['nazev'],$_POST['kod'], $_POST['cena']);
   if (sizeof($pole_chyb) == 0) {
    // vse je ok, muzu prejit na stranku podekovani
    header('Location: dekujeme.php');
    exit();
   } else {
    // co udelame, kdyz validace neprosla
    // ...nic
   } 
} else {
 // prni zobrazeni, zada data nemam
  // nebudu delat nic
}


?>
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
</html>


<!--<input type="text" name="nazev" value="aaaa"> <script> alert("ahoj"); </script>&#039; &quot; x"><br>-->