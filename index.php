<?php
// Basic health check + redirect helper
header("Content-Type: application/json; charset=utf-8");

$path = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH);

if ($path === "/" || $path === "") {
  echo json_encode([
    "ok" => true,
    "service" => "homify-api",
    "hint" => "Use /ap1/ (e.g. /ap1/index.php)"
  ]);
  exit;
}

// If someone hits /ap1 without trailing slash, you can redirect:
if ($path === "/ap1") {
  header("Location: /ap1/", true, 301);
  exit;
}

http_response_code(404);
echo json_encode(["ok" => false, "error" => "Not found"]);
