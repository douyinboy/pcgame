<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_ad_content_by_api.php?id=10
 */

//判断参数是否为空
if (trim($_GET['id']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
//$sign = $_GET['sign'];
//unset($_GET['sign']);
//if ($sign != getSign($_GET, SECRET_KEY)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$adList = getAdImgById(htmlspecialchars(trim($_GET['id'])), $mysqli);

$gameList = getGameName($adList['game_id'], $mysqli);

$bestServer = getBestNewsServer($adList['game_id'], $mysqli);

$url = "plugin.php?id=mocuz_webgame:mocuz_webgame&m=playgame&gid={$adList['game_id']}&sid={$bestServer['ServerId']}&server={$bestServer['ServerName']}&game={$gameList['GameName']}&username=";

?>

document.writeln('<a target="_blank" href="<?php echo $url;?>">');document.writeln('<img src="http://demo.cc/<?php echo $adList['ad_pic'];?>" />');document.writeln('</a>');
