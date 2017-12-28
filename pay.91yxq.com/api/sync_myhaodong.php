<?php
/*
*综合业务平台接口充值接口
*/
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_myweedong.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["REMOTE_ADDR"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);
include("../include/dbconn_4.php");
include_once("../include/config.inc.php");
require_once("../include/cls.game_api.php");

$game_list = array(2, 3);
$game_list_own = array();//自己游戏不扣率费
$pay_channel_own = array(3,4,6,9); //渠道卡费率特殊性
$pay_channel_list = array(1=>'1',2=>'1',3=>'1',4=>'1',5=>'1',6=>'0.95',9=>'0.84',10=>'1',11=>'1',12=>'1',13 =>'1', 14=>'0.95',15=>'0.95',18=>'1',19=>'1',23=>'1',30=>'0.98',31=>'0.98',32=>'0.84',33=>'1',34=>'0.99',35=>'0.95',36=>'0.95',37=>'0.95',38=>'0.95',39=>'0.95',40=>'0.95',41=>'0.86',42=>'0.88',43=>'0.88',44=>'0.82',46=>'0.98',100=>'1');
$admin_username = $_POST['admin_username'];
$user_name = $_POST['user_name'];
$game_id = $_POST['game_id'];
$server_id = $_POST['server_id'];
$orderid = $_POST['orderid'];
$time = $_POST['time'];
$b_num = $_POST['b_num'];
$money = $_POST['money'];
$pay_type = $_POST['pay_type'];
$pay_ip = $_POST['pay_ip'];
$remark = $_POST['remark'];
$bank_date = $_POST['bank_date'];
$bank_name = $_POST['bank_name'];
$flag = $_POST['flag'];
$power_ip = $_SERVER["REMOTE_ADDR"];
$Key_HD = '5apasywuE(73)s$%&KBJzCc:5qLM0928h';

if ( $power_ip !='127.0.0.1' && $power_ip !='208.115.13.26') {
     //echo '2';exit;//此IP无权访问
}
$flag2 = md5($time.$Key_HD.$user_name.$game_id.$server_id.$pay_ip);
if ( $flag2!=$flag ) {
     echo '3';exit;//数字签名失败
}

if ( $game_id=='' || $server_id=='' ) {
     echo '4';exit;//所填的游戏ID或者服ID不能为空
}

if ($pay_type!=100 && $pay_type!=101 && $orderid=='') {
     echo '5';exit;//订单号不能为空
}
     
if ( $orderid ) {
    $res = mysql_query("SELECT succ FROM `pay_orders` WHERE orderid='{$orderid}'");
    $row = mysql_fetch_object($res);
    if (!$row->succ) { echo '6';exit; }//此订单不成功
}

$sql = "SELECT a.name as game_name,a.game_byname,a.back_result,b.pay_url,b.name as server_name FROM `game_list` as a,`game_server_list` as b WHERE a.id=b.game_id and a.id=".$game_id." and b.server_id=".$server_id." limit 1";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$game_name = trim($row->game_name);
$server_name = trim($row->server_name);
$game_table =  "`pay_".$row->game_byname."_log`";
$game_pay_fun = "pay_".$row->game_byname."_b";
$succ_result =  trim($row->back_result);
$pay_url = trim($row->pay_url);
/*-------------------------检查是否重否补发------------------------------*/
if($orderid !=''){
    $res_check = mysql_query("SELECT id FROM $game_table WHERE orderid='".$orderid."' and stat=1");
    $row_check = mysql_fetch_object($res_check);
    if ( $row_check->id > 0 ) { echo '5';exit; }//该订单已成功发放游戏币
}
/*-------------------------检查是否重否补发------------------------------*/

