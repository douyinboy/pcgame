<?php
require_once('../common/common.php');
include('include/isLogin.php');
$game_id =trim($_REQUEST["game_id"])+0;
$date1 =trim($_REQUEST["date1"]);
$date2 =trim($_REQUEST["date2"]);
if (!$date1) {
    $date1 = date("Y-m-d",time()-86400*5);
}
if (!$date2) {
    $date2 = date("Y-m-d");
}
$s= " AND tdate>='$date1' AND tdate<='$date2' ";
if ( $game_id >0) { 
     $s .= " AND game_id=".$game_id;
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST."  WHERE is_open=1 order by id desc";
$game_list_arr = $db ->find($sql);
foreach ($game_list_arr as $v){
    $game_list[$v['id']]=$v['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>各游戏新老玩家统计</TITLE>
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
	  统计时间：
      <INPUT  value="<?=$date1?>" name="date1" id="date1" size="20" onClick="WdatePicker();" > -
	  <INPUT  value="<?=$date2?>" name="date2" id="date2" size="20" onClick="WdatePicker();" > 
      游戏：
      <SELECT name="game_id" id="game_id" onChange="document.location.href='gameN_OuserCount.php?game_id='+this.value+'&date1=<?=$date1?>&date2=<?=$date2?>'">
          <OPTION value="0" >请选择</OPTION>
        <?php foreach( $game_list_arr as $val ) { ?>
           <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
        <?php  }  ?>	
     </SELECT>
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        &nbsp;&nbsp;<a style="color:#ff00ff" href="?date1=<?=date('Y-m-d',strtotime($date1)-86400)?>&date2=<?=date('Y-m-d',strtotime($date2)-86400)?>&game_id=<?=$game_id?>&server_id=<?=$server_id?>">前一天</a>
     	&nbsp;&nbsp;<a style="color:#ff00ff" href="?date1=<?=date('Y-m-d',strtotime($date1)+86400)?>&date2=<?=date('Y-m-d',strtotime($date2)+86400)?>&game_id=<?=$game_id?>&server_id=<?=$server_id?>">后一天</a>
      </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
        <TD width="81" noWrap>游戏</TD>
        <TD width="98">老玩家进游戏人数</TD>
        <TD width="92">新玩家进游戏人数</TD>
        <TD width="128">老玩家充值人数</TD>
        <TD width="112" noWrap>新玩家充值人数</TD>
        <TD width=121>老玩家充值金额</TD>
        <TD width="115">新玩家充值金额</TD>
        <TD width=78>总金额</TD>
        <TD width="116">统计时间</TD>
    </TR>
  <?php 
    $i=0;
    $sql = "SELECT sum(oldreg_count) as oreg,sum(newreg_count) as nreg,sum(old_paypeople) as opayp,sum(new_paypeople) as npayp,sum(old_paymoney) as opaym,sum(new_paymoney) as npaym,tdate,game_id FROM ".YYDB.".".NOUSERC." where 1 $s  group by game_id,tdate order by game_id desc,tdate asc";
    $data_arr=$db ->find($sql);
    $hj=array();
    foreach ($data_arr as $val) {
        $hj['oreg']+=$val['oreg'];
        $hj['nreg']+=$val['nreg'];
        $hj['opayp']+=$val['opayp'];
        $hj['npayp']+=$val['npayp'];
        $hj['opaym']+=$val['opaym'];
        $hj['npaym']+=$val['npaym'];
        $hj['totalmoney']+=$val['opaym']+$val['npaym'];  
  ?>
    <TR class=<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap><?=$game_list[$val['game_id']]?><br/><a href="serverN_OuserCount.php?game_id=<?=$val['game_id']?>&date1=<?=$val['tdate']?>&date2=<?=$val['tdate']?>"><br/><font color="#17f326">[各区服]</font></a></TD>
        <TD noWrap><?=$val['oreg']+0?></TD>
        <TD noWrap><?=$val['nreg']+0?></TD>
        <TD noWrap><?=$val['opayp']+0?></TD>
        <TD noWrap><?=$val['npayp']+0?></TD>
        <TD noWrap><?=round($val['opaym'],2)?></TD>
        <TD noWrap><?=round($val['npaym'],2)?></TD>
        <TD noWrap><?=round($val['opaym'] + $val['npaym'],2)?></TD>
        <TD noWrap><?=$val['tdate']?></TD>
    </TR>
  <?php } ?>
    <TR class='trEven'>
        <TD noWrap>合计</TD>
        <TD noWrap><?=$hj['oreg']+0?></TD>
        <TD noWrap><?=$hj['nreg']+0?></TD>
        <TD noWrap><?=$hj['opayp']+0?></TD>
        <TD noWrap><?=$hj['npayp']+0?></TD>
        <TD noWrap><?=round($hj['opaym'],2)?></TD>
        <TD noWrap><?=round($hj['npaym'],2)?></TD>
        <TD noWrap><?=round($hj['totalmoney'],2)?></TD>
        <TD noWrap>--</TD>
    </TR>
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
