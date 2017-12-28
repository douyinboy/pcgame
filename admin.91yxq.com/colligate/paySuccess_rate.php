<?php
require_once('../common/common.php');
include('include/isLogin.php');	
include("include/pay_way.inc.php");
$date1=$_REQUEST["date1"];
$date2=$_REQUEST["date2"];
$game_id=trim($_REQUEST["game_id"]);
$server_id=trim($_REQUEST["server_id"]);
$pay_way_id=$_REQUEST["pay_way_id"];
$data =  array();
if (!$date1) {
    $date1=date("Y-m-01");
}
if (!$date2) {
    $date2=date("Y-m-d");
}
$filter = "where 1";
if ($game_id>0) {
    $filter.=" and game='$game_id'";
    $server_list_arr = $db ->find("select server_id,name from ".PAYDB.".".SERVERLIST." where  game_id=$game_id and is_open=1 order by server_id DESC");
}
if($server_id>0){
    $filter.=" and server='$server_id'";
}
if ($pay_way_id>0) {
     $filter.=" and pay_channel='$pay_way_id'";
}
$tdate = $date1;
while ($tdate <=$date2) {
    $s_time = strtotime($tdate." 00:00:00");
    $e_time = strtotime($tdate." 23:59:59");
    $sql = "select count(orderid) as num,count(distinct user) as payer,sum(money) as money,succ from ".PAYDB.".".PAYORDER." $filter  and game !=0 and server !=0 and pay_date>=$s_time and pay_date<=$e_time group by succ";
    $res=$db->find($sql);
    foreach ($res as $v) {
        if ($v['succ']==1) {
            $data[$tdate]['succ_num'] = $v['num']+0;
            $data[$tdate]['succ_payer'] = $v['payer']+0;
            $data[$tdate]['succ_money'] = $v['money']+0;
        }
        $data[$tdate]['num']+=$v['num']+0;
        $data[$tdate]['payer']+=$v['payer']+0;
    }
    $tdate = date('Y-m-d',strtotime($tdate)+86400);
}
//unset($data['2012-05-22']);unset($data['2012-05-23']);
$game_list_arr = $db ->find("SELECT id,name FROM ".PAYDB.".".GAMELIST." $s ");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>充值成功率</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
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
      &nbsp;&nbsp;日期：
            <INPUT value="<?=$date1?>" onClick="WdatePicker()"  size=12 name="date1" id="date1"> -
            <INPUT value="<?=$date2?>" onClick="WdatePicker()"  size=12 name="date2" id="date2">
      &nbsp;&nbsp;      &nbsp;游戏：
            <SELECT name="game_id" id="game_id" onChange="document.location.href='paySuccess_rate.php?game_id='+this.value+'&pay_way_id='+$('#pay_way_id').val()">
                <OPTION label="所有游戏" value="" >所有游戏</OPTION>
             <?php  foreach( $game_list_arr as $val ) {?>
                <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
            <?php  } ?>	
           </SELECT>
         &nbsp;服：<SELECT name="server_id" id="server_id">
            <OPTION label="所有服" value="" >所有服</OPTION>
       <?php foreach( $server_list_arr as $val ) {?>
            <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
      <?php  }?>	
        </SELECT>
	 &nbsp;&nbsp;
	 支付渠道：
        <SELECT name="pay_way_id" id="pay_way_id">
            <option value="">全部</option>
            <?php foreach ($pay_way_arr as $kk=>$vv){?>
            <option value="<?=$kk?>" <?php if ($pay_way_id==$kk) echo 'selected="selected"';?>><?=$vv['payname']?></option>
            <?php }?>
        </SELECT>
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
		注：本数据半小时更新一次
        </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1230 height=40>
  <TBODY>
    <TR class=table_list_head>
        <TD width="8%" align=middle>日期</TD>
        <TD width="8%" align=middle>提交次数</TD>
        <TD width="6%" align=middle>提交人数</TD>
        <TD width="8%" align=middle>成功次数</TD>
        <TD width="17%" align=middle>成功人数</TD>
        <TD width="19%" align=middle>成功金额</TD>
        <TD width="25%" align=middle>订单成功率</TD>
  </TR>
<?php
    $j=0;
    foreach($data as $d=>$val) {
        $sum_num+=$val["num"];
        $sum_payer+=$val["payer"];
        $sum_succ_num+=$val["succ_num"];
        $sum_succ_payer+=$val["succ_payer"];
        $sum_succ_money+=$val["succ_money"];
?>
    <TR id=newooo class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven';?>"  height="100%" name="newooo">
        <TD align=center><?=empty($d) ? "0":$d?></TD>
        <TD align=center><?=empty($val["num"]) ? "0":$val['num']?></TD>
        <TD align=center><?=empty($val["payer"]) ? "0":$val["payer"]?></TD>
        <TD align=center><?=empty($val["succ_num"]) ? "0":$val["succ_num"]?></TD>
        <TD align=center><?=empty($val["succ_payer"]) ? "0":$val["succ_payer"]?></TD>
        <TD align=center><?=round($val["succ_money"],2)?></TD>
        <TD align=center><?=$val["num"]>0 ? round($val["succ_num"]/$val["num"],4)*100 : 0?>%</TD>
    </TR>
 <?php $j++;}?>
    <TR id=newooo class="trEven"  height="100%" name="newooo">
        <TD align=center><font color='red'>合计:</font></TD>
        <TD align=center><?=$sum_num?></TD>
        <TD align=center><?=$sum_payer?></TD>
        <TD align=center><?=$sum_succ_num?></TD>
        <TD align=center><?=$sum_succ_payer?></TD>
        <TD align=center><?=round($sum_succ_money,2)?></TD>
        <TD align=center>平均：<?=$sum_num>0 ? round($sum_succ_num/$sum_num,4)*100 : 0?>%</TD>
    </TR>
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
