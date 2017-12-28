<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/ipconfig.php');
require('../include/configApi.php');

/**
 * @通过API进入游戏
 * @param url http://api.demo.com/api/enter_game_by_api.php?game_id=1&server_id=1&login_server=服务器名&login_game=游戏名&user_name=aaaaaa&time=1487574573&sign=df21kk
 */

$game_id      = htmlspecialchars($_GET['game_id']);
$server_id    = htmlspecialchars($_GET['server_id']);
$login_server = htmlspecialchars($_GET['login_server']);
$login_game   = htmlspecialchars($_GET['login_game']);
$user_name    = htmlspecialchars($_GET['user_name']);
$time         = htmlspecialchars($_GET['time']);
$sign         = htmlspecialchars($_GET['sign']);

if (trim($game_id) == '' || trim($sign) == '' || trim($server_id) == '' || trim($login_game) == '' || trim($user_name) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));  //所有参数不能为空
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

//$info = "username=".$user_name;
//获取用户信息
$sql = "select uid, reg_time from 91yxq_users.users where user_name = '" . $user_name . "'";
$infos =  $mysqli->query($sql)->fetch_assoc();
//$result = long_login_5a($info, time(), 'info');
//$infos = explode('_@@_',$result);
$time = time();
$post_str = "act=getgameurl&sign=".md5($time."adsf")."&userid=".$infos['uid']."&user_name=".$user_name."&time=".$time."&reg_time=".$infos['reg_time']."&game_id=".$game_id."&server_id=".$server_id."&fcm=1";
$ch = curl_init();
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt( $ch, CURLOPT_URL, LOGIN_URL );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
ob_start( );
curl_exec( $ch );
$contents = ob_get_contents();
ob_end_clean();
curl_close( $ch );

$game_url = $contents == '0' ? INDEX_URL : $contents;
//    $sql = "INSERT INTO ".YYDB.".".OPERATELOG." (user_name,pay_type,op_date,op_content,ip,url) VALUES('".$user_name."','91yxq',now(),'".$_SESSION['uName']."登录玩家".$user_name.$login_game.$login_server."|".$remark."','".GetIP()."','http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."')";
//    $aa = $mysqli->query($sql);

echo "<script language='javascript'>location.href='$game_url'</script>";
exit;

?>
