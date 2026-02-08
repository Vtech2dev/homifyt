<?php
header("Content-Type: application/json");
echo json_encode([
  "ok" => true,
  "service" => "homify-api",
  "hint" => "Use /ap1/"
]);
