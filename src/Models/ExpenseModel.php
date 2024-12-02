<?php

namespace ExpenseTracker\Models;
use ExpenseTracker\Config\Database;
use Exception;

class ExpenseModel{
  private $db;
  public function __construct(){
    $this->db = new Database();
  }

  public function createExpense($userId, $amount, $description, $category){
    try {
      $sql = "INSERT INTO expenses (user_id, amount, description, category) VALUES (?, ?, ?, ?)";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bind_param("iiss", $userId, $amount, $description, $category);
      if($stmt->execute()){
        $expenseId = $this->db->getConnection()->insert_id;
        $selectSql = "SELECT * FROM expenses WHERE id = ?";
        $selectStmt = $this->db->getConnection()->prepare($selectSql);
        $selectStmt->bind_param("i", $expenseId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $insertedData = $result->fetch_assoc();
        return [
          'status' => true,
          'data' => $insertedData
        ];
      } else {
        return [
          'status' => false,
          'message' => "Failed to create expense: " . $stmt->error
        ];
      }
    } catch (Exception $e) {
      return [
        'status' => false,
        'message' => $e->getMessage()
      ];
    }
  }

  public function updateExpense($expenseId, $amount, $description, $category){
    try {
      $sql = "UPDATE expenses SET amount = ?, description = ?, category = ? WHERE id = ?";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bind_param("issi", $amount, $description, $category, $expenseId);
      
      if ($stmt->execute()) {
        return [
          'status' => true,
          'message' => 'Expense updated successfully'
        ];
      } else {
        return [
          'status' => false,
          'message' => 'Failed to update expense: ' . $stmt->error
        ];
      }
    } catch (Exception $e) {
      return [
        'status' => false,
        'message' => $e->getMessage()
      ];
    }
  }

  public function deleteExpense($expenseId){
    try {
      $sql = "DELETE FROM expenses WHERE id = ?";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bind_param("i", $expenseId);
      if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
          return [
            'status' => true,
            'message' => 'Expense deleted successfully'
          ];
        } else {
          return [
            'status' => false,
            'message' => 'No expense found with the provided ID'
          ];
        }
      } else {
        return [
          'status' => false,
          'message' => 'Failed to delete expense: ' . $stmt->error
        ];
      }
    } catch (Exception $e) {
      return [
        'status' => false,
        'message' => $e->getMessage()
      ];
    }
  } 

  public function getAllExpenses($userId){
    try {
      $sql = "SELECT * FROM expenses WHERE user_id = ?";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bind_param("i", $userId);
      if ($stmt->execute()) {
        $result = $stmt->get_result();
        $expenses = $result->fetch_all(MYSQLI_ASSOC);
        if (count($expenses) > 0) {
          return [
            'status' => true,
            'data' => $expenses
          ];
        } else {
          return [
            'status' => false,
            'data' => [],
            'message' => 'No expenses found for this user'
          ];
        }
      } else {
        return [
          'status' => false,
          'message' => 'Failed to retrieve expenses: ' . $stmt->error
        ];
      }
    } catch (Exception $e) {
      return [
        'status' => false,
        'message' => $e->getMessage()
      ];
    }
  }
}