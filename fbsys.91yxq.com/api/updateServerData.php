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
$sql = mysql_query("select NodeID,NodeGUID from 91yxq_site where NodeID={$NodeInfo[NodeID]}");
// echo "<pre>";
// print_r($NodeInfo);
// echo "</pre>";
$qu  = mysql_fetch_array($sql);
foreach($platform as $key=>$val){
	if(strstr($qu['NodeGUID'],$val)){
		$PlatformID = $key;
		break;
	}
}

echo '正在更新'.$platform[$PlatformID].'开服列表...<br/>';

$time = time();

	$qu=mysql_query("SELECT GameName,GameId,ShortName,GameWeb,ServiceStatus FROM 91yxq_publish_5 where PlatformId=".$PlatformID." and ServiceStatus=1 order by GameId");
	
	$passport_game = array();
	
	while($re=mysql_fetch_array($qu)) {
		$sql="SELECT c1.ServerId, c1.ServerName, c1.MergeId, c1.ServerStatus, c1.URL FROM 91yxq_publish_6 c1 WHERE c1.ServerStatus >0 AND c1.GameId =".$re['GameId']." AND c1.PlatformId =".$PlatformID." ORDER BY c1.ServerId desc,c1.ContentID asc";
		$que=mysql_query($sql);		
// 		echo $sql.'<br/>';
		
		$gameData[$re['GameId']]['gameID']  = $re['GameId'];
		$gameData[$re['GameId']]['nameEn']  = $re['ShortName'];
		$gameData[$re['GameId']]['nameCn']  = $re['GameName'];
		$gameData[$re['GameId']]['gameWeb'] = $re['GameWeb'];
		$gameData[$re['GameId']]['stateID'] = $re['ServiceStatus'];
		$passport_game[$re['GameId']] = $re['GameName'];
		while($res=mysql_fetch_array($que)) {	
			if($res['MergeId']>1000){
				$SvrData[$re['GameId']][$res['MergeId']]['svrID']     = $res['ServerId'];
				$SvrData[$re['GameId']][$res['MergeId']]['HeFuSID']   = $res['MergeId'];
				$SvrData[$re['GameId']][$res['MergeId']]['svrName']   = '新'.($res['MergeId']-1000).'服';
				$SvrData[$re['GameId']][$res['MergeId']]['svrStateID']= $res['ServerStatus'];
			} else if($res['MergeId']>0) {
				$SvrData[$re['GameId']][$res['MergeId']]['svrID']     = $res['ServerId'];
				$SvrData[$re['GameId']][$res['MergeId']]['HeFuSID']   = $res['MergeId'];
				$SvrData[$re['GameId']][$res['MergeId']]['svrName']   = '合服'.$res['MergeId'];
				$SvrData[$re['GameId']][$res['MergeId']]['svrStateID']= $res['ServerStatus'];
			} else {
				$SvrData[$re['GameId']][$res['ServerId']]['svrID']    = $res['ServerId'];
				$SvrData[$re['GameId']][$res['ServerId']]['HeFuSID']  = $res['MergeId'];
				$SvrData[$re['GameId']][$res['ServerId']]['svrName']  = $res['ServerName'];
				$SvrData[$re['GameId']][$res['ServerId']]['svrStateID']= $res['ServerStatus'];
			}
			$SvrData[$re['GameId']][$res['ServerId']]['svrGameUrl'] = $res['URL'];
		}
	}	
	
// 	print_r($SvrData);exit;
	
	$gameData = json_encode($gameData);
	$SvrData  = json_encode($SvrData);
	//file_put_contents(dirname(__FILE__)."/gameDataTest.php",$gameData);
	$passportGameData = serialize($passport_game);
        $platsite = $platform[$PlatformID];

	$url      = "http://www.".$platsite.".com/api/updateServerData.php";
	//$url      = "http://127.0.0.1:16881/api/updateServerData.php";
	$info     = "gameData=$gameData&SvrData=$SvrData&time=".$time."&sign=".md5($time."_dfaf_5a_");
	
	$contents = post_by_curl($url, $info);
	
	$url      = "http://api.".$platsite.".com/api/update_server_data.php";
	//$url      = "http://127.0.0.1:16888/api/api/update_server_data.php";
	$info     = "gameData=$passportGameData&time=$time&sign=".md5($time."_passgs_5a_");
	$games_str= post_by_curl($url, $info);

echo $games_str;	
echo $contents;	
echo $platform[$PlatformID].'  -  开服列表  -  更新成功<br/>';

function post_by_curl($url, $info){
	$ch = curl_init( );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $info );
	curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
	curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );

	ob_start( );
	curl_exec( $ch );
	$contents = ob_get_contents( );
	ob_end_clean();
	curl_close( $ch );

	return $contents;
}

// echo $SvrData;exit;
// exit;