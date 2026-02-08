<?php
require_once __DIR__."/utils.php";
require_once __DIR__."/response.php";
$config=require __DIR__."/config.php";
cors_headers($config["cors"]["allowed_origins"]);
require_once __DIR__."/db.php";
