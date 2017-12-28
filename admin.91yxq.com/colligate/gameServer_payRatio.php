<?php
require_once('../common/common.php');
include('include/isLogin.php');	
$server_id=$_REQUEST["server_id"];
$game_id=$_REQUEST["game_id"]+0;
$maxday=$_REQUEST["maxday"]+0;
if(!$maxday){ $maxday=30; }
$filter=" where game_id='$game_id'";
$game_list_arr = $db ->find("SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST." where 1 order by id desc");
//区服
$game_server_list = $db ->find("select distinct(server_id),name from ".PAYDB.".".SERVERLIST.$filter." and is_open=1 order by server_id desc");
if ($server_id) {
    $filter.=" and server_id='$server_id'";
}
$game_server_list_arr = $db ->find("select distinct(server_id),name,create_date from ".PAYDB.".".SERVERLIST.$filter." and is_open=1 order by server_id desc");
$game_server_arr = array();
foreach($game_server_list_arr as $val){
    $game_server_arr[$val['server_id']]['name']=$val['name'];
    $game_server_arr[$val['server_id']]['time']=$val['create_date'];
    $sdate=date('Y-m-d',strtotime($val['create_date']));
    $edate = date('Y-m-d',strtotime($val['create_date'])+86400*$maxday);
    $sql="select sum(money) as money,date_format(pay_date,'%Y-%m-%d') as pdate from ".PAYDB.".".PAYLIST." where game_id !=0 AND server_id !=0 and game_id=$game_id and server_id=".$val['server_id']." and pay_date>='$sdate 00:00:00' and pay_date<='$edate 23:59:59' group by pdate order by pdate ASC limit $maxday";
    $data = $db ->find($sql);
    foreach ($data as $val2) {
        $game_server_arr[$val['server_id']]['income'][$val2['pdate']] = round($val2['money'],2);
    }
}
foreach($game_list_arr as $val){
    $game_arr[$val['id']]=$val['name'];
    $game_byname[$val['id']]=$val['game_byname'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>各服开服收入对比</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<script type="text/javascript" src="js/calendar.js" ></script>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
        $("#myform").attr("action","?user_name="+$("#user_name").val()+"&date1="+$("#date1").val()+"&date2="+$("#date2").val()+"&agent_id="+$("#agent_id").val()+"&game_id="+$("#game_id").val()+"&server_id="+$("#server_id").val());
        $("#myform").submit();
   }
var pro_str=<?=json_encode($game_arr)?>;
var pro_str_byname=<?=json_encode($game_byname)?>;
</script>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
      <FORM id="myform" method="post" name="myform" action="">
            <INPUT id="act" type=hidden name="act" value="serach" >
             <span style=color:red;>请选择要查看游戏</span>
          &nbsp;游戏：
          <SELECT name="game_id" id="game_id" onChange="document.location.href='gameServer_payRatio.php?game_id='+this.value;">
              <OPTION label="请选择游戏" value="" >请选择游戏</OPTION>
            <?php foreach( $game_list_arr as $val ) {?>
               <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
           <?php  }?>	
         </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
             &nbsp;&nbsp;
             服务器：
             <SELECT name="server_id" id="server_id">
              <OPTION label="所有区服" value="" >所有区服</OPTION>
            <?php foreach( $game_server_list as $val ) {?>
               <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id']== $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
           <?php } ?>	
         </SELECT>
         对比天数：
            <SELECT name="maxday" id="maxday">
            <?php for($d=1;$d<=30;$d++) {?>
               <OPTION value="<?=$d?>" <?php if ( $maxday == $d ) { echo 'selected="selected"'; }?>><?=$d?></OPTION>
            <?php }?>	
            </SELECT>
            <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1230 height=40>
  <TBODY>
  <TR class="table_list_head" style="font-weight:normal; font-size:12px;">
    <TH align=middle>区服</TH>
<?php
    for($d=1;$d<=$maxday;$d++){
        echo "<TH>第{$d}天</TH>";
    }
?>
    <TH width="5%" align=middle>合计</TH>
  </TR>
<?php 
    $i = 0;
    foreach( $game_server_arr as $server_id=>$val )  {
        $total=0;
?>
  <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';?>"  height="100%" name="newooo">
    <TD align=middle><?=$server_id?>服</TD>
    <?php
    $create_date = date("Y-m-d",strtotime($val['time']));
    for($d=1;$d<=$maxday;$d++){
        echo "<TD align=middle>".round($val['income'][$create_date])."</TD>";
        $total+=$val['income'][$create_date];
	$create_date = date('Y-m-d',strtotime($create_date . '+1 day'));
    }?>
    <TD align=middle><?=round($total)?></TD>  
  </TR>
  <?php $i++; }?>
</TBODY></TABLE>	
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
	search_pro();
  </SCRIPT>
</BODY>
</HTML>
