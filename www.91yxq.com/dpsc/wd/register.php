<?php
require('../../include/mysqli_config.inc.php');
require('../../include/common.inc.php');

if (isset($_COOKIE['login_name'])) {
    $url = 'http://www.' . DOMAIN . '.com/dpsc/wd/select.php';
    header("Location:".$url);
    exit;
}

$sql = "SELECT Title, URL, PublishDate FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 114 ORDER BY PublishDate DESC LIMIT 5";
$res = $mysqli->query($sql);
$news_list = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $news_list[] = $row;
    }
}

$sql = "SELECT Photo, URL, Title FROM  91yxq_publish.91yxq_publish_1 WHERE NodeID = 109";
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
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>火焰神</title>
		<link rel="stylesheet" type="text/css" href="css/fire_index.css"/>
<!--	    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>-->
	    <link rel="stylesheet" type="text/css" href="layer/mobile/need/layer.css"/>
	</head>
	<body>
	
			<div class="fire_wrap">

		<!--下部-->
		<div class="fire_outline">
			<div class="fire_bottom">
			<img src="img/triangle.png" class="triangle_letp"/>
			<img src="img/triangle.png" class="triangle_rgtp"/>
			<img src="img/triangle.png" class="triangle_btle"/>
			<img src="img/triangle.png" class="triangle_borg"/>
			<div class="bottom_top">			
	          <img src="img/register.png"/>
	        <!--<p>游 戏 登 录</p>-->  
			</div>
			<div class="bottom_bottom">
			<form id="form" action="../../main.php?act=other_reg" method="post" onSubmit="return checkreg()">
              <input type="hidden" id="other_act" name="action" value="1" />
              <input type="hidden" name="type" value="dpsc" />
	          <div class="bottom_left fl">
	          	<div class="bttom_login bttom_register">
	          		<label>帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</label> 
	             	<input type="text" name="login_name" id="" value=""  class="reg_number"/>
	          	</div>
	          	<div class="bttom_login bttom_register">
	          		<label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</label> 
	             	<input type="password" name="login_pwd" id="" value=""  class="reg_pass"/>
	          	</div>
	          	<div class="bttom_login bttom_register">
	          		<label>确认密码：</label> 
	             	<input type="password" name="repeat_pwd" id="" value=""  class="reg_affpass"/>
	          	</div>
	          </div>
	          <div class="bottom_right fr">
	          	<div class="away_loregin">
	          		<img src="img/button.png"/>
	          		<!-- <a href="javascript:;"><p class="reg_register">确&nbsp;&nbsp;认</p></a> -->
                    <p class="reg_register"><button type="submit" style="font-size: 16px; height: 30px; background: none; border: none; color: #5f1d00; font-weight: bold;">确&nbsp;&nbsp;认</button></p>
	          	</div>
	          	 <div class="away_loregin">
	          	 	<img src="img/button.png"/>
	          	 	<a href="login.php"><p>取&nbsp;&nbsp;消</p></a>
	          	 </div>
	          </div>
			</form>

			</div>
		</div>
		</div>
		</div>
	</body>
	<script src="js/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/fire_index.js" type="text/javascript" charset="utf-8"></script>
<!--    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>-->
   <script src="layer/layer.js" type="text/javascript" charset="utf-8"></script>
    
</html>
