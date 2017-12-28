<?php
require(substr(__DIR__, 0, -3) . "include/cls.game_api.php");
$user_name = $_POST['user_name'];
$userid = $_POST['userid'];
$vm_uid = $_POST['vm_uid'];
$time = $_POST['time'];
$game_id = $_POST['game_id'];
$server_id = $_POST['server_id'];
$login_ip = $_POST['login_ip'];
$id_card = $_POST['id_card'];
$true_name = $_POST['true_name'];
$reg_time = $_POST['reg_time'];
$fcm = $_POST['fcm'];
$wd = $_POST['wd'];
$u_obj = new users();
$u_obj->updateGameLogin(
    $game_id,
    $server_id,
    $user_name,
    $login_ip,
    $reg_time
);//玩家登录日志
$fact = '';
switch ($game_id) {
    case 1:
        $fact = 'gethys';    //火焰神
        break;
    case 2:
        $fact = 'getdpsc';   //斗破沙城
        break;
    case 3:
        $fact = 'getrxhw';   //热血虎卫
        break;
    case 4:
        $fact = 'getcrsgz';  //成人三国志
        break;
    case 5:
        $fact = 'getzgzs';   //战国之怒
        break;
    case 6:
        $fact = 'getczdtx';  //村长打天下
        break;
    case 7:
        $fact = 'getnslm';   //女神联盟
        break;
    case 8:
        $fact = 'getrxsg3';   //热血三国3
        break;
    case 9:
        $fact = 'getsd';      //神道
        break;
    case 10:
        $fact = 'getlzzj';    //龙珠战纪
        break;
    case 11:
        $fact = 'getxxd2';    //仙侠道2
        break;
    case 12:
        $fact = 'getqyz';     //青云志
        break;
    case 13:
        $fact = 'getfyws';    //风云无双
        break;
    case 14:
        $fact = 'getxsqst';   //像素骑士团
        break;
    case 15:
        $fact = 'getdyjd';    //第一舰队
        break;
    case 16:
        $fact = 'getblr';     //不良人
        break;
    case 17:
        $fact = 'getrxjh';    //热血江湖
        break;
    case 18:
        $fact = 'getwszzl';   //武神赵子龙
        break;
    case 19:
        $fact = 'getcgtx';   //操戈天下
        break;
    case 20:
        $fact = 'getsywz';   //神印王座
        break;
    case 21:
        $fact = 'getcycs2';  // 赤月传说2
        break;
    case 22:
        $fact = 'getmhzn2';  //蛮荒之怒2
        break;
    case 25:
        $fact = 'getgcld';   //攻城掠地
        break;
    default:
        $fact = 'gethys';
        break;
}

/**
 * $userid  用户id
 * $user_name 用户名
 * $server_id 选择的区服
 * $fcm 防沉迷
 */
$g_obj = new Game();
$game_url = $g_obj->$fact(
    $userid,
    $user_name,
    $server_id,
    $fcm,
    $wd
);
exit(trim($game_url));
?>