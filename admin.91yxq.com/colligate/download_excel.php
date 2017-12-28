<?php
session_start();
ob_start();
ob_end_clean();
if($_POST['stage']!='yes' || !$_SESSION['data_for_excel']){
	echo '报表内容为空！';
	exit();
}

$outputFileName=trim($_POST['filename']);  //文件名

if(!$outputFileName){
	$outputFileName='9494.com.xls';
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$outputFileName.'"');
header('Cache-Control: max-age=0');
$arr=unserialize($_SESSION['data_for_excel']);




foreach($arr as $val){
	foreach($val as $v){
		echo $v.chr(9);
	}
	echo chr(13);
}
?> 