<?php
function setSessionSuccess($userData) {
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
      $_SESSION['password'] = $userData['password'];
   }

   function setErrorSession ($local_error,$main_error) {
      $_SESSION['postData'] = $_POST;
      $_SESSION['main_error'] = $main_error;
      $_SESSION['local_error'] = $local_error;
   }

   function removeErrorSession () {
      unset($_SESSION['postData']);
      unset($_SESSION['main_error']);
      unset($_SESSION['local_error']);
      unset($_SESSION['main_success']);
   }

   function reverseUrl () {
      $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
      if($referrer){
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
      $directoryPath = BASE_DIR.'image/products/';
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
   

   

   