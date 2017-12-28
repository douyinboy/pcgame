<?php
require_once('../common/common.php');
include('include/isLogin.php');
$tdate=$_POST['tdate'];
$user_name=$_POST['user_name'];
$orderid=$_POST['orderid'];
$state=$_POST['state']?$_POST['state']:4;
if (!$tdate) {
    $tdate=date("Y-m-d");
}
$where=" where platform_id=1 and addtime>='$tdate' and addtime<='$tdate 23:59:59'";
if($user_name){
    $where.=" and username='$user_name'";
}
if($orderid){
    $where.=" and orderid='$orderid'";
}
if($state){
    $where.=" and state='$state'";
}
$sql="SELECT * FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_list_arr = $db->find($sql);
foreach($game_list_arr as $v){
    $game_arr[$v['id']]=$v['name'];
}
$sql="select * from ".YYDB.".".KFAPPLYYB." $where";
$res=$db ->find($sql);

$pay_state=array(1=>"<font color='blue'>不予处理</font>",2=>"<font color='green'>发放成功</font>",3=>"<font color='red'>发放失败",4=>"未处理");
$pay_type=array(
"101"=>"人工充值",
"102"=>"帐号充错补发",
"103"=>"帐号充错游戏补发",
"104"=>"帐号充错服务器补发",
"105"=>"充值成功元宝未发",
"106"=>"充值成功,但是元宝发放查询没记录");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>元宝补发申请列表</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?> 
<script language="javascript" type="text/javascript">
   function btnsubmit() {
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
       &nbsp;&nbsp;申请日期：
	  <INPUT value="<?=$tdate?>" onClick="WdatePicker()"  size=10 name="tdate" id="tdate">
      &nbsp;&nbsp;充值帐号：
      <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=15 >
      &nbsp;&nbsp;订单号：
        <INPUT value="<?=$orderid?>" size="20" name="orderid" id="orderid">
      &nbsp;&nbsp;订单状态：
       <SELECT name="state">
       <option>请选择</option>
       <option value="1" <?php if ( 1 == $state ) { echo 'selected="selected"'; }?>>不予处理</option>
       <option value="2" <?php if ( 2 == $state ) { echo 'selected="selected"'; }?>>发放成功</option>
       <option value="3" <?php if ( 3 == $state ) { echo 'selected="selected"'; }?>>发放失败</option>
       <option value="4" <?php if ( 4 == $state ) { echo 'selected="selected"'; }?>>未处理</option>
       </SELECT>
	  &nbsp;&nbsp;游戏：
        <SELECT name="game_id" id="game_id" >
		 <OPTION value="0">全部游戏</OPTION>
                 <?php  foreach( $game_list_arr as $val ) { ?>
                      <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                 <?php } ?>	
         </SELECT>
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
		</FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<?php 
if ( $res) {  ?>
    <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1226 height=40>
        <TBODY>
            <TR class=table_list_head>	
                <TD align=middle>玩家帐号</TD>
                <TD align=middle>充值订单号</TD>
                <TD align=middle>充值元宝数</TD>
                <TD align=middle>充值游戏</TD>
                <TD align=middle>充值服务器</TD>
                <TD align=middle>补发原因</TD>
                <TD align=middle>备注</TD>
                <TD align=middle>申请人</TD>
                <TD align=middle>申请时间</TD>
                <TD align=middle>申请状态</TD>
                <TD align=middle>审核人</TD>
                <TD align=middle>审核时间</TD>
                <TD>--</TD>
            </TR>
         <?php foreach ($res as $val) { ?>
                <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
                <TD align=middle><?=$val['username']?></TD>
                <TD align=middle><?=$val['orderid']?></TD>
                <TD align=middle><?=$val['gold']?></TD>
                <TD align=middle><?=$game_arr[$val['game_id']]?></TD>
                <TD align=middle><?=$val['server_id']?></TD>
                <TD align=middl><?=$pay_type[$val['pay_type']]?></TD>
                <TD width="500"><?=$val['pay_memo']?></TD>
                <TD align=middle><?=$val['addautor']?></TD>
                <TD align=middle><?=$val['addtime']?></TD>
                <TD align=middle><?=$pay_state[$val['state']]?></TD>
                <TD align=middle><?=$val['editautor']?></TD>
                <TD align=middle><?=$val['edittime']?></TD>
                <TD><?php if($val['state']>2){ ?> <a onClick="return confirm('确认忽略该申请订单:<?=$val['orderid']?>？');" href="yb_reissue_apply_pass.php?do=del&id=<?=$val['id']?>&sign=<?=md5($val['id'].$val['orderid'].$val['username'])?>">不予处理</a> &nbsp;  <a onClick="return confirm('确认发放元宝？订单号:<?=$val['orderid']?>');" href="yb_reissue_apply_pass.php?do=pay&id=<?=$val['id']?>&sign=<?=md5($val['id'].$val['orderid'].$val['username'])?>">发放元宝</a><?php } ?></TD>
                </TR>
<?php }  } ?>
		  </TBODY></TABLE>

<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
