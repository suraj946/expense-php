<?php
namespace ExpenseTracker\Controllers;
require_once __DIR__ . '/../Middlewares/auth.php';
use ExpenseTracker\Models\ExpenseModel;
use Exception;

class ExpenseController {
  private $Expense;

  public function __construct() {
    $this->Expense = new ExpenseModel();
  }

  public function addExpense() {
    header('Content-Type: application/json');
    $userId = userMiddleware()['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    if(!isset($data['amount']) || !isset($data['description']) || !isset($data['category'])) {
      http_response_code(400);
      echo json_encode(["message" => "Missing required fields", "success" => false]);
      exit();
    }
    $amount = $data['amount'];
    $description = $data['description'];
    $category = $data['category'];
    $response = $this->Expense->createExpense($userId, $amount, $description, $category);
    if ($response['status']) {
      http_response_code(201);
      echo json_encode(["message" => "Expense created successfully", "success" => true, "data" => $response['data']]);
    } else {
      http_response_code(500);
      echo json_encode(["message" => $response['message'], "success" => false]);
    }
  }

  public function editExpense() {
    header('Content-Type: application/json');
    $userId = userMiddleware()['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    if(!isset($data['expenseId']) || !isset($data['amount']) || !isset($data['description']) || !isset($data['category'])) {
      http_response_code(400);
      echo json_encode(["message" => "Missing required fields", "success" => false]);
      exit();
    }
    $expenseId = $data['expenseId'];
    $amount = $data['amount'];
    $description = $data['description'];
    $category = $data['category'];
    $response = $this->Expense->updateExpense($expenseId, $amount, $description, $category);
    if ($response['status']) {
      http_response_code(200);
      echo json_encode(["message" => "Expense updated successfully", "success" => true]);
    } else {
      http_response_code(500);
      echo json_encode(["message" => $response['message'], "success" => false]);
    }
  }

  public function removeExpense() {
    header('Content-Type: application/json');
    $userId = userMiddleware()['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    if(!isset($data['expenseId'])) {
      http_response_code(400);
      echo json_encode(["message" => "Missing required fields", "success" => false]);
      exit();
    }
    $expenseId = $data['expenseId'];
    $response = $this->Expense->deleteExpense($expenseId);
    if ($response['status']) {
      http_response_code(200);
      echo json_encode(["message" => "Expense deleted successfully", "success" => true]);
    } else {
      http_response_code(500);
      echo json_encode(["message" => $response['message'], "success" => false]);
    }
  }

  public function getAllExpenses() {
    header('Content-Type: application/json');
    $userId = userMiddleware()['id'];
    $response = $this->Expense->getAllExpenses($userId);
    if ($response['status']) {
      http_response_code(200);
      echo json_encode(["message" => "Expenses retrieved successfully", "success" => true, "data" => $response['data']]);
    } else {
      http_response_code(500);
      echo json_encode(["message" => $response['message'], "success" => false]);
    }
  }
}