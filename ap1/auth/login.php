<?php
// ap1/db.php
// PDO connection (MySQL)

$DB_HOST = getenv("DB_HOST") ?: "sql200.infinityfree.com";
$DB_NAME = getenv("DB_NAME") ?: "if0_41080480_barbershop_db";
$DB_USER = getenv("DB_USER") ?: "if0_41080480";
$DB_PASS = getenv("DB_PASS") ?: "Chapati455";
$DB_PORT = getenv("DB_PORT") ?: "3306";

$dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode([
    "ok" => false,
    "error" => "DB connection failed",
    "details" => $e->getMessage()
  ]);
  exit;
}
