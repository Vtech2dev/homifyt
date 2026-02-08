<?php
require_once __DIR__."/../_bootstrap.php";
$res=$mysqli->query("SELECT l.*, (SELECT image_url FROM rentals_listing_images WHERE listing_id=l.id LIMIT 1) AS main_image_url FROM rentals_listings l WHERE is_active=1 ORDER BY id DESC");
$list=[];
while($r=$res->fetch_assoc())$list[]=$r;
json_ok(["listings"=>$list]);
