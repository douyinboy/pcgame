<?php
include(__DIR__ .  '/include/config.inc.php');

$game_arr = array();
$sql="select * from game_list where is_open=1 order by gTop DESC";
$qu=mysql_query($sql);
while ($re=mysql_fetch_array($qu)) {
	$game_arr[$re['game_byname']]['gid']=$re['id'];
	$game_arr[$re['game_byname']]['name']=$re['name'];
	$game_arr[$re['game_byname']]['b_name']=$re['b_name'];
	$game_arr[$re['game_byname']]['rate']=$re['exchange_rate'];
}
$gl=json_encode($game_arr);
file_put_contents("source/games_str.php",'<?php $gl='."'".$gl."'; ?>");



$servers_arr = array();
$sql="select game_id,name,server_id from game_server_list where is_open=1 order by server_id DESC";
$i=0;
$qu = mysql_query($sql);
while($re =mysql_fetch_array($qu)) {
	 $servers_arr[$re['game_id']][$i]['server_id'] = $re['server_id'];
	 $servers_arr[$re['game_id']][$i]['name'] = $re['name'];
	 $i++;
}

$sl=json_encode($servers_arr);

file_put_contents(__DIR__ . '/source/servers_str.php','<?php $sl=\''.$sl.'\';
$sl_arr=json_decode($sl,true);
$gid=$_GET["gid"];
echo json_encode($sl_arr[$gid]);
?>');
?>
