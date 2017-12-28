<?php
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

if (!empty($_SESSION["login"]["username"])) {
    $url = 'http://www.' . DOMAIN . '.com/cycs2/wd/select.php';
    header("Location:".$url);
    exit;
}

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 424 ORDER BY PublishDate DESC LIMIT 5";
$res = $mysqli->query($sql);
$news_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $news_list[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>
            赤月传说Ⅱ
        </title>
        <link rel="stylesheet" href="css/common.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="user-login fix">
                <div class="module-news fl">
                    <!-- 幻灯 -->			
             		<div class="focus">
						<div id="Slideshow">
							<a href="http://www.91yxq.com/cycs2/" target="_blank" rel="nofollow"><img src="http://upload.9377s.com/uploads/2017/09-08/1b7897cca5d6dbdc.jpg" width="463" height="208" alt="" /></a>
<!--							<a href="http://www.91yxq.com/cycs2/" target="_blank" rel="nofollow"><img src="http://upload.9377s.com/uploads/2017/07-28/dd85197806fa5f93.jpg" width="463" height="208" alt="" /></a>-->
						</div>
					</div>
                    <!-- 新闻 -->
                    <div class="news-box">
                        <h2>
                            <a href="http://www.91yxq.com/cycs2/xwzx/index.html" target="_blank">
                                更多&gt;&gt;
                            </a>
                            <span class="none">
                                新闻公告
                            </span>
                        </h2>
                        <ul class="news-list">
                            <?php if (!empty($news_list)): ?>
                                <?php foreach($news_list as $val): ?>
                                <li>
                                    <a href="<?php echo $val['URL'] ?>"  target="_blank" title="<?php echo $val['Title'] ?>">
                                        <span>[<?php echo date('Y/m/d', $val['PublishDate']) ?>]</span><?php echo $val['Title'] ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="module-log fr">
                    <!-- 登陆 -->
                    <div class="login-box" id="login-box">
                        <form action="../../api/check_godfire_login.php" id="login-form" method="post" name="login-form">
                            <input type="hidden" name="type" value="cycs2" />
                            <p class="q-input">
                                <label for="username">账号：</label>
                                <input id="username" name="login_user" tabindex="1" type="text" value="<?php echo $_COOKIE['last_name'];?>">
                            </p>
                            <p class="q-input">
                                <label for="password">密码：</label>
                                <input id="password" name="login_pwd" tabindex="2" type="password">
                            </p>
                            <p class="q-links fix">
                                <a href="http://www.91yxq.com/turn.php?act=reg" target="_blank" title="忘记密码">用户注册</a>
                                <a href="http://www.91yxq.com/help.php?act=getpwd_email" target="_blank" title="忘记密码">忘记密码</a>
                            </p>
                            <p class="form-btn">
                                <button style="width:211px; height:75px; margin-left: 28px; cursor: pointer;" class="node" type="submit"></button>
<!--                                <a class="enter-sub node" href="javascript:;" id="login-btn" title="登录游戏"></a>-->
                            </p>
<!--                            <p class="form-links">-->
<!--                                <a class="log-reg-btn" href="./register.php" title="账号注册">-->
<!--                                    [注册账号]-->
<!--                                </a>-->
<!--                                <a href="http://pay.91yxq.com/?game_id=21" target="_blank">-->
<!--                                    [充值中心]-->
<!--                                </a>-->
<!--                            </p>-->
                        </form>
                    </div>
                    <!-- 注册 -->
<!--                    <div class="register-box none" id="register-box">-->
<!--                        <form action="http://wvw.9377.com/register.php" id="register-form" method="post" name="register-form">-->
<!--                            <div class="reg-line">-->
<!--                                <p class="q-input">-->
<!--                                    <label for="LOGIN_ACCOUNT">-->
<!--                                        账号：-->
<!--                                    </label>-->
<!--                                    <input name="LOGIN_ACCOUNT" title="6-20个字符，数字，字母组成" type="text" value="">-->
<!--                                        <span>-->
<!--                                            请填写4-20位数字, 英文账号-->
<!--                                        </span>-->
<!--                                    </input>-->
<!--                                </p>-->
<!--                                <p class="q-input">-->
<!--                                    <label for="PASSWORD">-->
<!--                                        密码：-->
<!--                                    </label>-->
<!--                                    <input name="PASSWORD" title="长度6-20个字符" type="password">-->
<!--                                        <span>-->
<!--                                            请输入密码-->
<!--                                        </span>-->
<!--                                    </input>-->
<!--                                </p>-->
<!--                                <p class="q-input">-->
<!--                                    <label for="PASSWORD1">-->
<!--                                        密码：-->
<!--                                    </label>-->
<!--                                    <input name="PASSWORD1" title="长度6-20个字符" type="password">-->
<!--                                        <span>-->
<!--                                            请再次入密码-->
<!--                                        </span>-->
<!--                                    </input>-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <p class="reg-item">-->
<!--                                <input class="reg-sub node" id="reg-btn" type="submit" value="确认注册">-->
<!--                                    <a class="log-reg-btn" href="javascript:;" title="返回登录">-->
<!--                                        返回-->
<!--                                    </a>-->
<!--                                </input>-->
<!--                            </p>-->
<!--                        </form>-->
<!--                    </div>-->
                </div>
            </div>
            <!-- 新用户登录后的界面 -->
        </div>
    </body>
</html>