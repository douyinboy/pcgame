<?php
//require('../include/common_funs.php');
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

 if (!isset($_COOKIE['login_name'])) {
     $url = 'http://www.' . DOMAIN . '.com/cycs2/wd/login.php';
     header("Location:".$url);
     exit;
 }

$serverStatusArr = [0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'];
$sql = "SELECT ServerId, ServerName, ServerStatus FROM  91yxq_publish.91yxq_publish_6 WHERE GameId = 21 ORDER BY ServerId DESC";
$res = $mysqli->query($sql);
$server_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $row['ServerStatus'] = $serverStatusArr[$row['ServerStatus']];
        $server_list[] = $row;
    }
}

//最近登录的区服
$last_server_str = $_COOKIE['login_game_info'];
$arr = explode('_', $last_server_str);
$last_server = '暂无记录';
$last_server_id = 0;
if ($arr[0] == 21) {
    $_arr = explode('-', $arr[2]);
    $last_server = '双线' . $_arr[1];
    $last_server_id = $_arr[1];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>赤月传说Ⅱ</title>
    <link rel="stylesheet" href="css/common.css"/>
</head>
<body>
<div class="wrapper">
    <div class="server-bg">
        <div class="ser-top">
            <div class="uinfo ser-l clearfix">
                <a class="fr" href="../../turn.php?act=logout">立即退出</a>
                尊敬的：<span><?php echo $_COOKIE['login_name'] ?></span>，欢迎您！
            </div>
            <div class="quick ser-r" id="quick-enter">
                <span>快速进服:</span>
                <input type="text" name="" id="sid0" onkeyup="if(event.keyCode == 13){ enter_server0(); }"/>
                <span>服</span>
                <a class="csp" href="javascript:enter_server0();" title="快速进入"></a>
            </div>
        </div>
        <div class="ser-box">
            <div class="last-ser ser-l">
                <span class="none">最近登录</span>
                <?php if ($last_server_id == 0): ?>
                    <a class="csp" href="javascript:;"><?=$last_server?></a>
                <?php else: ?>
                    <a class="csp" href="../../main.php?act=gamelogin&wd=2&game_id=21&server_id=<?php echo $last_server_id?> ?>"><?=$last_server?></a>
                <?php endif; ?>
            </div>
            <div class="tj-server ser-r">
                <span class="none">新服推荐</span>
                <a class="csp" href="../../main.php?act=gamelogin&wd=2&game_id=21&server_id=<?php echo $server_list[0]['ServerId']?> ?>"><?=$server_list[0]['ServerName']?></a>
            </div>
        </div>
        <h4 class="none">推荐服务器</h4>
        <div class="ser-bottom">
            <ul class="tab-list clearfix">
                <li class="act">公测服</li>
                <!--      <li class="">留档服</li> -->
                <!--      <li>校花服</li> -->
            </ul>
            <div class="server-box">
                <ul class="ser-list clearfix">
                    <?php if (!empty($server_list)): ?>
                        <?php foreach ($server_list as $key => $val): ?>
                            <li>
                                <a href="../../main.php?act=gamelogin&wd=2&game_id=21&server_id=<?php echo $val['ServerId'] ?>">
                                    <span class="smooth"><?php echo $val['ServerName'] ?>【<?php echo $val['ServerStatus'] ?>】</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                    <!--      <ul class="ser-list clearfix" style="display: none;"> -->
                    <!--       <li> <a href="#"> <span class="hot">公测2000区</span> </a> </li> -->
                    <!--       <li> <a href="#"> <span class="smooth">公测2001区</span> </a> </li> -->
                    <!--      </ul> -->
                    <!--      <ul class="ser-list clearfix" style="display: none;"> -->
                    <!--       <li> <a href="#"> <span class="hot">公测5000区</span> </a> </li> -->
                    <!--       <li> <a href="#"> <span class="smooth">公测5001区</span> </a> </li> -->
                    <!--      </ul> -->
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function enter_server0() {
            var reg = /^[1-9]\d*$|^0$/,
                sid = document.getElementById('sid0').value;
            if (reg.test(sid)) {
                if (sid > 3000 || sid == 0) {
                    alert('请正确输入公测区服！');
                } else {
                    window.location.href = '../../main.php?act=gamelogin&wd=2&game_id=21&server_id=' + sid;
                }
            } else {
                alert('您输入的区服有误，请重新输入!');
            }
        }

//        function enter_server1() {
//            var reg = /^[1-9]\d*$|^0$/,
//                sid = $('#sid1').val();
//            if (reg.test(sid)) {
//                if (sid > 117 || sid == 0) {
//                    alert('请正确输入留档区服！');
//                } else {
//                    sid = Number(sid) + 9000;
//                    window.location.href = 'pc_game_cycs2.php?do=entergame&server=' + sid + '&username=zdthnc';
//                }
//            } else {
//                alert('您输入的区服有误，请重新输入!');
//            }
//        }
//
//        function enter_server2() {
//            var reg = /^[1-9]\d*$|^0$/,
//                sid = $('#sid2').val();
//            if (reg.test(sid)) {
//                if (sid > 100000 || sid == 0) {
//                    alert('请正确输入校花的区服！');
//                } else {
//                    sid = Number(sid) + 10000;
//                    window.location.href = 'pc_game_cycs2.php?do=entergame&server=' + sid + '&username=zdthnc';
//                }
//            } else {
//                alert('您输入的区服有误，请重新输入!');
//            }
//        }
//        // tab
//        $('.tab-list li').click(function () {
//            var index = $(this).index();
//            $('#quick-enter').html('<span>快速进服:</span><input type="text" name="" id="sid' + index + '" onkeyup="if(event.keyCode == 13){ enter_server' + index + '(); }"/><span>服</span><a class="csp" href="javascript:enter_server' + index + '();" title="快速进入"></a>');
//            $(this).addClass('act').siblings().removeClass('act');
//            $('.server-box ul').eq(index).show().siblings().hide();
//        }).eq(0).trigger('click');
    </script>
</div>

</body>
</html>