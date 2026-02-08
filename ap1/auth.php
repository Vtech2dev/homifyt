<?php
require_once __DIR__."/response.php";
function require_user(mysqli $mysqli){
  $h=$_SERVER["HTTP_AUTHORIZATION"]??"";
  if(!preg_match('/Bearer\s+(.*)/',$h,$m))json_error("Missing token",401);
  $t=$m[1];
  $st=$mysqli->prepare("SELECT u.id,u.full_name,u.email,u.role FROM rentals_sessions s JOIN rentals_users u ON u.id=s.user_id WHERE s.token=? AND s.expires_at>NOW()");
  $st->bind_param("s",$t);
  $st->execute();
  $u=$st->get_result()->fetch_assoc();
  if(!$u)json_error("Invalid token",401);
  return $u;
}
