<?php
function bearer_token(){
  $h=$_SERVER['HTTP_AUTHORIZATION']??'';
  if(!$h) return '';
  if(stripos($h,'Bearer ')===0) return trim(substr($h,7));
  return '';
}
function require_user($mysqli){
  $token=bearer_token();
  if($token==='') err("Missing bearer token",401);

  $st=$mysqli->prepare("SELECT s.user_id, u.email, u.full_name, u.role
                        FROM rentals_sessions s
                        JOIN rentals_users u ON u.id=s.user_id
                        WHERE s.token=? AND s.expires_at>NOW()
                        LIMIT 1");
  $st->bind_param("s",$token);
  $st->execute();
  $row=$st->get_result()->fetch_assoc();
  if(!$row) err("Invalid or expired token",401);
  return $row;
}
function require_role($user,$roles){
  $role=strtolower($user['role']??'guest');
  foreach($roles as $r){ if($role===strtolower($r)) return; }
  err("Forbidden",403);
}
