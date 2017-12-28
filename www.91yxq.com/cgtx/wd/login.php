<?php
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

if (!empty($_SESSION["login"]["username"])) {
    $url = 'http://www.' . DOMAIN . '.com/cgtx/wd/select.php';
    header("Location:" . $url);
    exit;
}

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 394 ORDER BY PublishDate DESC LIMIT 3";
$res = $mysqli->query($sql);
$news_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $news_list[] = $row;
    }
}

$sql = "SELECT Photo, URL, Title FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 397 LIMIT 1";
$res = $mysqli->query($sql);
$slide_list = $res->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta content="no-cache" http-equiv="Pragma"/>
    <title>操戈天下微端</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <!-- css -->
    <link rel="stylesheet" href="css/">
    <link href="./css/global.css" rel="stylesheet" type="text/css"/>
    <link href="./css/home.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
        var NOTLOADUSERJS = true;
    </script>
    <script src="./js/jquery.min.js" type="text/javascript"></script>
    <script charset="utf-8" src="./js/common.js" type="text/javascript"></script>
</head>
<body oncontextmenu="return false;">
<div class="wrap">
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
    <div class="left" style="width: 376px;float: left;">
        <div class="slideDiv">
            <div class="imgShow">
                <div class="imgBox">
                    <a href="<?php echo $slide_list['URL'] ?>" target="_blank">
                        <img style="width: 355px;" src="<?php echo $slide_list['Photo'] ?>"/>
                    </a>
                </div>
            </div>
        </div>
        <!--新闻框-->
        <div class="newsBox">
            <h3>
                  <span style="float: right;">
                      <a href="http://www.91yxq.com/cgtx/xwzx/index.html" target="_blank">
                          更多>>
                      </a>
                  </span>
            </h3>
            <ul class="newsList" id="newsList">
                <?php if (!empty($news_list)): ?>
                    <?php foreach ($news_list as $val): ?>
                        <li>
                            <var>[09-05]</var>
                            <a href="<?php echo $val['URL'] ?>" target="_blank" title="<?php echo $val['Title'] ?>">
                                <?php echo $val['Title'] ?>
                            </a>
                            <span class="time"></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!--         <li><var>[08-03]</var><a href="http://www.8090.com/cgtx/xinwen/285320.html" target="_blank" title="操戈天下【会员活动】平台V友豪华送 领新区独享礼包">操戈天下【会员活动】平台V友豪华送 领新区独享礼包</a><span class="time"></span></li> -->
            </ul>
        </div>
    </div>
    <!--登陆框-->
    <div class="uc" id="tabDivLog">
        <form class="login_box" action="../../api/check_godfire_login.php" name="iform" method="post" id="_iform">
            <input type="hidden" name="type" value="cgtx"/>
            <div class="login">
                <p class="pWarn" id="pWarn">
                </p>
                <p class="p1" data-focuscls="p1On">
                    <label>
                        账　　号：
                    </label>
                    <input class="i" data-placeholder="请输入登录账号" id="username" name="login_user" type="text" value=""/>
                </p>
                <p class="p2" data-focuscls="p2On">
                    <label>
                        账　　号：
                    </label>
                    <input class="i" data-placeholder="请输入您的密码" id="password" name="login_pwd" type="password"/>
                </p>
                <p class="btn" style="margin-left: 30px">
                    <a href="http://www.91yxq.com/turn.php?act=reg" target="_blank" title="">
                        注册帐号
                    </a>
                    <a href="http://www.91yxq.com/help.php?act=getpwd_email" target="_blank" title="">
                        忘记密码
                    </a>
                </p>
                <p class="btn">
                    <button id="loginin" class="log_btn" type="submit">
                        立即登录
                    </button>
                </p>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
//    $(function(){
//        $('.log_btn').on('click',function(){
//            var username = $.trim($('#username').val());
//            var password = $.trim($('#password').val());
//            if(username == '' || password ==''){
//                alert('账号和密码不能为空！');
//                return;
//            }
//
//        })
//    });
//
//    function chklogined() {
//        var loginAccount = $("#username").val();
//        var password = $("#password").val();
//        var rememberMe = 1;
//
//        if (!/^[A-Za-z0-9_@\.]{4,20}$/.test(loginAccount)) {
//            alert("请输入正确的用户名！用户名为4到20位的英文或数字！");
//            return;
//        }
//        if (!/^.{6,20}$/.test(password)) {
//            alert("请输入正确的密码！密码长度为6到20！");
//            return;
//        }
//
//        $.getJSON("http://www.kukewan.com/accounts/checklogin1/?cn=" + encodeURIComponent(loginAccount) + "&pwd=" + password + "&return_format=JSON&jsonpCallback=?", function (data) {
//
//            if (data.result != "success") {
//                alert(data.msg);
//            } else {
//                $('body').append(data.login);
//                var str = 'http://www.kukewan.com/s/cgtx_ser';
//                setTimeout("window.location.href= '" + str + "'", 500);
//            }
//        });
//
//        return false;
//    }
//
//    $(function () {
//        $("input").keypress(function (e) {
//            if (e.keyCode == 13) {
//                chklogined();
//            }
//        });
//    });
</script>

</body>
</html>