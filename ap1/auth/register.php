<?php
require_once __DIR__."/../_bootstrap.php";
$in=read_json();
if(!$in["email"]||!$in["password"]||!$in["full_name"])json_error("Missing fields");
$hash=password_hash($in["password"],PASSWORD_BCRYPT);
$st=$mysqli->prepare("INSERT INTO rentals_users(full_name,email,password_hash,created_at) VALUES (?,?,?,NOW())");
$st->bind_param("sss",$in["full_name"],$in["email"],$hash);
if(!$st->execute())json_error("Register failed",500,$mysqli->error);
json_ok(null,"Registered");
