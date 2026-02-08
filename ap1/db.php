<?php
$config = require __DIR__ . '/config.php';
$db = $config['db'];

$mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['name'], (int)$db['port']);
if ($mysqli->connect_error) {
  http_response_code(500);
  echo json_encode(["ok"=>false, "error"=>"DB connect failed"]);
  exit;
}
$mysqli->set_charset("utf8mb4");
