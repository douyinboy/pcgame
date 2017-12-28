<?php
include_once('../ban_game.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>91yxq《<?php echo $arr['name'];?>》今年最好玩的游戏</title>
<link href="http://image.demo.com/css/ad.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://image.demo.com/newvossion/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="http://image.demo.com/jsCommon/userClass.js"></script>
</head>
<body>
<div class="Layer2"  >


<!-- 注册框 -->
<div class="Layer1" id='show'>
<form  style="margin: 0px" action="http://www.demo.com/api/reg_x.php" method="post" onsubmit="return checkFormChangeSelf(this)">
<table width="96%" height="180" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="34"></td>
    <td height="34"></td>
    <td height="34"></td>
  </tr>
  <tr>
    <td width="25%" height="27" align="right">注册用户名：</td>
    <td width="34%"><input type="text" id="login_name" name="login_name" onblur="getHits(this.value,'n_info');" class="i1"/></td>
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
 <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="1px" height="1">
     <param name="movie" value="sound.swf" />
     <param name="quality" value="high" />
     <param name="wmode" value="transparent" />
    <param name="allowScriptAccess" value="always" >
     <embed src="sound.swf" width="1px" height="1" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always"></embed>
   </object>
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