<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists('../vendor/autoload.php')) {
  require_once '../vendor/autoload.php';
} else {
  echo "Autoload file not found!";
  exit;
}

use Dotenv\Dotenv;
use ExpenseTracker\Controllers\UserController;
use ExpenseTracker\Controllers\ExpenseController;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$userController = new UserController();
$expenseController = new ExpenseController();

switch ($requestUri) {
  case '/':
    include_once __DIR__.'/../src/Views/home.php';
    break;
  case '/login':
    $userController->loginUser();
    break;
  case '/signup':
    $userController->registerUser();
    break;
  case '/api/expenses/all':
    if($method === 'GET') {
      $expenseController->getAllExpenses();
    }
    break;
  case '/api/expenses':
    if($method === 'POST') {
      $expenseController->addExpense();
    }
    else if($method === 'PUT') {
      $expenseController->editExpense();
    }
    break;
  case '/api/expenses/delete':
    if($method === 'POST') {
      $expenseController->removeExpense();
    }
    break;
  case "/logout":
    $userController->logoutUser();
    break;
  default:
    require_once __DIR__.'/../src/Views/404.php';
    break;
}