<?php
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

if (!isset($_COOKIE['login_name'])) {
    $url = 'http://www.' . DOMAIN . '.com/cgtx/wd/login.php';
    header("Location:".$url);
    exit;
}

$serverStatusArr = [0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'];
$sql = "SELECT ServerId, ServerName, ServerStatus FROM  91yxq_publish.91yxq_publish_6 WHERE GameId = 19 ORDER BY ServerId DESC";
$res = $mysqli->query($sql);
$server_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $row['ServerStatus'] = $serverStatusArr[$row['ServerStatus']];
        $server_list[] = $row;
    }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0033)http://www.kukewan.com/s/cgtx_ser -->
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <title>操戈天下微端</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- css -->
    <link type="text/css" rel="stylesheet" href="./css/global.css">
    <link type="text/css" rel="stylesheet" href="./css/home.css">
    <link type="text/css" rel="stylesheet" href="./css/setPwd.css">
    <link type="text/css" rel="stylesheet" href="./css/ser.css">
    <script type="text/javascript">
        var NOTLOADUSERJS = true;
    </script>
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="./js/common.js"></script>
</head>
<body oncontextmenu="return false;">
<div class="wrap ser ser2"><!--微端导航-->
    <div class="nav">
        <ul>
            <li>
                <a class="n1" href="http://www.91yxq.com/cgtx/" target="_blank">
                    官网网站
                </a>
                <a class="n2" href="http://pay.91yxq.com/?game_id=19" target="_blank">
                    充值中心
                </a>
                <a class="n3" href="http://www.91yxq.com/help/index.html" target="_blank">
                    客服中心
                </a>
                <a class="n4" href="http://bbs.91yxq.com" target="_blank">
                    游戏论坛
                </a>
            </li>
        </ul>
    </div>
    <div class="logon">
        <p class="p1 oauthName" data-oauthname-config="{&quot;shortNameLen&quot;:16,&quot;nameLink&quot;:1}" data-oauthname-init="1">
            <span class="oauthNameContent"></span>
            <a href="javascript:void(0);" target="_blank" id="login_code" class="name oauthName_hide"><?php echo $_COOKIE['login_name'] ?></a>
            <span>，欢迎您登录操戈天下！</span>
            <a class="exit doSigout a2" href="../../turn.php?act=logout" style="cursor:pointer">退出</a>
        </p>
    </div><!--推荐服务器-->
    <div class="newSer">
        <div><p style="font-size:14px;">最近登陆</p>
            <div class="lately"><span class="noMyGame"></span></div>
        </div>
    </div>
    <div id="serTab" class="serList"><!--快速选服--><!--区服范围tab切换-->
        <div class="divTab"><a class="tabAreaItem on" href="javascript:void(0)" data-tabidx="-1" data-selectedcls="on">全部服务器</a>
            <!--  <select class="server-list-title cf" id="sel" style="margin-left: 20px"></select> --></div><!--区服内容-->
        <div class="serScroll allSerList scrollBarPlugin" scrollbaridx="1">
            <div class="con">
                <ul class="scrollBarCon clearfix ser-list" id="tab0" data-tabidx="-1">
                    <?php if (!empty($server_list)): ?>
                        <?php foreach($server_list as $key=>$val):?>
                            <li class="allServe_li" style="cursor:pointer;"><var class="s3421"></var><a href="../../main.php?act=gamelogin&enter_game=1&wd=1&game_id=19&server_id=<?php echo $val['ServerId'] ?>"><?php echo $val['ServerName']?>【<?php echo $val['ServerStatus']?>】</a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>