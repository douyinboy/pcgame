<?php
//-----------------------玩过的游戏列表----------------------------------------
$sql_home="SELECT `login_info` FROM  `91yxq_login_info`   WHERE `user_name` = '".$_POST['username']."'";
$query_home=$mysqli->query($sql_home);
$game_str = '';
if($rs_home=$query_home->fetch_assoc()){
   $arr = unserialize($rs_home['login_info']);
   if (!empty($arr)) {
   foreach ($arr as $key => $row) {
    $volume[$key]  = $row['lastlog'];
   }
   }
$i=0;
@array_multisort($volume, SORT_DESC,$arr);

require(substr(__DIR__, 0, -3) . 'include/games_str.php');
$games_list_arr=unserialize($game_list_str);

if (!empty($arr)) {
   foreach( $arr as $key => $val1 ){
	   if($val1['gid']==0){ continue; }
        if ($i==3) {
		    break;
		}
		 $game_n=$games_list_arr[$val1['gid']].'-';

		if(intval($val1['sid'])>1000){
				$game_n.=('合服'.($val1['sid']-1000));
		} else {
			$game_n.=$val1['sid'].'服';
		}
		$game_str.="{$val1['gid']}_{$val1['sid']}_$game_n<a";

		$i++;
   }
   $game_str = substr($game_str,0,-2);
  }
}
if ($game_str=='') {
    $game_str ="";
}
