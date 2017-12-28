<?php
date_default_timezone_set("PRC");
$mysqli = new mysqli('127.0.0.1', 'root', 'root', '91yxq_users', '3306');
$mysqli->set_charset('UTF8');
$bbs_key = 'adsf';
$api_key = 'adsf';
return $mysqli;