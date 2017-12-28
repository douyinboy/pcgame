<?php

//优

$time=$_REQUEST['time'];
$sign=$_REQUEST['sign'];

if($sign!=md5($time."_passgs_5a_")){
	echo 'sign error';
	exit();
}

$gameData = get_magic_quotes_gpc()?stripslashes($_REQUEST['gameData']):$_REQUEST['gameData'];

$filename = dirname( dirname(__FILE__) ) . '/include/games_str.php';

if(!empty($gameData)) {

	 $str='<?php

     $game_list_str=\''.$gameData.'\';

    ?>';

    file_put_contents($filename, $str);
}
//echo $str;
?>
