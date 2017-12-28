<?php
require_once('../common/common.php');
include('include/isLogin.php');
$date1=trim($_REQUEST["date1"]);
$date2=trim($_REQUEST["date2"]);
$game_id =trim($_REQUEST["game_id"])+0;
if(!$date2) {
    $date2=date("Y-m-d");
}
if(!$date1){
    $date1=date('Y-m')."-01";
}
$year =date("Y",strtotime($date1));
$data=$hj=array();
//注册人数
$sql="SELECT count(id) as reg,server_id,from_unixtime(reg_time,'%Y-%m-%d') as rdate FROM ".USERDB.".".REGINDEX.$year." where game_id=".$game_id." and reg_time >=unix_timestamp('$date1 00:00:00') and reg_time<=unix_timestamp('$date2 23:59:59')  group by server_id,rdate order by game_id ASC ";
$res=$db->find($sql); 
foreach($res as $v){
    $data[$v['server_id']][$v['rdate']]=$v['reg'];
    $hj[$v['rdate']]+=$v['reg'];  //日期 【合计】
    $hj[$v['server_id']]+=$v['reg']; //游戏 【合计】
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." WHERE is_open=1 order by id desc ";
$game_list_arr = $db ->find($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>游戏区服注册按日统计</title>
<?php require_once('include/head_css_js.php');?>
<script type="text/javascript" >
$(function(){  
    $("#tb tr").mouseover(function(){  
        $(this).addClass("trSelected");  
    });  
    $("#tb tr").mouseout(function(){  
        $(this).removeClass("trSelected");  
    });  
}); 
function btnsubmit() {
    $("#myform").submit();
}
</script>
</head>
<body>
    <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
    <TBODY>
        <TR class=trEven>
          <TD>
                <DIV align="center">
                  <FORM id="myform" method="post" name="myform" action="">
                     起始日期
                    <input name="date1" type="text" class="box" id="date1"  onClick="WdatePicker();" value="<?=$date1?>"  size="10" />
                    &nbsp;&nbsp;结束日期
                    <input name="date2" type="text" class="box" id="date2"  onClick="WdatePicker();" value="<?=$date2?>"  size="10" />
                    游戏：<span class="text_zhifu">
                    <SELECT name="game_id" id="game_id" onChange="document.location.href='gameServerReg_d.php?game_id='+this.value+'&date1='+$('#date1').val()+'&date2='+$('#date2').val()">
                    <OPTION value="0" >平台官网</OPTION>
                    <?php foreach( $game_list_arr as $val ) {?>
                         <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                    <?php }?>	
                    </SELECT>
                    &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
                  </FORM>
                </DIV>
            </TD>
        </TR>
    </TBODY> 
  </TABLE>
<table width="99%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td width="40">区服\日期</td>
    <?php
        $d=$date1;
        while($d<=$date2) {
    ?>
        <td><?=$d?></td>
	<?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
	<td><strong>合计：</strong></td>
    </tr>
<?php
  $j=0;
  if($data){
  foreach($data as $server_id=>$v) {  ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align: center;">
        <td>双线<?=$server_id?>服</td>
        <?php
            $d=$date1;
            while($d<=$date2) { ?>
        <td width="30"><?=$v[$d]+0?></td>
            <?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
        <td width="30" ><?=$hj[$server_id]+0?></td>
        <?php } ?>
    </tr>
<?php } else { ?>
	<tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
<?php } ?>
    <tr  class="table_list_head">
        <td><span>合计：</span></td>
<?php
    $d=$date1;
    $sum=0;
    while($d<=$date2) {
        $sum+=$hj[$d];
?>
        <td width="30"><?=$hj[$d]+0?></td>
<?php $d=date('Y-m-d',strtotime($d)+24*3600);} ?>
        <td width="30" ><?=$sum+0?></td>
    </tr>
</table>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>
