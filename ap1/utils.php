<?php
function cors_headers($origins="*"){
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET,POST,OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");
  if(($_SERVER["REQUEST_METHOD"]??"")==="OPTIONS"){http_response_code(204);exit;}
}
function read_json(){
  $d=json_decode(file_get_contents("php://input"),true);
  return is_array($d)?$d:[];
}
function random_token($len=64){return bin2hex(random_bytes($len/2));}
