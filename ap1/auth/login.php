<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

require_once __DIR__ . "/../_bootstrap.php";
require_post();

$in=read_json();
$email=strtolower(trim($in["email"]??""));
$password=(string)($in["password"]??"");
if($email===""||$password==="") err("email and password are required",400);

$st=$mysqli->prepare("SELECT id,email,full_name,role,password_hash,salt,is_active FROM rentals_users WHERE email=? LIMIT 1");
$st->bind_param("s",$email);
$st->execute();
$user=$st->get_result()->fetch_assoc();
if(!$user || (int)$user["is_active"]!==1) err("Invalid credentials",401);

$calc=pass_hash($password, $user["salt"]);
if(!hash_equals($user["password_hash"], $calc)) err("Invalid credentials",401);

$token=rand_token(48);
$expires=date('Y-m-d H:i:s', time()+7*24*3600);

$st2=$mysqli->prepare("INSERT INTO rentals_sessions (user_id,token,expires_at,created_at) VALUES (?,?,?,NOW())");
$uid=(int)$user["id"];
$st2->bind_param("iss",$uid,$token,$expires);
$st2->execute();

ok(["token"=>$token,"role"=>$user["role"],"email"=>$user["email"],"full_name"=>$user["full_name"]]);
