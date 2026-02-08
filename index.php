<?php
// Root healthcheck for Render + friendly API pointer
header("Content-Type: application/json; charset=utf-8");

$path = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/";

if ($path === "/" ) {
  echo json_encode([
    "ok" => true,
    "service" => "homify-api",
    "routes" => [
      "/ap1/" => "API root",
      "/ap1/auth/login.php" => "Login",
      "/ap1/auth/register.php" => "Register",
      "/ap1/listings/list.php" => "Listings"
    ]
  ], JSON_PRETTY_PRINT);
  exit;
}

// Optional: redirect /ap1 -> /ap1/
if ($path === "/ap1") {
  header("Location: /ap1/", true, 301);
  exit;
}

http_response_code(404);
echo json_encode(["ok" => false, "error" => "Not found"]);
