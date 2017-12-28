<?php
include_once(dirname(__DIR__) . "/include/mysqli_config.inc.php");
/*$input_date = trim($_GET['date']);
if(empty($input_date)){
	$yesterday = date('Y-m-d',strtotime('-1day'));
	$today = date('Y-m-d');
	$yes_datetime = date('Y-m-d',strtotime('-1day')).' 00:00:00';
	$today_datetime = date('Y-m-d').' 00:00:00';
}else{
	$yesterday = date('Y-m-d',strtotime('-1day',strtotime($input_date)));
	$today = $input_date;
	$yes_datetime = date('Y-m-d',strtotime('-1day',strtotime($input_date))).' 00:00:00';
	$today_datetime = $input_date.' 00:00:00';
}
*/
$yesterday = date('Y-m-d',strtotime('-1day'));
$today = date('Y-m-d');
$yes_datetime = date('Y-m-d',strtotime('-1day')).' 00:00:00';
$today_datetime = date('Y-m-d').' 00:00:00';
$money_arr = array();

//快钱网银
$kq_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=1");
while($kq_arr = $kq_pay->fetch_assoc()){
	$kq_arr['money']+=0;
	$poundage1 = $kq_arr['money'] * 0.004;
	if($poundage1<0.01){
		$poundage1=0.01;
	}
	$money_arr[1]['poundage'] += round($poundage1,2);
	$money_arr[1]['money'] += $kq_arr['money'];
}

//快钱账号
$kqgr_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=3");
while($kqgr_arr = $kqgr_pay->fetch_assoc()){
	$kqgr_arr['money']+=0;
	$poundage3 = $kqgr_arr['money'] * 0.004;
	if($poundage3<0.01){
		$poundage3=0.01;
	}
	$money_arr[3]['poundage'] += round($poundage3,2);
	$money_arr[3]['money'] += $kqgr_arr['money'];
}

//支付宝
$zfb_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=18");
while($zfb_arr = $zfb_pay->fetch_assoc()){
	$zfb_arr['money']+=0;
	$poundage18 = $zfb_arr['money'] * 0.007;
	if($poundage18<0.01){
		$poundage18=0.01;
	}
	$money_arr[18]['poundage'] += round($poundage18,2);
	$money_arr[18]['money'] += $zfb_arr['money'];
} 

//微信
$wx_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=30");
while($wx_arr = $wx_pay->fetch_assoc()){
	$wx_arr['money']+=0;
	$poundage30 = $wx_arr['money'] * 0.02;
	if($poundage30<0.01){
		$poundage30=0.01;
	}
	$money_arr[30]['poundage'] += round($poundage30,2);
	$money_arr[30]['money'] += $wx_arr['money'];
} 

//手机QQ
$qq_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=31");
while($qq_arr = $qq_pay->fetch_assoc()){
	$qq_arr['money']+=0;
	$poundage31 = $qq_arr['money'] * 0.02;
	if($poundage31<0.01){
		$poundage31=0.01;
	}
	$money_arr[31]['poundage'] += round($poundage31,2);
	$money_arr[31]['money'] += $qq_arr['money'];
} 

//骏卡（汇付宝）
$jk_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=32");
while($jk_arr = $jk_pay->fetch_assoc()){
	$jk_arr['money']+=0;
	$poundage32 = $jk_arr['money'] * 0.14;
	if($poundage32<0.01){
		$poundage32=0.01;
	}
	$money_arr[32]['poundage'] += round($poundage32,2);
	$money_arr[32]['money'] += $jk_arr['money'];
} 

//网银（汇付宝）
$wy_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=33");
while($wy_arr = $wy_pay->fetch_assoc()){
	$wy_arr['money']+=0;
	$poundage33 = $wy_arr['money'] * 0.0025;
	if($poundage33<0.01){
		$poundage33=0.01;
	}
	$money_arr[33]['poundage'] += round($poundage33,2);
	$money_arr[33]['money'] += $wy_arr['money'];
} 

//移动（汇付宝）
$yd_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=35");
while($yd_arr = $yd_pay->fetch_assoc()){
	$yd_arr['money']+=0;
	$poundage35 = $yd_arr['money'] * 0.035;
	if($poundage35<0.01){
		$poundage35=0.01;
	}
	$money_arr[35]['poundage'] += round($poundage35,2);
	$money_arr[35]['money'] += $yd_arr['money'];
} 

//联通（汇付宝）
$lt_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=36");
while($lt_arr = $lt_pay->fetch_assoc()){
	$lt_arr['money']+=0;
	$poundage36 = $lt_arr['money'] * 0.035;
	if($poundage36<0.01){
		$poundage36=0.01;
	}
	$money_arr[36]['poundage'] += round($poundage36,2);
	$money_arr[36]['money'] += $lt_arr['money'];
} 

//电信（汇付宝）
$dx_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=37");
while($dx_arr = $dx_pay->fetch_assoc()){
	$dx_arr['money']+=0;
	$poundage37 = $dx_arr['money'] * 0.035;
	if($poundage37<0.01){
		$poundage37=0.01;
	}
	$money_arr[37]['poundage'] += round($poundage37,2);
	$money_arr[37]['money'] += $dx_arr['money'];
} 

//微信支付（聚财通）
$jct_pay = $mysqli->query("SELECT `money` FROM `pay_list` WHERE `pay_date`>='{$yes_datetime}' AND `pay_date`<'{$today_datetime}' AND `pay_way_id`=46");
while($jct_arr = $jct_pay->fetch_assoc()){
	$jct_arr['money']+=0;
	$poundage46 = $jct_arr['money'] * 0.02;
	if($poundage46<0.01){
		$poundage46=0.01;
	}
	$money_arr[46]['poundage'] += round($poundage46,2);
	$money_arr[46]['money'] += $jct_arr['money'];
} 

foreach($money_arr as $k=>$v){
	$test = $mysqli->query("SELECT `id` FROM `91yxq_plat`.`pay_day_detail` WHERE `date`='{$yesterday}' AND `pay_way_id`={$k}");
	if($test->fetch_row()){
		$mysqli->query("UPDATE `91yxq_plat`.`pay_day_detail` SET `poundage`={$v['poundage']} WHERE `date`='{$yesterday}' AND `pay_way_id`={$k}");
	}else{
		$mysqli->query("INSERT INTO `91yxq_plat`.`pay_day_detail` (`pay_way_id`,`money`,`poundage`,`date`) VALUES ({$k},{$v['money']},{$v['poundage']},'{$yesterday}')");
	}
}



