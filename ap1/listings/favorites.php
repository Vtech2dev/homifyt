<?php
require_once __DIR__ . "/../_bootstrap.php";
require_get();

$user=require_user($mysqli);
$uid=(int)$user["user_id"];

$st=$mysqli->prepare("SELECT l.id,l.agent_id,l.title,l.location,l.beds,l.baths,l.rent_amount,l.description,l.main_image_url,l.whatsapp,l.phone,l.status
                      FROM rentals_favorites f
                      JOIN rentals_listings l ON l.id=f.listing_id
                      WHERE f.user_id=?
                      ORDER BY f.id DESC LIMIT 100");
$st->bind_param("i",$uid);
$st->execute();
$res=$st->get_result();
$out=[];
while($row=$res->fetch_assoc()) $out[]=$row;
ok($out);
