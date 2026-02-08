<?php
require_once __DIR__ . "/../_bootstrap.php";
require_post();

$in = read_json();
$full_name = trim((string)($in["full_name"] ?? ""));
$email = strtolower(trim((string)($in["email"] ?? "")));
$phone = trim((string)($in["phone"] ?? ""));
$password = (string)($in["password"] ?? "");

if ($full_name === "" || $email === "" || $password === "") err("full_name, email, password are required", 400);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) err("Invalid email", 400);
if (strlen($password) < 6) err("Password must be at least 6 characters", 400);

$st = $mysqli->prepare("SELECT id FROM rentals_users WHERE email=? LIMIT 1");
$st->bind_param("s", $email);
$st->execute();
$exists = $st->get_result()->fetch_assoc();
if ($exists) err("Email already registered", 409);

$salt = substr(bin2hex(random_bytes(16)), 0, 16);
$hash = pass_hash($password, $salt);
$role = "user";
$is_active = 1;

$st2 = $mysqli->prepare("INSERT INTO rentals_users (full_name,email,phone,role,password_hash,salt,is_active,created_at,updated_at)
                         VALUES (?,?,?,?,?,?,?,NOW(),NOW())");
$st2->bind_param("ssssssi", $full_name, $email, $phone, $role, $hash, $salt, $is_active);
$st2->execute();
$user_id = (int)$mysqli->insert_id;

$token = rand_token(48);
$expires = date('Y-m-d H:i:s', time()+7*24*3600);

$st3 = $mysqli->prepare("INSERT INTO rentals_sessions (user_id,token,expires_at,created_at) VALUES (?,?,?,NOW())");
$st3->bind_param("iss", $user_id, $token, $expires);
$st3->execute();

ok(["token"=>$token,"role"=>$role,"email"=>$email,"full_name"=>$full_name]);
