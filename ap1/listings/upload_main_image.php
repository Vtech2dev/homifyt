<?php
require_once __DIR__ . "/../_bootstrap.php";
require_post();

$user=require_user($mysqli);
require_role($user, ["agent","admin"]);

$listingId=(int)($_GET["listing_id"]??0);
if($listingId<=0) err("listing_id is required",400);

if(!isset($_FILES["image"])) err("Missing image file field 'image'",400);

$st=$mysqli->prepare("SELECT id,agent_id FROM rentals_listings WHERE id=? LIMIT 1");
$st->bind_param("i",$listingId);
$st->execute();
$listing=$st->get_result()->fetch_assoc();
if(!$listing) err("Listing not found",404);

$role=strtolower($user["role"] ?? "");
if($role==="agent" && (int)$listing["agent_id"] !== (int)$user["user_id"]) err("Forbidden",403);

$file=$_FILES["image"];
if(($file["error"] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) err("Upload error",400);

$maxBytes = 2 * 1024 * 1024;
if(($file["size"] ?? 0) > $maxBytes) err("Image too large (max 2MB)",400);

$tmp=$file["tmp_name"];
$orig=$file["name"] ?? "image.jpg";
$ext=strtolower(pathinfo($orig, PATHINFO_EXTENSION));
if(!in_array($ext, ["jpg","jpeg","png","webp"])) err("Invalid image type",400);

$config=require __DIR__ . "/../config.php";
$uploadsDir=$config["uploads_dir"];
$uploadsUrl=$config["uploads_url_prefix"];

$dir=$uploadsDir . "/listings/" . $listingId;
if(!is_dir($dir)) mkdir($dir, 0755, true);

$name="main_" . bin2hex(random_bytes(6)) . "." . $ext;
$dest=$dir . "/" . $name;

if(!move_uploaded_file($tmp, $dest)) err("Failed to save image",500);

$url=$uploadsUrl . "/listings/" . $listingId . "/" . $name;

$st2=$mysqli->prepare("UPDATE rentals_listings SET main_image_url=?, updated_at=NOW() WHERE id=?");
$st2->bind_param("si",$url,$listingId);
$st2->execute();

$st3=$mysqli->prepare("SELECT id,agent_id,title,location,beds,baths,rent_amount,description,main_image_url,whatsapp,phone,status FROM rentals_listings WHERE id=? LIMIT 1");
$st3->bind_param("i",$listingId);
$st3->execute();
$row=$st3->get_result()->fetch_assoc();
ok($row);
