<?php
$dbuser="91yxq";
$dbpasswd='7X(xyELU2FSy!QyZ';
$dbhost="192.168.0.20";
$dbname="91yxq_admin";
if (! $conn_9=@mysql_connect($dbhost,$dbuser,$dbpasswd))
	die("Connect to db failed");
mysql_select_db($dbname,$conn_9) || die("Select db failed");
mysql_query('SET NAMES utf8;');
?>
