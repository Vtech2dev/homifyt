<?php
function json_ok($data = null, $message = "") {
  header("Content-Type: application/json");
  echo json_encode(["ok"=>true,"data"=>$data,"message"=>$message]);
  exit;
}
function json_error($error, $code=400, $details=null) {
  http_response_code($code);
  header("Content-Type: application/json");
  $r=["ok"=>false,"error"=>$error];
  if($details!==null)$r["details"]=$details;
  echo json_encode($r);
  exit;
}
