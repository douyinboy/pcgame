<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once ('include/cls.show_page.php');
$game_id=trim($_REQUEST["game_id"])+0;
$cdate=trim($_REQUEST["cdate"]);
$f=" ";
if($game_id >0){
    $f.=" and a.game_id=$game_id";
}
if($cdate){
    $f.=" and a.create_date>='$cdate' and a.create_date<='$cdate 23:59:59'";
}
$state=1;
switch ($_GET['act']){
    case 'is_open':
        $sql="UPDATE ".PAYDB.".".SERVERLIST." SET is_open=1 WHERE id=".$_GET['id'];
        break;
    case 'is_close':
        $sql="UPDATE  ".PAYDB.".".SERVERLIST." SET is_open=0 WHERE id=".$_GET['id'];
        break;
    case 'channel_is_open':
        $sql="UPDATE ".PAYDB.".".SERVERLIST." SET channel_is_open=1 WHERE id=".$_GET['id'];
        break;
    case 'channel_is_close':
        $sql="UPDATE  ".PAYDB.".".SERVERLIST." SET channel_is_open=0 WHERE id=".$_GET['id'];
        break;
    case 'delete':
        $sql="DELETE FROM ".PAYDB.".".SERVERLIST." WHERE id=".$_GET['id'];
        break;
    default :
        $state=0;
        break;
}
if($state > 0) {
    $db->query($sql);
    file_get_contents("http://pay.91yxq.com/games_servers_shell.php");
}
$sql="select a.*,b.name as game_name from ".PAYDB.".".GAMELIST." b, ".PAYDB.".".SERVERLIST." a where a.game_id=b.id $f";
$sql .=" ORDER BY a.create_date DESC";
$page = new ShowPage;
$page->PageSize = 25;
$page->Total = $db -> countsql($sql);
$sql.=" limit  ".$page->OffSet();
$game_server_arr = $db ->find($sql);
$showpage = $page->ShowLink();
$sql="SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_list_arr = $db->find($sql);
foreach($game_list_arr as $val){
    $game_arr[$val['id']]=$val['name'];
    $game_byname[$val['id']]=$val['game_byname'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
    <TITLE></TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
    <?php require_once('include/head_css_js.php');?>
    <META name=GENERATOR content="MSHTML 8.00.6001.18702">
</HEAD>
<script language="javascript" type="text/javascript">
    function btnsubmit() {
        $("#myform").attr("action","gameServerList.php?game_id="+$("#game_id").val());
        $("#myform").submit();
    }
</script>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
    <TBODY>
    <TR class=trEven>
        <TD>
            <DIV class=divOperation>
                <FORM id="myform" method="post" name="myform" action="http://admin.91yxq.com/index.php?action=colligate&opt=index&menu=gameServerList&navTabId=grant1402">
                    <INPUT id="act" type=hidden name="act" value="serach" >
                    &nbsp;&nbsp;
                    <a href="gameServerListEdit.php?act=add"><INPUT value="添加" type="button" name="add" ></a>
                    &nbsp;&nbsp;游戏：
                    <SELECT name="game_id" id="game_id">
                        <OPTION label="所有游戏" value="" >所有游戏</OPTION>
                        <?php foreach( $game_list_arr as $val ) {?>
                            <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                        <?php } ?>
                    </SELECT>
                    <input type="text" value="输入关键字" id="pro_keyword" size="8">
                    &nbsp;&nbsp;开服日期：<input type="text" name="cdate" size="10" value="<?php echo $cdate;?>" onClick="WdatePicker();" />
                    &nbsp;&nbsp;<INPUT class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();" >
                </FORM>
            </DIV>
        </TD>
    </TR>
    </TBODY>
</TABLE>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1004 height=40>
    <TBODY>

    <TR class=table_list_head>
        <TD width="10%" align=middle>游戏</TD>
        <TD width="6%" align=middle>服务器ID</TD>
        <TD width="16%" align=middle>游戏服务器</TD>
        <TD width="9%" align=middle>状态</TD>
        <TD width="9%" align=middle>渠道状态</TD>
        <TD width="15%" align=middle>开服时间</TD>
        <TD width="20%" align=middle>充值地址</TD>
        <TD width="17%" align=middle>操作管理</TD>
    </TR>
    <?php
    $i = 0;
    foreach( $game_server_arr as $val ) {
        if ($val['is_open']) {
            $stat="<a href='?act=is_close&id=".$val['id']."'><font color='#00FF33'><strong>已开启</strong></font></a>";
        }
        else {
            $stat="<a href='?act=is_open&id=".$val['id']."'><font color='#FF0000'><strong>未开</strong></font></a>";
        }
        if ($val['channel_is_open']) {
            $channel_stat="<a href='?act=channel_is_close&id=".$val['id']."'><font color='#00FF33'><strong>已开启</strong></font></a>";
        }
        else {
            $channel_stat="<a href='?act=channel_is_open&id=".$val['id']."'><font color='#FF0000'><strong>未开</strong></font></a>";
        }
        ?>
        <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
            <TD align=center><?=$val['game_name']?></TD>
            <TD align=left><?=$val['server_id']?></TD>
            <TD align=left><?=$val['name']?></TD>
            <TD align=center><?=$stat?></TD>
            <TD align=center><?=$channel_stat?></TD>
            <TD align=center><?=$val['create_date']?></TD>
            <TD align=left><?php if($val['pay_url']==''){ echo '<font color="red">请修改充值地址！</font>'; } else { echo $val['pay_url']; }?></TD>
            <TD align=center><a href="gameServerListEdit.php?act=edit&id=<?=$val['id']?>&page=<?=$page->PageNum()?>"><strong>修改</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?act=delete&id=<?=$val['id']?>" onClick="return confirm('确认删除吗?不可恢复！！！')"><strong><font color="red">删除</font></strong></a></TD>
        </TR>
    <?php  } ?>
    </TBODY></TABLE>
<DIV align=center><?=$showpage?></DIV>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    var pro_str=<?=json_encode($game_arr)?>;
    var pro_str_byname=<?=json_encode($game_byname)?>;
    search_pro();
</SCRIPT>
</BODY>
</HTML>
