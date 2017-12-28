<?php
//require('../include/common_funs.php');
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

//if (!isset($_COOKIE['login_name'])) {
//    $url = 'http://www.' . DOMAIN . '.com/rxsg3/wd/login.php';
//    header("Location:".$url);
//    exit;
//}

$serverStatusArr = [0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'];
$sql = "SELECT ServerId, ServerName, ServerStatus FROM  91yxq_publish.91yxq_publish_6 WHERE GameId = 8 ORDER BY ServerId DESC";
$res = $mysqli->query($sql);
$server_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $row['ServerStatus'] = $serverStatusArr[$row['ServerStatus']];
        $server_list[] = $row;
    }
}

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 227 ORDER BY PublishDate DESC LIMIT 5";
$res = $mysqli->query($sql);
$news_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $news_list[] = $row;
    }
}

$sql = "SELECT Photo, URL, Title FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 232";
$res = $mysqli->query($sql);
$slide_list = $res->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8" />
<title>热血三国3微端服务器列表</title>
<meta name="title" content="">
<meta name="description" content="" />
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<!-- <script type="text/javascript" src="http://play.ifeng.com/?_c=rxsgs&_a=xf"></script> -->
</head>
<body>
    <div class="main">
        <div class="logout" style="display:block">
            <div class="login_form">
            	<input type="hidden" id="_lastarea" name="lastarea" value="6">
                <p><label id="_username"><?php echo $_COOKIE['login_name'] ?></label>，欢迎登录91游戏圈！ [<a href="../../turn.php?act=logout" class="red00" style="color:#958a84;">更换账号</a>]</p>
                <p><span style="color:#958a84;">最近登录的服务器</span><a onclick="loadgamelast();" class="abuttonhu" id="_zuijindengluurl">凤凰6区</a></p>
            </div>

            <div class="serve_data">
                <?php if (!empty($server_list)): ?>
                    <?php foreach($server_list as $key=>$val):?>
                    <a href="../../main.php?act=gamelogin&enter_game=1&wd=1&game_id=1&server_id=<?php echo $val['ServerId'] ?>" class="abuttonlv"><?php echo $val['ServerName']?>【<?php echo $val['ServerStatus']?>】</a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<!-- 	<script>
		function getCookie_comment(name){
		  var arr = document.cookie.match(new RegExp('(^| )'+name+'=([^;]*)(;|$)'));
		  if(arr!=null) return arr[2];
		  return null;
		}
		$(function(){
			$("#_zuijindengluurl").html(lastareaname);
			$('#_lastarea').val(lastarea);
			var sid = getCookie_comment("sid");
			if(sid&&sid.length>32){ 
				play_username=decodeURIComponent(sid.substr(32));
				$("#_username").html(play_username);
			}else{
				window.location.href="http://games.ifeng.com/webgame/rxsgs/client-index.shtml";
			}
		});
		function loadgame(area){
			
var link = "http://play.ifeng.com/?_a=entergame&game=rxsgs&area="+area+"&logexe=1&client=1";
window.location.href=link ;

		}
		function loadgamelast(){
			var arealast=$('#_lastarea').val();
			loadgame(arealast);
		}
	</script> -->
</body>
</html>