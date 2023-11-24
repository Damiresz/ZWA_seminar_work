<?php

  function validate ($name, $code, $price) {
    $to_return = array();

    $name = trim($name);
    if ($name === "") {
      $to_return[$name] = "Opravte jmeno";
    }

    $code = trim($code);
    if ($code === "") {
      return false;
    }

    $code_number = (int)$code;
    if ($code_number >= 1000 && $code_number <= 9999) {
      return true;
    } else {
      return false;
    }

    $price = trim($price);
    if ($price === "") {
      return false;
    }
  }


  if($_SERVER["REQUEST_METHOD"] == "GET") {
    echo file_get_contents("test.php");
  } else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (validate($_POST['name'],$_POST['code'],$_POST['price'])) {

    } else {
      header("Location: index.php");
      exit();
    }
  } else {

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

<form action="<?php echo $_SERVER(PHP_SELF)?>" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php if (isset($_POST['name'])) { echo htmlspecialchars($_POST['name']); }?>"><br>
    <label for="code">Code:</label>
    <input type="text" id="code" name="code" value="<?php ?>"><br>
    <label for="price">Name:</label>
    <input type="text" id="price" name="price" value="<?php ?>"><br>
    <input type="submit" value="OK">
</form>

</body>
</html>