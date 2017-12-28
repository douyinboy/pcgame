<?php
require_once('../common/common.php');
require_once('include/cls.show_page.php');
require_once('include/ip.php');
include('include/isLogin.php');
$game_id = $_REQUEST['game_id'];
$server_id = $_REQUEST['server_id'];
$login_game = $_REQUEST['login_game'];
$login_server = $_REQUEST['login_server'];
$login_ip = GetIP();

if ( $_POST['act'] =='login' ) {
    $user_name = $_POST['user_name'];
        $remark = $_POST['remark'];
        if ($user_name=='') {
             echo "<script>alert('登录帐号不能为空！');history.back();</script>";die;
        }
        if ( trim($remark)=='' ) {
             echo "<script>alert('登录理由不能为空！');history.back();</script>";die;
        }
        $info="username=".$user_name;
        //获取用户信息
        $result = long_login_5a($info,time(),'info');
        $infos = explode('_@@_',$result);
        $time = time();
//    @_dq*3@DJl_5a_@
        $post_str = "act=getgameurl&sign=".md5($time."adsf")."&userid=".$infos[17]."&user_name=".$user_name."&time=".$time."&reg_time=".strtotime($infos[21])."&game_id=".$game_id."&server_id=".$server_id."&login_ip=113.107.150.57&fcm=1";
        $ch = curl_init( );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_URL, LOGIN_URL );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
        curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
        ob_start( );
        curl_exec( $ch );
        $contents = ob_get_contents( );
        ob_end_clean();
        curl_close( $ch );
        $game_url = $contents=='0' ?  INDEX_URL : $contents;

        echo "<script language='javascript'>location.href='$game_url'</script>";
        exit;
}
//本页面下拉框专用
$filter_2 = " WHERE 1 ";
if($game_id>0 ) {
	 $filter_2 .= " AND game_id=$game_id";
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$game_list_arr = $db ->find($sql);
$sql="SELECT server_id,name FROM ".PAYDB.".".SERVERLIST.$filter_2." order by server_id desc ";
$gs_list_arr = $db ->find($sql);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>登录玩家游戏</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript" >
function btnsubmit() {
    var login_game = $("#game_id").find("option:selected").text();
	var login_server = $("#server_id").find("option:selected").text();
	if ($("#remark").val() =='') {
	    alert('登录理由不能为空！');return false;
	}
	$("#login_game").val(login_game);
	$("#login_server").val(login_server);
	$("#myform").submit();
}
</script>
</HEAD>
<BODY>
<DIV align=left>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=400>
  <TBODY>
  <TR>
    <TD vAlign=top>
      <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
        <TBODY>
        <TR>
          <TD vAlign=top><font color='red'>如非必要请勿使用本功能，以免影响玩家正常游戏</font>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
			<form action="" name="myform" id="myform" method="post" target="_blank">
			  <INPUT value="login" type="hidden" name="act"> 
			  <INPUT value="" type="hidden" name="login_game" id="login_game">
			  <INPUT value="" type="hidden" name="login_server" id="login_server">
              <TBODY>
              <TR class=trEven>
                <TD>游戏：</TD>
                <TD>
                        <SELECT name="game_id" id="game_id" onChange="document.location.href='loginUserToGame.php?game_id='+this.value">
						<OPTION value="0" >请选择</OPTION>
                        <?php foreach( $game_list_arr as $val ) {?>
                        <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                        <?php }?>	
                        </SELECT>
					
                </TD></TR>
              <TR class=trEven>
                <TD>服务器：</TD>
                <TD><SELECT name="server_id" id="server_id">
				<OPTION value="0" >请选择</OPTION>
                    <?php foreach( $gs_list_arr as $val ) {?>
                        <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                        <?php } ?>	
                </SELECT>
                </TD>
              </TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name" maxlength="20"  ></TD></TR>
                <TR class=trEven>
                <TD>登录理由：</TD>
                <TD><label>
                  <textarea name="remark" cols="25" rows="4" id="remark"></textarea>
                </label></TD></TR>             
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="走起" type="submit" name="login"></TD>
              </TR>
              
              </TBODY></form></TABLE>
        </TABLE></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
