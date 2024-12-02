<?php
 
namespace ExpenseTracker\Controllers;
use ExpenseTracker\Models\UserModel;

class UserController{
  private $User;
  public function __construct(){
    $this->User = new UserModel();
  }
  public function registerUser(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $name = trim($_POST["name"]);
      $email = trim($_POST["email"]);
      $password = trim($_POST["password"]);
      if(empty($name) || empty($email) || empty($password)){
        $error = "All fields are required";
        exit();
      }
      $response = $this->User->registerUserDB($name, $email, $password);
      if($response["status"]){
        session_start();
        $_SESSION['user'] = $response['user'];
        $_SESSION['message'] = $response['message'];
        header("Location: /");
        exit();
      }else{
        $error = $response['message'];
        include __DIR__ . "/../Views/signup.php";
      }
    }
    else{
      include_once __DIR__.'/../Views/signup.php';
    }
  }
  public function loginUser(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $email = trim($_POST["email"]);
      $password = trim($_POST["password"]);
      if(empty($email) || empty($password)){
        $error = "All fields are required";
        exit();
      }
      $response = $this->User->loginUserDB($email, $password);
      if($response["status"]){
        session_start();
        $_SESSION['user'] = $response['user'];
        $_SESSION['message'] = $response['message'];
        header("Location: /");
        exit();
      }else{
        $error = $response['message'];
        include __DIR__ . "/../Views/login.php";
      }
    }
    else{
      include_once __DIR__.'/../Views/login.php';
    }
  }

  public function logoutUser(){
    session_start();
    session_destroy();
    header("Location: /");
    exit();
  }
}