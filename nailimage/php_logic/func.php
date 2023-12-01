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

   