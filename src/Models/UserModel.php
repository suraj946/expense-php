<?php

namespace ExpenseTracker\Models;
use ExpenseTracker\Config\Database;
use Exception;

class UserModel{
  private $db;
  public function __construct(){
    $this->db = new Database();
  }
  public function registerUserDB($name, $email, $password){
    try{
      $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();
      if($stmt->num_rows > 0){
        return ["status" => false, "message" => "Email already exists"];
      }
      $stmt->close();
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
      $stmt = $this->db->getConnection()->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $hashedPassword);
      $stmt->execute();
      $uid = $stmt->insert_id;
      $stmt->close();
      $user = $this->db->getConnection()->query("SELECT id, email, name FROM users WHERE id = $uid");
      $user = $user->fetch_assoc();
      return ["status" => true, "message" => "User registered successfully", "user" => $user];
    } catch(Exception $e){
      echo $e->getMessage();
      return ["status" => false, "message" => $e->getMessage()];
    }
  }

  public function loginUserDB($email, $password){
    try {
      $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row["password"])){
          unset($row["password"]);
          return ["status" => true, "message" => "User logged in successfully", "user" => $row];
        }else{
          return ["status" => false, "message" => "Invalid credentials"];
        }
      }else{
        return ["status" => false, "message" => "Invalid credentials"];
      }
    } catch (Exception $e) {
      echo $e->getMessage();
      return ["status" => false, "message" => $e->getMessage()];
    }
  }
}