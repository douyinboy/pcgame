<?php
require_once('../common/common.php');
include('include/isLogin.php');
$tdate=$_REQUEST['tdate'];
empty($tdate) && $tdate = date("Y-m-d");
if ($tdate==date("Y-m-d")) {
    $maxh=date("H");
} else {
    $maxh=23;
}
$th =0;
$year =date("Y",strtotime($tdate));
for($h=0;$h<=$maxh;$h++) {
    $th = $h <9 ? '0'.$h:$h;
    //---------------------------------------9494注册登陆统计---------------------------------------------
    //注册人数
    $sql="SELECT count(id) as reg,game_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59')  group by game_id";
    $res=$db->find($sql);
    foreach($res as $row){
        $datat[$row['game_id']][$h][0]=$row['reg'];
        $total['game'][$row['game_id']][0]+=$row['reg']+0;
        $total['hour'][$h][0]+=$row['reg']+0;
        $tal[0]+=$row['reg']+0;
    }
    //登录人数
    $sql="SELECT count(id) as login,game_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59') and from_unixtime(login_time,'%Y-%m-%d')='$tdate'  group by game_id";
    $res=$db->find($sql);
    foreach($res as $row){
        $datat[$row['game_id']][$h][1]=$row['login'];
        $total['game'][$row['game_id']][1]+=$row['login']+0;
        $total['hour'][$h][1]+=$row['login']+0;
        $tal[1]+=$row['login']+0;
    }	
}
$m=1;
$str='';
$str_id=array();
$sql="SELECT count(id) as reg,game_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate 00:00:00') and reg_time<=unix_timestamp('$tdate 23:59:59')  group by game_id order by reg desc";
$result=$db->find($sql);
foreach($result as $val){
    $str_id[]=$val['game_id'];
    $str.=$val['game_id'];
    if($m<count($result)){
        $str.=',';
    }
    $m++;
}
foreach($str_id as $id){
    if($id==0){
        $game_list[0]='平台官网';
    }else{
        $sql="select id,name from ".PAYDB.".".GAMELIST."  where id=$id";
        $result=$db->get($sql);
        $game_list[$result['id']]=$result['name'];
    }
}
if($str!=''){
    $sql="select id,name from ".PAYDB.".".GAMELIST." where id not in ($str)";
    $result=$db->find($sql);
    foreach($result as $val){
            $game_list[$val['id']]=$val['name'];
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>游戏注册实时统计</title>
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
                <DIV class=divOperation style="float: left;margin-left: 300px;">
                  <FORM id="myform" method="post" name="myform" action="">
                    日期
                    <input name="tdate" type="text" class="box" id="tdate"  onClick="WdatePicker();" value="<?=$tdate?>" size="10" />
                         &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
                  </FORM>
                </DIV>
                <div style="float:right;margin:-1px 290px -10px 0">
                    黑色:注册
                    <font color="#0000FF" style="margin-left:20px">蓝色:登录</font>
                    <font color="#FF0000" style="margin-left:20px">红色:登录率</font>
                </div>
            </TD>
        </TR>
    </TBODY> 
  </TABLE>
<div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
<table width="99%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td width="100">游戏\时间</td>
	<?php for ($h=0;$h<=$maxh;$h++) { ?>
        <td><?=$h?></td>
	<?php } ?>
	<td><strong>合计</strong></td>
    </tr>
  <?php
  $j=1;
  if($datat){
  foreach($game_list as $id=>$name) {
  ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
  	<td><?=$name?><a href="gameRegCount_h_detail.php?game_id=<?=$id?>&tdate=<?=$tdate?>"><br/><font color="#17f326">[详细]</font></a></td>
        <?php for($h=0;$h<=$maxh;$h++){ ?>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
                    <td><?=$datat[$id][$h][0]+0 ?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$datat[$id][$h][1]+0 ?></font></td>
                </tr>
                <tr>
                    <td>
                        <font color="#FF0000"><?=$datat[$id][$h][0]>0 ? round($datat[$id][$h][1]*100/$datat[$id][$h][0]) : 0?>%</font>
                    </td>
                </tr>
            </table>
        </td>
    <?php } ?>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
                    <td><?=$total['game'][$id][0]+0?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$total['game'][$id][1]+0?></font></td>
                </tr>
                <tr>
                    <td>
                        <font color="#FF0000"><?=$total['game'][$id][0]>0 ? round($total['game'][$id][1]*100/$total['game'][$id][0]) : 0?>%</font>
                    </td>
                </tr>
            </table>
        </td>
  </tr>
  <?php } } ?>
    <tr class="table_list_head">
  	<td><strong>合计：</strong></td>
    <?php
    	for($h=0;$h<=$maxh;$h++){
            if($i==0){
                $jsdata1="'".$h."'";
                $total['hour'][$h][0]>0?$jsdata2=$total['hour'][$h][0]:$jsdata2='0';
                $total['hour'][$h][1]>0?$jsdata3=$total['hour'][$h][1]:$jsdata3='0';
            } else {
                $jsdata1.=",'".$h."'";
                $total['hour'][$h][0]>0?$jsdata2.=",".$total['hour'][$h][0]:$jsdata2.=',0';
                $total['hour'][$h][1]>0?$jsdata3.=",".$total['hour'][$h][1]:$jsdata3.=',0';
            }
            $i++;
	?>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
                    <td><?=$total['hour'][$h][0]+0?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$total['hour'][$h][1]+0?></font></td>
                </tr>
                <tr>
                    <td>
                        <font color="#FF0000"><?=$total['hour'][$h][0]>0 ? round($total['hour'][$h][1]*100/$total['hour'][$h][0]) : 0?>%</font>
                    </td>
                </tr>
            </table>
        </td>
    <?php } ?>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
                    <td><?=$tal[0]+0?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$tal[1]+0?></font></td>
                </tr>
                <tr>
                    <td>
                        <font color="#FF0000"><?=$tal[0]>0 ? round($tal[1]*100/$tal[0]) : 0?>%</font>
                    </td>
                </tr>
            </table>
        </td>
  </tr>
</table>
<script type="text/javascript" >
   var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '游戏注册量实时统计',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?=$jsdata1?>]
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                    plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+this.x +'时: '+ this.y +'人';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: '注册',
                data: [<?=$jsdata2?>]
            }, {
                name: '登录',
                data: [<?=$jsdata3?>]
            }]
        });

    });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>