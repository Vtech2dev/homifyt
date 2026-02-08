<?php
return [
  "db" => [
    "host" => getenv("DB_HOST"),
    "user" => getenv("DB_USER"),
    "pass" => getenv("DB_PASS"),
    "name" => getenv("DB_NAME"),
    "port" => (int)(getenv("DB_PORT") ?: 3306),
  ],
  "uploads_dir" => __DIR__ . "/../uploads12",
  "uploads_url_prefix" => getenv("UPLOADS_URL_PREFIX") ?: ""
];

