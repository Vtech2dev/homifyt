<?php
require_once __DIR__."/../_bootstrap.php";
$in=read_json();
$st=$mysqli->prepare("SELECT id,password_hash FROM rentals_users WHERE email=?");
$st->bind_param("s",$in["email"]);
$st->execute();
$u=$st->get_result()->fetch_assoc();
if(!$u||!password_verify($in["password"],$u["password_hash"]))json_error("Invalid credentials",401);
$token=random_token();
$exp=date("Y-m-d H:i:s",strtotime("+30 days"));
$st2=$mysqli->prepare("INSERT INTO rentals_sessions(user_id,token,expires_at,created_at) VALUES (?,?,?,NOW())");
$st2->bind_param("iss",$u["id"],$token,$exp);
$st2->execute();
json_ok(["token"=>$token]);
