<?php
    require_once('../common/common.php');
    require_once('../colligate/include/cls.show_page.php');
    require_once('../colligate/include/ip.php');
    include('../colligate/include/isLogin.php');

    /**
     * @通过API进入游戏
     * @url http://admin.demo.com/api/enter_game_by_api.php?game_id=1&server_id=1&login_server=服务器名&login_game=游戏名&user_name=用户名
     */

    $game_id      = $_GET['game_id'];
    $server_id    = $_GET['server_id'];
    $login_game   = $_GET['login_game'];
    $login_server = $_GET['login_server'];
    $user_name    = $_GET['user_name'];
    $remark       = 'API登录';

    if (trim($game_id) == '' || trim($server_id) == '' || trim($login_game) == '' || trim($login_server) == '' || trim($user_name) == '' || trim($remark) == '') {
        exit('ERROR CODE ： 0001');  //所有参数不能为空
    }
    $info = "username=".$user_name;
    //获取用户信息
    $result = long_login_5a($info,time(), 'info');
    $infos = explode('_@@_',$result);
    $time = time();
    $post_str = "act=getgameurl&sign=".md5($time."adsf")."&userid=".$infos[17]."&user_name=".$user_name."&time=".$time."&reg_time=".strtotime($infos[21])."&game_id=".$game_id."&server_id=".$server_id."&login_ip=113.107.150.57&fcm=1";
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_URL, LOGIN_URL );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
    curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
    ob_start( );
    curl_exec( $ch );
    $contents = ob_get_contents( );
    ob_end_clean();
    curl_close( $ch );
    $game_url = $contents == '0' ? INDEX_URL : $contents;
    $sql="insert into ".YYDB.".".OPERATELOG." (user_name,pay_type,op_date,op_content,ip,url) values('".$_SESSION['uName']."','777wan',now(),'".$_SESSION['uName']."登录玩家".$user_name.$login_game.$login_server."|".$remark."','".GetIP()."','http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."')";
    $db->query($sql);

    echo "<script language='javascript'>location.href='$game_url'</script>";
    exit;






?>
