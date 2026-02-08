<?php
function require_post(){ if(($_SERVER['REQUEST_METHOD']??'')!=='POST') err("Method not allowed",405); }
function require_get(){ if(($_SERVER['REQUEST_METHOD']??'')!=='GET') err("Method not allowed",405); }
function rand_token($len=48){
  $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $s=""; for($i=0;$i<$len;$i++) $s.=$chars[random_int(0, strlen($chars)-1)];
  return $s;
}
function pass_hash($password, $salt){ return hash('sha256', $password . $salt); }
