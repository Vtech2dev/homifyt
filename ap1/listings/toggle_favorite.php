<?php
require_once __DIR__ . "/../_bootstrap.php";
require_post();

$user=require_user($mysqli);
$uid=(int)$user["user_id"];
$listingId=(int)($_GET["listing_id"]??0);
if($listingId<=0) err("listing_id is required",400);

$st=$mysqli->prepare("SELECT id FROM rentals_favorites WHERE user_id=? AND listing_id=? LIMIT 1");
$st->bind_param("ii",$uid,$listingId);
$st->execute();
$row=$st->get_result()->fetch_assoc();

if($row){
  $id=(int)$row["id"];
  $st2=$mysqli->prepare("DELETE FROM rentals_favorites WHERE id=?");
  $st2->bind_param("i",$id);
  $st2->execute();
  ok(["favorited"=>false]);
} else {
  $st2=$mysqli->prepare("INSERT INTO rentals_favorites (user_id,listing_id,created_at) VALUES (?,?,NOW())");
  $st2->bind_param("ii",$uid,$listingId);
  $st2->execute();
  ok(["favorited"=>true]);
}
