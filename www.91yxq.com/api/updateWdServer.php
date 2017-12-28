<?php 

$time=$_POST['time'];
$sign=$_POST['sign'];

if($sign!=md5($time."_dfaf_5a_")){
	echo 'sign error';
	exit();
}

//$gameData=json_decode($_POST['gameData'],true);
//$SvrData=json_decode($_POST['SvrData'],true);
$gameData=$_POST['gameData'];
$SvrData=$_POST['SvrData'];

$filename=substr(__DIR__, 0, -3) . 'config/gameSvrData.php';

// print_r($gameData);
print_r($SvrData);
if(!empty($gameData) && !empty($SvrData)) {
	
	 $str="<?php \$gameData='".$gameData."';\$SvrData='".$SvrData."';?>";
// echo $filename;
//     file_put_contents($filename, $str);
//     exit;
}

// echo 'gameData<br/>';
echo $str;