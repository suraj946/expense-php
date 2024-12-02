<?php

function userMiddleware() {
  session_start();
  if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized, not logged in", "success" => false]);
    exit();
  }
  return $_SESSION['user'];
}