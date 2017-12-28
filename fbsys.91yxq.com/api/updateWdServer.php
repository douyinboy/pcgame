<?php
define('NOW_ROOT',substr(dirname(__FILE__),0,-3));
require_once NOW_ROOT.'cms/config.php';
if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("Connect to db failed");
mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

//这里是为了区分平台，不用每一次更新开服状态，各个平台都更新一次。
$PlatformID = 1;
$platform = include('platformDefined.php');
// $sql = mysql_query("select NodeID,NodeGUID from 91yxq_site where NodeID={$NodeInfo[NodeID]}");
// $qu  = mysql_fetch_array($sql);
// foreach($platform as $key=>$val){
	// if(strstr($qu['NodeGUID'],$val)){
		// $PlatformID = $key;
		// break;
	// }
// }
switch ($NodeInfo[NodeID]) {
	default:$game=1;
	break;
}

echo '正在更新'.$platform[$PlatformID].' 微端开服列表...<br/>';

$time = time();

$sql="SELECT c1.ServerId, c1.ServerName, c1.MergeId, c1.ServerStatus, c1.OpenTime, c2.ContentID, c2.SelfURL FROM 91yxq_content_6 c1, 91yxq_content_index c2 WHERE c1.ContentID = c2.ContentID AND c1.ServerStatus >0 AND c1.GameId =".$game." AND c1.PlatformId =".$PlatformID." AND c2.TableID =6 AND c2.State >0 ORDER BY c1.ServerId desc,c1.ContentID asc";
$que=mysql_query($sql);		
$SvrData=array();

while($res=mysql_fetch_array($que)) {	
	if($res['MergeId']>1000){
		$SvrData[$res['MergeId']]['svrID']     = $res['ServerId'];
		$SvrData[$res['MergeId']]['HeFuSID']   = $res['MergeId'];
		$SvrData[$res['MergeId']]['svrName']   = '新'.($res['MergeId']-1000).'服';
		$SvrData[$res['MergeId']]['svrStateID']= $res['ServerStatus'];
	} else if($res['MergeId']>0) {
		$SvrData[$res['MergeId']]['svrID']     = $res['ServerId'];
		$SvrData[$res['MergeId']]['HeFuSID']   = $res['MergeId'];
		$SvrData[$res['MergeId']]['svrName']   = '合服'.$res['MergeId'];
		$SvrData[$res['MergeId']]['svrStateID']= $res['ServerStatus'];
	} else {
		$SvrData[$res['ServerId']]['svrID']    = $res['ServerId'];
		$SvrData[$res['ServerId']]['HeFuSID']  = $res['MergeId'];
		$SvrData[$res['ServerId']]['svrName']  = $res['ServerName'];
		$SvrData[$res['ServerId']]['svrStateID']= $res['ServerStatus'];
	}
	$SvrData[$res['ServerId']]['svrGameUrl'] = $res['SelfURL'];
}
	$SvrData2  = serialize($SvrData);
	
	$platsite = $platform[$PlatformID];

	$url      = "http://www.".$platsite.".com/api/updateWdServer.php";
	$info     = "game=$game&SvrData=$SvrData2&time=".$time."&sign=".md5($time."_dfaf_5a_");
	$contents = post_by_curl($url, $info);

echo $contents;	
echo $platform[$PlatformID].'  -  开服列表  -  更新成功<br/>';
