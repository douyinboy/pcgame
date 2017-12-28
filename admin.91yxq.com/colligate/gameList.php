<?php
require_once('../common/common.php');
include('include/isLogin.php');
$act=trim($_REQUEST["act"]);
$id = $_REQUEST["id"]+0;
switch($act){
    case 'modify':
        if($id >0){
            $sql="SELECT * FROM ".PAYDB.".".GAMELIST." WHERE id=".$id;
            $data = $db->get($sql);
        }
    break;
    case 'domodify':    //添加 修改
        $data = $_REQUEST['data'];
        if($id >0){ //修改
            $arr_tmp = preg_split('/\r\n/', trim($data['result_code']));
            $result_code = array();
            foreach ($arr_tmp as $v) {
                $av = explode(":",$v);
                $result_code[$av[0]] = $av[1];
            }
            unset($v);
            $data['result_code'] = serialize($result_code);
            foreach ($data as $k=>$v){
                $acc.=$k."='".$v."',";
            }
            $acc=  substr($acc, 0,-1);
            $sql = 'UPDATE '.PAYDB.'.'.GAMELIST.' SET '.$acc.' WHERE id = '.$id;
            $db ->query($sql);
            $sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where 1 order by id desc ";
            $garr=$db ->find($sql);
            foreach($garr as $gr){
                $game_arr[$gr['id']]=$gr['name'];
            }
            $gl_str=serialize($game_arr);
            echo  '<script language="javascript">alert("游戏修改成功！"); window.location.href="gameList.php";</script>';
            file_get_contents("http://pay.91yxq.com/games_servers_shell.php");
            die;
        }else{ //添加
            $data = $_REQUEST['data'];
            $arr_tmp = preg_split('/\r\n/', trim($data['result_code']));
            $result_code = array();
            foreach ($arr_tmp as $v) {
                    $av = explode(":",$v);
                    $result_code[$av[0]] = $av[1];
            }
            unset($v);
            $data['result_code'] = serialize($result_code);
            $data['result_code'] = serialize($result_code);
            foreach ($data as $k=>$v){
                $acc.=$k."='".$v."',";
            }
            $acc=  substr($acc, 0,-1);
            $sql=" INSERT INTO ".PAYDB.".".GAMELIST." set ".$acc;
            $db -> query($sql);
            $db -> query("CREATE TABLE IF NOT EXISTS ".PAYDB.".`pay_".$data['game_byname']."_log` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `orderid` varchar(30) NOT NULL,
            `user_name` varchar(40) NOT NULL,
            `money` smallint(5) NOT NULL,
            `paid_amount` decimal(7,2) NOT NULL,
            `pay_type` tinyint(3) NOT NULL,
            `pay_gold` mediumint(8) NOT NULL,
            `sign` varchar(32) NOT NULL,
            `pay_date` datetime NOT NULL,
            `user_ip` varchar(19) NOT NULL,
            `back_result` tinyint(1) NOT NULL,
            `pay_result` varchar(30) NOT NULL,
            `server_id` smallint(5) NOT NULL,
            `remark` varchar(30) NOT NULL,
            `stat` tinyint(1) NOT NULL,
            `pay_url` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `orderid` (`orderid`),
            KEY `user_name` (`user_name`),
            KEY `pay_date` (`pay_date`),
            KEY `stat` (`stat`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
            $sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where 1 order by id desc ";
            $garr=$db ->find($sql);
            foreach($garr as $gr){
                $game_arr[$gr['id']]=$gr['name'];
            }
            unset($gr);
            $gl_str=serialize($game_arr);
            echo  '<script language="javascript">alert("游戏添加成功！"); window.location.href="gameList.php";</script>';
            file_get_contents("http://pay.91yxq.com/games_servers_shell.php");
            die;
        }
    break;
    default:
        $sql="SELECT * FROM ".PAYDB.".".GAMELIST." where 1  order by id desc";
        $game_list_arr = $db ->find($sql);
    break;
}
$sql="select * from  ".YYDB.".".COMPANY." order by name desc";
$res=$db->find($sql);
foreach($res as $val){
    $company_list[$val['id']]=$val['name'];
}  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE></TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702">
<?php require_once('include/head_css_js.php');?>
</HEAD>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
       $("#myform").attr("action","?platform_id="+$("#platform_id").val()+"&game_id="+$("#game_id").val());
       $("#myform").submit();
   }
</script>
<BODY>
<?php if ( $act=='modify' ) { ?>
<TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
    <form action="" name="myform" id="myform" method="post" target="_self">
        <INPUT value="domodify" type="hidden" name="act">
        <TBODY>
            <TR class=trEven>
                <TD width="136">游戏ID：</TD>
                <TD width="446"><input name="data[id]" type="text" id="data[id]" value="<?=$data['id']?>"><label> <span class="STYLE1"> *</span></label>格式：1</TD>
            </TR>
            <TR class=trEven>
                <TD width="136">游戏名称：</TD>
                <TD width="446"><input name="data[name]" type="text" id="data[name]" value="<?=$data['name']?>"><label> <span class="STYLE1"> *</span></label>格式：风云无双</TD>
            </TR>
            <TR class=trEven>
                <TD>游戏简写：</TD>
                <TD><label><input name="data[game_byname]" type="text" id="data[game_byname]" value="<?=$data['game_byname']?>"><span class="STYLE1">*格式：fyws</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>游戏币名称：</TD>
                <TD><label><input type="text" name="data[b_name]" id="data[b_name]" value="<?=$data['b_name']?>"><span class="STYLE1">*</span></label>格式：元宝</TD>
            </TR>		
            <TR class=trEven>
                <TD>兑换比例：</TD>
                <TD><label><span class="STYLE1"><input type="text" name="data[exchange_rate]" id="data[exchange_rate]" value="<?=$data['exchange_rate']?>">*格式：10</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>排行：</TD>
                <TD><label><input type="text" name="data[rank]" id="data[rank]" value="<?=$data['rank']?>"><span class="STYLE1">*格式：1</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>充值成功返回值：</TD>
                <TD><label><input type="text" name="data[back_result]" id="data[back_result]" value="<?=$data['back_result']?>"><span class="STYLE1">*格式：pay_succ</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>结果返回值说明：</TD>
                <TD><label><textarea cols="30" rows="10" name="data[result_code]" id="data[result_code]" ><?php if (trim($data['result_code'])!='') {$result_code = unserialize(trim($data['result_code']));}else {$result_code=array();} foreach ($result_code as $key => $v) echo $key.":".$v."\n";?></textarea><span class="STYLE1">*格式：1:充值成功</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>充值地址：</TD>
                <TD><input type="text" name="data[pay_url]" id="data[pay_url]" value="<?=$data['pay_url']?>" size="20"><span class="STYLE1">*格式：http://s{*}.qs.91yxq.com</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>公会分成比例：</TD>
                <TD><input type="text" name="data[fuildfc]" id="data[fuildfc]" value="<?=empty($data['fuildfc']) ? "60":$data['fuildfc']?>" size="20"><span class="STYLE1">*浮点数：比如输入32.5则表示32.5%</span></label></TD>
            </TR>
            <TR class=trEven>
                <TD>开启状态：</TD>
                <TD><label><input type="radio" name="data[is_open]" value="1" <?php if ($data['is_open']==1) echo 'checked';?>>
                  开启
                <input name="data[is_open]" type="radio" value="0" <?php if ($data['is_open']==0) echo 'checked';?>>
                  关闭
                </label>
                </TD>
            </TR>
            <TR class=trEven>
                <TD>游戏归属：</TD>
                <TD>
                    <SELECT name="data[owner]">
                        <?php foreach($company_list as $cid=>$cname){ ?>
                        <OPTION value="<?=$cid?>" <?php if ($data['owner']==$cid) echo 'selected="selected"';?>><?=$cname?></OPTION>
                        <?php } unset($cid); unset($cname);?>
                    </SELECT>
                </TD>
            </TR>
            <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="提交" type="submit" name="sumbit">&nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="reset" name="button" value="重置"></label></TD>
            </TR> 
        </TBODY></form>
</TABLE>
<?php }  else {?>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
	&nbsp;&nbsp;
        <a href="gameList.php?act=modify"><INPUT value="添加" type="button" name="add" ></a>	 
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1233 height=40>
  <TBODY>
  
  <TR class=table_list_head>
    <TD width="7%" align=middle>游戏ID</TD>
    <TD width="10%" align=middle>游戏名称</TD>
    <TD width="5%" align=middle>简称</TD>
    <TD width="7%" align=middle>游戏货币名</TD>
    <TD width="7%" align=middle>游戏币比例</TD>
    <TD width="7%" align=middle>排名</TD>
    <TD width="7%" align=middle>充值成功返回值</TD>
    <TD width="7%" align=middle>充值地址</TD>
    <TD width="10%" align=middle>所属开发商</TD>
    <TD width="10%" align=middle>开启状态</TD>
    <TD width="10%" align=middle>操作管理</TD>
  </TR>
<?php 
  $i = 0;
  foreach( $game_list_arr as $val ) { ?>
    <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
        <TD align="center"><?=$val['id']?></TD>
        <TD align="center"><?=$val['name']?></TD>
        <TD align="center"><?=$val['game_byname']?></TD>
        <TD align="center"><?=$val['b_name']?></TD>
        <TD align="center">1:<?=$val['exchange_rate']?></TD>
        <TD align="center"><?=$val['rank']?></TD>
        <TD align="center"><?=$val['back_result']?></TD>
        <TD align="left"><?=$val['pay_url']?></TD>
        <TD align="center"><?=$company_list[$val['owner']]?></TD>
        <TD align="center"><?php if ($val['is_open']==1) echo '<font color="#00FF66">开启</font>';else echo '<font color="#FF0000">关闭中</font>';?></TD>
        <TD align="center"><a href="gameList.php?act=modify&id=<?=$val['id']?>"><strong>修改</strong></a></TD>
    </TR>
  <?php } ?>
</TBODY></TABLE>
<?php } ?>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
