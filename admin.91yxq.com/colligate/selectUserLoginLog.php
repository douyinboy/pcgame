<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once('include/cls.show_page.php');
require_once('include/ip.php');
$user_name=trim($_REQUEST["user_name"]);
$ip = ip2long(trim($_REQUEST["ip"]));
$mon=$_REQUEST["mon"];
if ($mon=='') {
    $mon =date("Y-m");
}
$login_logs_arr = array();
if ( ($_POST['act'] =='serach' && ($user_name || $ip)) || $_GET['page'] ) {        
    $mon = date("Ym",strtotime($mon));
    $where=" where 1 ";
    if ($user_name && $ip) {
        $where.=" and user_name='".$user_name."' and ip='".$ip."'";
    } else if ($user_name=='' && $ip) {
        $where.=" and ip='".$ip."'";
    } else if ($ip=='' && $user_name) {
        $where.=" and user_name='".$user_name."'";
    }
    $sql="select count(*) as  from ".GAMELOGIN.GLOLOG.$mon.$where." order by login_time desc";
    $page = new ShowPage;
    $page->PageSize = 25;;
    $page->Total = $db -> countsql($sql);
    $sql.=" limit  ".$page->OffSet();
    $login_logs_arr = $db ->find($sql);
    $showpage = $page->ShowLink();
//获取链接公会id
    $sql="select reg_time from ".USERDB.".".USERS." where user_name='".$user_name."'";
    $r = $db -> get($sql);
    $y = date("Y",$r['reg_time']);
    $y < 2015 && $y=2015;
    $r2 = $db4 -> getone("select agent_id from ".USERS.".".REGINDEX.$y." where user_name='".$user_name."'");
    if(empty($r2)){
        foreach ($login_logs_arr as $vv){
            $sql="select agent_id from ".USERS.".".REGINDEX.$y." where user_name='".$vv['user_name']."'";
            $r2[$vv['user_name']] = $db -> get($sql);
        }
    }
    $mon =date("Y-m",strtotime($mon));
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_list_arr = $db ->find($sql);
$game_arr = array();
foreach ($game_list_arr as $val) {
    $game_arr[$val['id']] = $val['name'];
}
$sql="select game_id,server_id,name from ".PAYDB.".".SERVERLIST." order by server_id desc";
$game_server_list_arr = $db ->find($sql);
foreach($game_server_list_arr as $val){
    $game_server_arr[$val['game_id']][$val['server_id']]=$val['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>查询玩家登陆日志</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
   $("#myform").attr("action","?user_name="+$("#user_name").val()+"&ip="+$("#ip").val()+"&mon="+$("#mon").val());
   $("#myform").submit();
   }
</script>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
      <FORM id="myform" method="post" name="myform" action="">
      <INPUT id="act" type=hidden name="act" value="serach" > 
      &nbsp;&nbsp;玩家帐号：
      <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=20 >
      &nbsp;&nbsp;登录IP:
      <INPUT  value="" size=15 name="ip" id="ip">
      &nbsp;&nbsp;登录时间：
        <INPUT value="<?=$mon?>" onClick="WdatePicker({dateFmt:'yyyy-MM'})"  size=12 name="mon" id="mon"> 
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();">
      </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
      玩家登录信息查询<BR>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1004 height=40>
  <TBODY>
  
  <TR class=table_list_head>
    <TD width="4%" align=middle>序号</TD>
    <TD width="9%" align=middle>登录帐号</TD>
     <TD width="9%" align=middle>注册公会id</TD>
    <TD width="10%" align=middle>登录游戏</TD>
    <TD width="15%" align=middle>游戏服务器</TD>
    <TD width="13%" align=middle>注册时间</TD>
    <TD width="17%" align=middle>登录时间</TD>
    <TD width="20%" align=middle>IP详细</TD>
  </TR>
  <?php 
  $QQWry=new QQWry;
  $i = 0;
  foreach( $login_logs_arr as $val ) 
   {
        $ip=long2ip($val['ip']);
        $area ='';
        $ifErr=$QQWry->QQWry($ip);
        $ipaddr[$ip]=$QQWry->Country."&nbsp;".$QQWry->Local;
        $area=$ipaddr[$ip];
  ?>
  <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
    <TD align=middle><?=$i?></TD>
    <TD align=middle><?=$val['user_name']?></TD>
    <TD align=middle><?php if(empty($r2['agent_id'])){ echo $r2[$val['user_name']]['agent_id'];}else{ echo $r2['agent_id'];}?></TD>    
    <TD align=middle><? if ($game_arr[$val['game_id']]) echo $game_arr[$val['game_id']];else echo '游戏ID：'.$val[$val['game_id']];?></TD>
    <TD align=middle><?=$game_server_arr[$val['game_id']][$val['server_id']]?$game_server_arr[$val['game_id']][$val['server_id']]:$val['server_id'].'服'?></TD>
    <TD align=middle><?=date('Y-m-d H:i:s',$val['reg_time'])?></TD>
    <TD align=middle><?=date('Y-m-d H:i:s',$val['login_time'])?></TD>
    <TD align=middle><?=$ip?>(<?=iconv("gb2312","utf-8",$area)?>)</TD>
  </TR>
  <?php } ?>
</TBODY></TABLE>
    <DIV align=left><?=$showpage?>
    </DIV>	
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
