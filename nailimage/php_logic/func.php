<?php
function setSessionSuccess($userData = null)
{
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

function setErrorSession($local_error = null, $main_error = null)
{
   $_SESSION['postData'] = $_POST;
   $_SESSION['main_error'] = $main_error;
   $_SESSION['local_error'] = $local_error;
}

function removeErrorSession()
{
   unset($_SESSION['postData']);
   unset($_SESSION['main_error']);
   unset($_SESSION['local_error']);
   unset($_SESSION['main_success']);
}

function reverseUrl()
{
   $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
   if ($referrer) {
      header('Location:' . $referrer);
      exit;
   } else {
      Not_Found();
   }
}

function checkAndDeleteFiles()
{
   require_once 'connect_db.php';
   $connect = connectToDatabase();

   // Получаем все записи о файлах из базы данных
   $sql = "SELECT photo_path FROM Products";
   $photos_path_db = $connect->query($sql);

   // Инициализируем массив для хранения путей из базы данных
   $photos_path = array();

   if ($photos_path_db->num_rows > 0) {
      while ($photo_path = $photos_path_db->fetch_assoc()) {
         $photos_path[] = $photo_path['photo_path'];
      }
   }

   // Директория, где хранятся файлы
   $directoryPath = BASE_DIR . 'image/products/';
   $filesInDirectory = array_diff(scandir($directoryPath), array('..', '.'));

   // Сравниваем каждый файл в директории с путями из базы данных
   foreach ($filesInDirectory as $file) {
      $filePath = $directoryPath . $file;

      if (!in_array($filePath, $photos_path)) {
         unlink($filePath);
      }
   }

   // Закрытие соединения с базой данных
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

   return $uri;
}



function getCurrentPage($uri)
{
   preg_match("/page\/(\d+)/", $uri, $matches);

   // Если найдено совпадение, передаем значение в $_GET['page']
   if (!empty($matches[1])) {
      $_GET['page'] = $matches[1];
   }

   return $matches;
}

function getCurrenCategotyPage($uri)
{
   preg_match("/category\/(\w+(?:-\w+)?)/", $uri, $matches);

   // Если найдено совпадение, передаем значение в $_GET['page']
   if (!empty($matches[1])) {
      $_GET['get_category'] = $matches[1];
   }

   return $matches;
}

function getCurrenProduct($uri)
{
   preg_match("/product=(\d+)/", $uri, $matches);

   // Если найдено совпадение, передаем значение в $_GET['page']
   if (!empty($matches[1])) {
      $_GET['get_product'] = $matches[1];
   }

   return $matches;
}
