<?php
return [
  "cors" => [
    "allowed_origins" => getenv("CORS_ORIGINS") ?: "*",
  ],
  "db" => [
    "host" => getenv("DB_HOST"),
    "port" => (int)(getenv("DB_PORT") ?: 3306),
    "name" => getenv("DB_NAME"),
    "user" => getenv("DB_USER"),
    "pass" => getenv("DB_PASS"),
    "ssl_ca" => getenv("DB_SSL_CA"),
  ],
  "cloudinary" => [
    "cloud_name" => getenv("CLOUDINARY_CLOUD_NAME"),
    "api_key" => getenv("CLOUDINARY_API_KEY"),
    "api_secret" => getenv("CLOUDINARY_API_SECRET"),
  ],
];
