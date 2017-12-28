<?php
 /**=====================================
  * 广告入口文件
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 广告资源
 ========================================*/
include_once('../ban_game.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>6qwan《斩龙传奇》今年最好玩的游戏</title>
<script type="text/javascript" src="http://image.777wan.com/newvossion/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="http://image.777wan.com/jsCommon/userClass.js"></script>
</head>
<!--css样式-->
<style type="text/css">
*{ margin:0px; padding:0px;}
.turn_reg_log{
	font-size:20px;
	color:#ff0000;
	text-decoration:underline;
}
a:link,a:visited,a:hover{
	color:#ff0000;
	text-decoration:underline;
}
body {
	background-color: #000;
  font-size:12px; color:#fff;
  margin:0px auto;
}
.white {
	font-family: "宋体";
	font-size: 12px;
	color: #FFFFFF;
}
.a { padding:0 0 0 16px;}
.mine{ height:700px; left:0px; top:0px; position:absolute; width:1400px; z-index:0;}

#STYLE3 {
	color: #fff;
	font-weight: bold;
	font-size: 16px;
}

.Layer2 {
	position:relative;
	width:1400px;
	height:700px;
	margin:0px auto;

}
.Layer1 {
    background-image:url(images/image.png);
	background-position:0px 0px;
	position:absolute;
    z-index:103;
	width:511px;
	height:280px;
	padding-top:30px;
	display:block;
	 font-size:14px;
	color:#fff;
	top:200px;
	left:420px;
	font-weight:bold;
	line-height:24px;

}
.Layer1 table{ line-height:51px;}
.Layer1 span{ color:#fff; font-size:12px; font-weight:normal;}
.Layer1 table td{ margin:0px; padding:0px;}
.Layer1 table td .i1{ width:150px; height:24px;border:1px solid #fff}
.dm_input{ width:167px; height:58px; border:0px; background-image:url(images/button.jpg); margin-left:113px; display:block;}
.dm_input2{ width:167px; height:58px; border:0px; background-image:url(images/button2.jpg); margin-left:113px; display:block;}
.Layer3 {
    background-image:url(images/image_log.png);
	background-position:0px 0px;
	position:absolute;
    z-index:103;
	width:511px;
	height:280px;
	padding-top:30px;
	display:block;
	 font-size:14px;
	color:#fff;
	top:190px;
	left:470px;
	font-weight:bold;
	line-height:24px;

}
.Layer3 table{ line-height:51px;}
.Layer3 span{ color:#fff; font-size:12px; font-weight:normal;}
.Layer3 table td{ margin:0px; padding:0px;}
.Layer3 table td .i1{ width:150px; height:24px;border:1px solid #fff}

</style>


<!--css样式结束-->
<body>
<div class="Layer2"  >


<!-- 注册框 -->
<div class="Layer1" id='show'>
<form  style="margin: 0px" action="http://www.6qwan.com/api/reg_x.php" method="post" onsubmit="return checkFormChangeSelf(this)">
<table width="96%" height="180" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="34"></td>
    <td height="34"></td>
    <td height="34"></td>
  </tr>
  <tr>
    <td width="25%" height="27" align="right">注册用户名：</td>
    <td width="34%"><input type="text"id="login_name" name="login_name" onblur="getHits(this.value,'n_info');" class="i1"/></td>
    <td width="41%" align="left"><span id="n_info">用户名在4-20位之内</span></td>
  </tr>

  <tr>
    <td align="right" >输入密码：</td>
    <td>
      <input type="password" name="login_pwd" id="login_pwd" onblur="checkPwd(this.value)" class="i1"/></td>
    <td align="left"><span id="codeinfo2">请确保在6-18个字符</span></td>
  </tr>
  <tr>
    <td height="60" colspan="3" align="left" valign="bottom"><input type="submit" name="Submit" value=" " class="dm_input" />    </td>
    </tr>
</table>
<input name="act" type="hidden" id="act" value="1" />
<input name="game_id" type="hidden" id="game_id" value="<?php echo $game_id;?>" />
<input name="agent_id" type="hidden" id="agent_id" value="<?php echo $aid; ?>" />
<input name="placeid" type="hidden" id="placeid" value="<?php echo $pid;?>" />
<input name="server_id" type="hidden" id="adid" value="<?php echo $sid;?>" />
</form>
  </div>
  <!--注册框结束--> 
  
  <!-- 登录框 -->
  <div class="Layer3" id='show2' style="display:none;margin:75px 300px 0 -218px;">
<form onSubmit="return false;" action="" method="post" name="frmLogin" id="frmLogin">
<table width="96%" height="180" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="34"></td>
    <td height="34"></td>
    <td height="34"></td>
  </tr>
  <tr>
    <td width="25%" height="27" align="right">登录用户名：</td>
    <td width="34%"><input type="text" id="login_user" name="login_user" class="i1" value="" /></td>
    <td width="41%" align="left"><span id="n_info">用户名在4-20位之内</span></td>
  </tr>

  <tr>
    <td align="right" >输入密码：</td>
    <td>
      <input type="password" id="passwd" name="passwd" class="i1"	/></td>
    <td align="left"><span id="codeinfo2">请确保在6-18个字符</span></td>
  </tr>
  <tr>
    <td height="60" colspan="3" align="left" valign="bottom"><input type="submit" name="Submit" value=" " class="dm_input2" onclick="sentAdLoginData('jianzun');return false;"/>    </td>
    </tr>
  <tr>
	<td height="60" colspan="3" align="left" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;→→<a class="turn_reg_log" onclick="JavaScript:$('#show2').hide();$('#show').show()">点此注册新用户</a></td>
   </tr>
</table>
<input name="act" type="hidden" id="act" value="1" />
</form>
  </div>
    <!--登录框结束--> 
  <!--flash-->
<div class="mine">
 <div style=" width:1400px; height:700px; position:absolute">
   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="1400px" height="700">
     <param name="movie" value="index.swf" />
     <param name="quality" value="high" />
     <param name="wmode" value="transparent" />
    <param name="allowScriptAccess" value="always" >
     <embed src="index.swf" width="1400px" height="700" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always"></embed>
   </object>
 </div>
 </div> 
<!--flash结束-->
<!--js脚本-->
<script type="text/javascript">
function checkFormChangeSelf(theform){
    var usern =theform.login_name.value;
    var passw =theform.login_pwd.value;
	if (usern==""){
		alert("请输入用户名");theform.login_name.focus();return false; 
	}
	if (passw==""){
		alert("请输入密码");theform.login_pwd.focus();return false; 
	}
        if (passw.length < 6 || passw.length >18){
		alert("请控制密码长度在6-18个字符");theform.login_pwd.focus();return false; 
	}
}
function OpenDiv(){
document.getElementById('show').style.display= 'block';
}
</script>
<!--结束-->
</div>
</body>
</html>