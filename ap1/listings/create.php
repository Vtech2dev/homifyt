<?php
require_once __DIR__ . "/../_bootstrap.php";
require_post();

$user=require_user($mysqli);
require_role($user, ["agent","admin"]);

$in=read_json();
$title=trim((string)($in["title"]??""));
$location=trim((string)($in["location"]??""));
$beds=(int)($in["beds"]??0);
$baths=(int)($in["baths"]??0);
$rent=(int)($in["rent_amount"]??0);
$description=trim((string)($in["description"]??""));
$whatsapp=trim((string)($in["whatsapp"]??""));
$phone=trim((string)($in["phone"]??""));

if($title===""||$location===""||$rent<=0) err("title, location, rent_amount are required",400);

$agentId=(int)$user["user_id"];
$status="approved"; // MVP auto-approve

$st=$mysqli->prepare("INSERT INTO rentals_listings (agent_id,title,location,beds,baths,rent_amount,description,whatsapp,phone,status,created_at,updated_at)
                      VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW())");
$st->bind_param("issiiissss", $agentId, $title, $location, $beds, $baths, $rent, $description, $whatsapp, $phone, $status);
$st->execute();
$id=(int)$mysqli->insert_id;

$st2=$mysqli->prepare("SELECT id,agent_id,title,location,beds,baths,rent_amount,description,main_image_url,whatsapp,phone,status FROM rentals_listings WHERE id=? LIMIT 1");
$st2->bind_param("i",$id);
$st2->execute();
$row=$st2->get_result()->fetch_assoc();
ok($row);
