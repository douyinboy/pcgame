<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once ('include/cls.show_page.php');
$data = $_POST['data'];
$game_id=$_REQUEST['game_id']+0;
$sql="SELECT * FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$game_list_arr = $db->find($sql);
switch ($_REQUEST['act']){
    case 'add':
        if($data['sub']==1){
            unset($data['sub']);
            $sql="SELECT * FROM ".PAYDB.".".SERVERLIST." WHERE server_id=".$data['server_id']." AND game_id=".$data['game_id'];
            $arr= $db ->get($sql);
            if ($arr['server_id'] >0 ) {
                echo  '<script language="javascript">alert("服务器已存在添加失败！"); window.location.href="gameServerList.php"</script>';exit;
            }
            foreach ($data as $k=>$v){
                $acc.=$k."='".$v."',";
            }
            $sql=" INSERT INTO ".PAYDB.".".SERVERLIST." set ".  substr($acc, 0,-1);
            $db -> query($sql);
            echo  '<script language="javascript">alert("服务器添加成功！"); window.location.href="gameServerList.php"</script>';
            file_get_contents("http://pay.91yxq.com/games_servers_shell.php");
            exit;
        }
        break;
    case 'edit':
        if(empty($data['id'])){
            $id = $_REQUEST['id'];
            $sql="SELECT * FROM ".PAYDB.".".SERVERLIST." WHERE id=".$id;
            $data = $db ->get($sql);
        }
        if($data['sub']==1){
            unset($data['sub']);
            foreach ($data as $k=>$v){
                $acc.=$k."='".$v."',";
            }
            $sql = " UPDATE ".PAYDB.".".SERVERLIST." SET ".  substr($acc, 0,-1)." WHERE id = ".$data['id'];
            $db ->query($sql);
            echo  '<script language="javascript">alert("服务器更新成功！"); window.location.href="gameServerList.php?game_id='.$data['game_id'].'&page='.$_GET['page'].'"</script>';
            file_get_contents("http://pay.91yxq.com/games_servers_shell.php");
            exit;
        }
        break;
    default :
        break;
}
foreach($game_list_arr as $val){
    $game_arr[$val['id']]=$val['name'];
    $game_byname[$val['id']]=$val['game_byname'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>添加游戏服务器</TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
    <?php require_once('include/head_css_js.php');?>
    <script type="text/javascript">
        var pro_str=<?=json_encode($game_arr)?>;
        var pro_str_byname=<?=json_encode($game_byname)?>;
    </script>
</HEAD>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=619>
    <TBODY>
    <TR>
        <TD width="611" vAlign=top>
            <TABLE width="612" border=0 cellPadding=3 cellSpacing=1 class=table_list_auto>
                <TBODY>
                <TR>
                    <TD width="604" vAlign=top>
                        <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
                            <form action="" name="myform" id="myform" method="post" target="_self">
                                <INPUT value="<?=$_REQUEST['act']?>" type="hidden" name="act">
                                <INPUT value="<?=$id?>" type="hidden" name="data[id]">
                                <INPUT value="1" type="hidden" name="data[sub]">
                                <TBODY>
                                <TR class=trEven>
                                    <TD width="109">游    戏：</TD>
                                    <TD width="473">
                                        <SELECT name="data[game_id]" id="game_id" >
                                            <?php foreach( $game_list_arr as $val ) { ?>
                                                <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $data['game_id'] ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                                            <?php  } ?>
                                        </SELECT>
                                        <?php if($_REQUEST['act']=='add') {?>
                                            <input type="text" value="输入关键字" id="pro_keyword" size="8">
                                        <?php }?>
                                    </TD></TR>
                                <TR class=trEven>
                                    <TD>服务器序号：</TD>
                                    <TD><label>
                                            <input name="data[server_id]" type="text" id="server_id" value="<?=$data['server_id']?>">
                                            <span class="STYLE1">*</span></label></TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>服 务 器：</TD>
                                    <TD><label>
                                            <input type="text" name="data[name]" id="name" value="<?=$data['name']?>">
                                            <span class="STYLE1">*</span></label>
                                        格式：(X服)风云无双[双线]</TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>充值URL：</TD>
                                    <TD><label>
                                            <input name="data[pay_url]" type="text" id="pay_url" value="<?=$data['pay_url']?>" size="60">
                                            <span class="STYLE1">*</span></label></TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>开服时间：</TD>
                                    <TD><label>
                                            <input type="text" name="data[create_date]" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="create_date" value="<?=$data['create_date']?>">
                                            <span class="STYLE1">*</span></label></TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>状态：</TD>
                                    <TD>
                                        <input type="radio" name="data[is_open]" value="1" <?php if ( $data['is_open']==1 ) {echo 'checked';}?>>
                                        已开
                                        <input name="data[is_open]" type="radio" value="0" <?php if (!$data['is_open']) {echo 'checked';}?> >
                                        未开</TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>渠道状态：</TD>
                                    <TD>
                                        <input type="radio" name="data[channel_is_open]" value="1" <?php if ( $data['channel_is_open']==1 ) {echo 'checked';}?>>
                                        已开
                                        <input name="data[channel_is_open]" type="radio" value="0" <?php if (!$data['channel_is_open']) {echo 'checked';}?> >
                                        未开</TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>&nbsp;</TD>
                                    <TD><INPUT value="提交" type="submit" name="sumbit">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>
                                            <input type="reset" name="button" value="重置">
                                        </label></TD>
                                </TR>
                                </TBODY></form></TABLE>
            </TABLE></TD></TR></TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    search_pro();
</script>
</BODY></HTML>
