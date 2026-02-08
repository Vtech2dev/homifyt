<?php
require_once __DIR__ . "/../_bootstrap.php";
require_get();

$q=trim($_GET["q"]??"");
$status="approved";

if($q!==""){
  $like="%".$q."%";
  $st=$mysqli->prepare("SELECT id,agent_id,title,location,beds,baths,rent_amount,description,main_image_url,whatsapp,phone,status
                        FROM rentals_listings
                        WHERE status=? AND (title LIKE ? OR location LIKE ?)
                        ORDER BY id DESC LIMIT 100");
  $st->bind_param("sss",$status,$like,$like);
} else {
  $st=$mysqli->prepare("SELECT id,agent_id,title,location,beds,baths,rent_amount,description,main_image_url,whatsapp,phone,status
                        FROM rentals_listings
                        WHERE status=?
                        ORDER BY id DESC LIMIT 100");
  $st->bind_param("s",$status);
}
$st->execute();
$res=$st->get_result();
$out=[];
while($row=$res->fetch_assoc()) $out[]=$row;
ok($out);
