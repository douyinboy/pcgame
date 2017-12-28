<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

$time=$_POST['time'];
$sign=$_POST['sign'];

if($sign!=md5($time."_dfaf_5a_")){
	echo 'sign error';
	exit();
}

$gameData= get_magic_quotes_gpc()?stripslashes($_POST['gameData']):$_POST['gameData'];
$SvrData= get_magic_quotes_gpc()?stripslashes($_POST['SvrData']):$_POST['SvrData'];

// $gameData=$_GET['gameData'];
// $SvrData=$_GET['SvrData'];

$filename = dirname( dirname(__FILE__) ) . '/config/gameSvrData.php';

if(!empty($gameData) && !empty($SvrData)) {
	
    $str='<?php '.
		' $gameData=\''.$gameData.'\';'.
		' $SvrData=\''.$SvrData.'\';'.
		// ' echo  \''.$gameData.'\'; echo  \''.$SvrData.'\';'.    //查看效果
		// ' echo "<pre>"; print_r( json_decode($gameData,true) ); print_r( json_decode($SvrData,true) ); echo "</pre>";'.  //查看效果
		' ?>';
// echo $filename;
    file_put_contents($filename, $str);
    exit;
}
