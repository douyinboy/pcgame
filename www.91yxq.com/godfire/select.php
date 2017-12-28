<?php
//require('../include/common_funs.php');
require('../include/mysqli_config.inc.php');
require('../include/common.inc.php');

if (!isset($_COOKIE['login_name'])) {
    $url = 'http://www.' . DOMAIN . '.com/godfire/login.php';
    header("Location:".$url);
    exit;
}

$serverStatusArr = [0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'];
$sql = "SELECT ServerId, ServerName, ServerStatus FROM  91yxq_publish.91yxq_publish_6 WHERE GameId = 1 ORDER BY ServerId DESC";
$res = $mysqli->query($sql);
$server_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $row['ServerStatus'] = $serverStatusArr[$row['ServerStatus']];
        $server_list[] = $row;
    }
}

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 92 ORDER BY PublishDate DESC LIMIT 5";
$res = $mysqli->query($sql);
$news_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $news_list[] = $row;
    }
}

$sql = "SELECT Photo, URL, Title FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 95";
$res = $mysqli->query($sql);
$slide_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $slide_list[] = $row;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>火焰神</title>
    <link rel="stylesheet" type="text/css" href="css/fire_index.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
<div class="fire_wrap">
    <!--上部-->
    <div class="fire_top">
        <div class="top_left fl">
            <div id="myCarousel" class="carousel slide">
                <!-- 轮播（Carousel）指标 -->
                <ol class="carousel-indicators">
                    <?php if (!empty($slide_list)): ?>
                    <?php foreach($slide_list as $key=>$val): ?>
                        <li data-target="#myCarousel" data-slide-to="<?php echo $key;?>" <?php if ($key == 0): ?> class="active"<?php endif; ?>></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">

                    <?php if (!empty($slide_list)): ?>
                        <?php foreach($slide_list as $key=>$val): ?>
                            <div class="item <?php if ($key == 0): ?> active <?php endif; ?> ">
                                <img src="<?php echo $val['Photo'] ?>" alt="<?php echo $val['Title'] ?>" />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                <!-- 轮播（Carousel）导航 -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev"></a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next"></a>
            </div>
        </div>
        <div class="top_right fr">
            <div class="right_box">
                <div class="news_title">
                    <img src="img/news.png" />
                    <span>新闻公告</span>
                </div>
                <ul>
                    <?php if (!empty($news_list)): ?>
                    <?php foreach($news_list as $val): ?>
                    <li> <a class="fl" href="<?php echo $val['URL'] ?>" target="_blank"><?php echo $val['Title'] ?></a> <span class="fr"><?php echo date('Y-m-d', $val['PublishDate'])?></span> </li>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
    <!--下部-->
    <div class="fire_outline">
        <div class="fire_bottom">
            <img src="img/triangle.png" class="triangle_letp" />
            <img src="img/triangle.png" class="triangle_rgtp" />
            <img src="img/triangle.png" class="triangle_btle" />
            <img src="img/triangle.png" class="triangle_borg" />
            <div class="bottom_top">
                <img src="img/login.png" />
                <!--<p>游 戏 登 录</p>-->
            </div>
            <div class="select_bottom">
                <div class="select_title">
                    <!--<i class="fa fa-fw fa-exclamation-circle"></i>-->
                    <span class="glyphicon glyphicon-menu-right"></span>
                    <span class="glyphicon glyphicon-menu-right select_male"></span>
                    <span>你好，</span>
                    <span class="select_color"><?php echo $_COOKIE['login_name'] ?></span>
                    <a style="text-decoration: none;" href="../turn.php?act=logout">&nbsp;&nbsp;【注销】</a>
                </div>


                <div class="select_serve">
                    <div class="sever_wrap">
                        <?php if (!empty($server_list)): ?>
                            <?php foreach($server_list as $key=>$val):?>
                            <div class="sever_box">
                                <div class="sever_cont">
                                    <a href="../main.php?act=gamelogin&enter_game=1&wd=1&game_id=1&server_id=<?php echo $val['ServerId'] ?>" target="_blank"><p class="sever_name" for="sele_label2"><?php echo $val['ServerName']?>【<?php echo $val['ServerStatus']?>】</p></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/fire_index.js" type="text/javascript" charset="utf-8"></script>
<!-- <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script> -->
<script type="text/javascript">
    $(".sever_cont").click(function(){
        $(".pay_list_c1").parents(".sever_box").find(".pay_list_c1").removeClass("on")
        $(this).find(".pay_list_c1").addClass("on")
    });

</script>
</body>
</html>
