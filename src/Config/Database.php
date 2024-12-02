<?php
namespace ExpenseTracker\Config;
use mysqli;
use Exception;

class Database{
  private $connection;

  public function __construct(){
    try{
      $host = $_ENV['DB_HOST'];
      $user = $_ENV['DB_USER'];
      $password = $_ENV['DB_PASSWORD'];
      $database = $_ENV['DB_DATABASE'];
      $this->connection = new mysqli($host, $user, $password, $database);
      if($this->connection->connect_error){
        throw new Exception("Database connection failed ".$this->connection->connect_error);
      }
      $this->createTables();
    }catch(Exception $e){
      die($e->getMessages());
    }
  }

  public function getConnection(){
    return $this->connection;
  }

  public function closeConnection(){
    if ($this->connection) {
      $this->connection->close();
      $this->connection = null;
    }
  }

  private function createTables(){
    $userTableSql = "
      CREATE TABLE IF NOT EXISTS users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL UNIQUE,
      email VARCHAR(255) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $expenseTableSql = "
      CREATE TABLE IF NOT EXISTS expenses (
      id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT NOT NULL,
      amount DECIMAL(10, 2) NOT NULL,
      description TEXT,
      category VARCHAR(255),
      date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    if(!$this->connection->query($userTableSql)){ 
      throw new Exception("Error creating users table: " . $this->connection->error);
    }
    if(!$this->connection->query($expenseTableSql)){
      throw new Exception("Error creating expenses table: " . $this->connection->error);
    }
  }

}