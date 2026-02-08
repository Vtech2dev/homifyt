<?php
require_once __DIR__."/response.php";
$config=require __DIR__."/config.php";
$db=$config["db"];

$mysqli=mysqli_init();
if(!empty($db["ssl_ca"]))$mysqli->ssl_set(null,null,$db["ssl_ca"],null,null);

if(!$mysqli->real_connect($db["host"],$db["user"],$db["pass"],$db["name"],$db["port"],null,MYSQLI_CLIENT_SSL)){
  json_error("DB connect failed",500,$mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
