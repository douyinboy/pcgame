<?php
require('../include/mysqli_config.inc.php');
require('../include/common.inc.php');

 if (isset($_COOKIE['login_name'])) {
     $url = 'http://www.' . DOMAIN . '.com/godfire/select.php';
     header("Location:".$url);
     exit;
 }

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 92 ORDER BY PublishDate DESC LIMIT 5";
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
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>火焰神</title>
		<link rel="stylesheet" type="text/css" href="css/fire_index.css"/>
<!--	    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>-->
<!--	    <link rel="stylesheet" type="text/css" href="layer/mobile/need/layer.css"/>-->
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
	<a class="carousel-control left" href="#myCarousel"
	   data-slide="prev"></a>
	<a class="carousel-control right" href="#myCarousel"
	   data-slide="next"></a>
</div>
			</div>
			<div class="top_right fr">
				<div class="right_box">
					<div class="news_title">
					 <img src="img/news.png"/>
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
			<img src="img/triangle.png" class="triangle_letp"/>
			<img src="img/triangle.png" class="triangle_rgtp"/>
			<img src="img/triangle.png" class="triangle_btle"/>
			<img src="img/triangle.png" class="triangle_borg"/>
			<div class="bottom_top">
	          <img src="img/login.png"/>
	        <!--<p>游 戏 登 录</p>-->
			</div>
			<div class="bottom_bottom">
            <form id="aform" action="../api/check_godfire_login.php" method="post" onSubmit="return docheck();">
              <input type="hidden" id="other_act" name="action" value="1" />
	          <div class="bottom_left fl">
	          	<div class="bttom_login bttom_logbot">
	          		<label>帐  号：</label>
	             	<input type="text" name="login_user" id="" value="<?php echo $_COOKIE['last_name'];?>"  class="log_number">
				</div>
	          	<div class="bttom_login">
	          		<label>密  码：</label>
	             	<input type="password" name="login_pwd" id="" value=""  class="log_pass"/>
	          	</div>
	          	<div class="bttom_mima">
					<div class="piaochecked on_check">
						<input name="denglu" type="checkbox" style="height:12px;width:12px;margin-top: -3px;" class="radioclass input" value="1" id="input_label">
					</div>
                    <label class="reber_pass" for="input_label">记住账号</label>
	          		<a href="http://www.91yxq.com/help.php?act=getpwd_email" class="fr"><span class="forget_pass">忘记密码？</span></a>
	          	</div>
	          </div>
	          <div class="bottom_right fr">
	          	<div class="away_loregin">
	          		<img src="img/button.png"/>
	          		<!-- <a href="javascript:;"><p class="log_login">立 即 登 录</p></a> -->
	          		<p class="log_login"><button type="submit" style="font-size: 16px; height: 30px; background: none; border: none; color: #5f1d00; font-weight: bold;">立 即 登 录</button></p>
	          	</div>
	          	 <div class="away_loregin">
	          	 	<img src="img/button.png"/>
	          	 	<a href="register.php"><p>账 号 注 册</p></a>
	          	 </div>

	          </div>
            </form>
			</div>
		</div>
		</div>
		</div>
	</body>
	<script src="/jsLib/function.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/fire_index.js" type="text/javascript" charset="utf-8"></script>
<!--    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>-->
<!--    <script src="layer/layer.js" type="text/javascript" charset="utf-8"></script>-->

    <script type="text/javascript">
    	$(".piaochecked").click(function(){
    $(this).hasClass("on_check")? $(this).removeClass("on_check"):$(this).addClass("on_check");
   //或者这么写
  // $(this).toggleClass( "on_check" );
})
    </script>
</html>