$sql="insert into admin_pay_gameb (admin_name,user_name,game_id,server_id,money,b_num,pay_type,pay_date,remark,orderid) values('$admin_username','$user_name','$game_id','$server_id','$money','$b_num','$pay_type',now(),'$remark','$orderid')";
mysql_query($sql);
$pid=mysql_insert_id();
$orderid_2 = 'M777'.date("Ymd").''.$pid;
if ($pay_type==100 && $orderid=='') { //游戏测试补发
	$orderid = $orderid_2;
	//发放游戏币
	$exchange_rate =10;
	if ( in_array($game_id,$game_list) ) {
	   $exchange_rate= 100;
        }
	if ( $money <=0 ) {
	$money = $b_num/$exchange_rate;
	}
	$sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`remark`) VALUES('{$orderid}','{$user_name}','".$money."',".$money.",".$b_num.",'16','{$pay_ip}',{$server_id},'16')";
        mysql_query($sql);
	//echo $game_pay_fun.'|'.$user_name.'|'.$orderid.'|'.$server_id.'|'.$pay_url.'|'.$money.'|'.$money.'|'.$b_num.'|'.'16';exit;
	$game_obj = new Game($user_name,$orderid,$server_id,$pay_url,$money,$money,$b_num,16); //创建付费对象
	$result=$game_obj ->$game_pay_fun();
	$game_obj = NULL; //创建付费对象
	if ($result) {
		echo '1';exit;
	} else {
		echo '0';exit;
	}	
} else if ($pay_type==101){ //人工充值
    $orderid = date("YmdHis").substr(microtime(),2,6);
	$exchange_rate= 10;
	$pay_channel = 11;
    if ( in_array($game_id,$game_list) ) {
	   $exchange_rate= 100;
    }
    if (in_array($game_id,$game_list_own) && in_array($pay_channel,$pay_channel_own)) {
	  $pay_channel_list[$pay_channel]=1;
    }
    $pay_gold =  intval($pay_channel_list[$pay_channel] *  $money * $exchange_rate);
	$res = mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`sync_date`,`succ`) VALUES('$orderid','$user_name',$money,$money,$pay_gold,$game_id,$server_id,$pay_channel,".ip2long($power_ip).",UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1)");
	if (!$res) {
	    $orderid = date("YmdHis").substr(microtime(),2,6);
		mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`sync_date`,`succ`) VALUES('$orderid','$user_name',$money,$money,$pay_gold,$game_id,$server_id,$pay_channel,".ip2long($power_ip).",UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1)");
	}
    $sql = "INSERT INTO `pay_artificial`(orderid,user_name,game_id,game_name,server_id,server_name,money,gold,pay_date,sync_date,bank_date,bank_name,agent_id,cid,from_url,reg_date,stat) VALUES('$orderid','$user_name','$game_id','$game_name','$server_id','$server_name','$money','$pay_gold','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','$bank_date','$bank_name','$agent_id','$cid','$from_url','$reg_date',0)";
	mysql_query($sql);
	 $sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`remark`) VALUES('$orderid','$user_name','$money','$money','$pay_gold','11','".long2ip($power_ip)."','$server_id','11')";
	mysql_query($sql);
	//发放游戏币
	$game_obj = new Game($user_name,$orderid,$server_id,$pay_url,$money,$money,$pay_gold,11); //创建付费对象
	$result=$game_obj ->$game_pay_fun();
	$game_obj = NULL; //创建付费对象
	if ($result ) {
	    mysql_query("UPDATE `pay_artificial` SET stat=1 WHERE orderid='$orderid'");
		echo '1';exit;
	} else {
		echo '0';exit;
	}
} else if ($pay_type==102){ //游戏帐号充错补发
    mysql_query("UPDATE `pay_orders` SET user='$user_name' WHERE orderid='$orderid'");
	mysql_query("UPDATE $game_table SET user_name='$user_name' WHERE orderid='$orderid'");
	mysql_query("UPDATE `pay_list` SET user_name='$user_name' WHERE orderid='$orderid'");	
} else if ($pay_type==103){ // 帐号充错游戏补发
   mysql_query("UPDATE `pay_orders` SET game=$game_id WHERE orderid='$orderid'");
   mysql_query("UPDATE `pay_list` SET game_id=$game_id WHERE orderid='$orderid'");
   $res = mysql_query("SELECT * FROM `pay_orders` WHERE orderid='$orderid'");
   $row = mysql_fetch_object($res);
   $sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`remark`) VALUES('$orderid','$user_name','".$row->money."','".$row->paid_amount."','".$row->pay_gold."','".$row->pay_channel."','".long2ip($row->user_ip)."','".$row->server."','".$row->pay_channel."')";
   mysql_query($sql);
   //纠正支付渠道表信息
   $res1 = mysql_query("SELECT pay_channel FROM `pay_orders` WHERE orderid='$orderid'");
   $row1 = mysql_fetch_object($res1);
   $res1 = mysql_query("SELECT table_name FROM `pay_channel` WHERE pay_way_id=".intval($row1->pay_channel));
   $row1 = mysql_fetch_object($res1);
   mysql_query("UPDATE `".trim($row1->table_name)."` SET game_id=$game_id WHERE orderid='$orderid'");
	//纠正支付渠道表信息
	
} else if ($pay_type==104){ // 帐号充错服务器补发
   mysql_query("UPDATE `pay_orders` SET server=$server_id WHERE orderid='$orderid'");
   mysql_query("UPDATE $game_table SET server_id=$server_id WHERE orderid='$orderid'");
   mysql_query("UPDATE `pay_list` SET server_id=$server_id WHERE orderid='$orderid'");
   //纠正支付渠道表信息
   $res1 = mysql_query("SELECT pay_channel FROM `pay_orders` WHERE orderid='$orderid'");
   $row1 = mysql_fetch_object($res1);
   $res1 = mysql_query("SELECT table_name FROM `pay_channel` WHERE pay_way_id=".intval($row1->pay_channel));
   $row1 = mysql_fetch_object($res1);
   mysql_query("UPDATE `".trim($row1->table_name)."` SET server_id=$server_id WHERE orderid='$orderid'");
	//纠正支付渠道表信息
} else if ($pay_type==105){ //充值成功元宝未发
  	$res = mysql_query("SELECT * FROM `pay_orders` WHERE orderid='{$orderid}'");
        $row = mysql_fetch_object($res);	
	//发放游戏币
	if($row->succ){
	$game_obj = new Game($row->user,$row->orderid,$row->server,$pay_url,$row->money,$row->paid_amount,$row->pay_gold,$row->pay_channel); //创建付费对象
    $result= $game_obj->$game_pay_fun();
	$game_obj = NULL;
	if ($result){
		echo '1';exit;
	} else {
		echo '0';exit;
	}
	
	}
} else if ( $pay_type==106 ) { //充值成功,但是元宝发放查询没记录
   $res = mysql_query("SELECT * FROM `pay_orders` WHERE orderid='$orderid'");
   $row = mysql_fetch_object($res);
   if($row->succ){
   $sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`remark`) VALUES('$orderid','$user_name','".$row->money."','".$row->paid_amount."','".$row->pay_gold."','".$row->pay_channel."','".long2ip($row->user_ip)."','".$row->server."','".$row->pay_channel."')";
   mysql_query($sql);  
   }
}
    
	/*---------------------帐号渠道更新----------------------*/
	if ($pay_type==102) {
		include_once("/www/pay.91yxq.com/include/funcs.php");
		$user_tab = usertab($user_name);
		$res2=mysql_query("SELECT reg_time FROM $user_tab WHERE user_name='".$user_name."'",$conn_log);
		$row2=mysql_fetch_object($res2);
		if ( $row2->reg_time >0) {
			 $reg_time = $row2->reg_time;
		} else {
			 $reg_time =1325419200;//默认2012
		}
		$year = date("Y",$reg_time);
		$sql="select * from `91yxq_agent_reg_".$year."`  where user_name='$user_name'";
		$res2=mysql_query($sql,$conn_log);
		$row2=mysql_fetch_object($res2);
		$agent_id = $row2->agent_id;
		$placeid = $row2->placeid;
		$cplaceid = $row2->ext1;
		$adid    = $row2->adid;
		$from_url=$row2->referer_url;
		$reg_date=date("Y-m-d H:i:s",$row2->reg_time);
		$cid = $row2->agent_id;
		$flag = true;
		if ( $row2->id > 0 ) {
			 mysql_query("UPDATE `pay_list` SET agent_id='$agent_id',placeid='$placeid',cplaceid='$cplaceid',adid='$adid',reg_date='$reg_date',from_url='$from_url',cid='$cid' WHERE orderid='$orderid' AND user_name='$user_name'");
		}
	}
	/*---------------------------更新帐号渠道信息------------------------*/
	
	//统一发放
	$res = mysql_query("SELECT * FROM `pay_orders` WHERE orderid='{$orderid}'");
        $row = mysql_fetch_object($res);
       if($row->succ){ 
	//发放游戏币       
	$game_obj = new Game($row->user,$row->orderid,$row->server,$pay_url,$row->money,$row->paid_amount,$row->pay_gold,$row->pay_channel); //创建付费对象
    $result=$game_obj->$game_pay_fun();
	$game_obj = NULL;
	if ($result) {
		echo '1';exit;
	} else {
		echo '0';exit;
	}
	}
?>
