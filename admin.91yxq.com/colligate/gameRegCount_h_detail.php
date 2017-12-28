<?php
require_once('../common/common.php');
include('include/isLogin.php');
$tdate = $_REQUEST['tdate'];
$year =date("Y",strtotime($tdate));
$game_id=trim($_REQUEST["game_id"])+0;

$filter =" ";
if ($game_id) {
    $filter.=" and game_id='$game_id'";
}
if ($tdate==date("Y-m-d")) {
    $maxh=date("H");
} else {
    $maxh=23;
}
$th =0;
for($h=0;$h<=$maxh;$h++) {
    $th= h <=9 ? '0'.$h:$h;
    //注册  
    $sql="SELECT count(id) as reg,placeid FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59') $filter group by placeid order by placeid";
    $res=$db->find($sql);
    foreach($res as $row){
        $site_id=$row['placeid']+0;
        if($site_id>0 && is_int($site_id)){
           $sql="select a.agentname,b.author from ".GUILDINFO." a,".GUILDMEMBER." b where a.id=b.agent_id and b.site_id=".$site_id;
           $are=$db->get($sql);
            $data[$site_id]['name']=$are['agentname'].'('.$are['author'].')';
            $data[$site_id][$h][0] +=$row['reg'];
        }else{
            $data[$site_id][$h][0] +=$row['reg'];
        }

    }
//登录
    $sql="SELECT count(id) as login,placeid FROM ".USERDB.".".REGINDEX.$year."  where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59') and from_unixtime(login_time,'%Y-%m-%d')='$tdate' $filter group by placeid";
    $res=$db->find($sql);
    foreach($res as $row){
        $site_id=$row['placeid']+0;
        $data[$site_id][$h][1] +=$row['login'];
    }
}
$sql="select id,name from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$game_arr=$db->find($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
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
              <DIV class=divOperation style="float: left;margin-left: 260px;">
                  <FORM id="myform" method="post" name="myform" action="">
                      日期
                    <input name="tdate" type="text" class="box" id="tdate"  onClick="WdatePicker();" value="<?=$tdate?>" size="10" />
                         &nbsp;&nbsp;游戏：
                        <select name="game_id" class="box" id="game_id"   >
                            <option value="0">全部</option>
                            <?php foreach($game_arr as $games){ ?>
                                <option value="<?=$games['id']?>" <?php if ($games['id']==$game_id) {echo " selected";} ?> ><?=$games['name']?></option>
                            <?php } ?>
                        </select>
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
        <td width="40">渠道\时间</td>
        <td width="30">渠道名</td>
            <?php for ($h=0;$h<=$maxh;$h++) { ?>
        <td><?=$h?></td>
            <?php } ?>
	<td><strong>合计</strong></td>
    </tr>
  <?php
  $j=0;
  if($data){
  foreach($data as $site_id=>$v) {
  ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
    <td ><?=$site_id?></a></td>
     <td ><?=$v['name']?></td>
    <?php
	for ($h=0;$h<=$maxh;$h++) {
            $s[$site_id][0]+=$v[$h][0];
            $s[$site_id][1]+=$v[$h][1];
            $l[$h][0]+=$v[$h][0];
            $l[$h][1]+=$v[$h][1];
	?>
    <td width="30" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><?=$v[$h][0]+0?></td>
        </tr>
        <tr>
          <td><font color="#0000FF"><?=$v[$h][1]+0?></font></td>
        </tr>
        <tr>
          <td><font color="#FF0000">
            <?php if ($v[$h][0]) { echo round($v[$h][1]*100/$v[$h][0],2);} else {echo "0";}?>%</font></td>
        </tr>
      </table></td>
	<?php }
            $total[0]+=$s[$site_id][0];
            $total[1]+=$s[$site_id][1];
	?>
	<td width="30" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><b>
            <?=$s[$site_id][0]?>
          </b></td>
        </tr>
        <tr>
          <td><b><font color="#0000FF"><?=$s[$site_id][1]?></font></b></td>
        </tr>
    <tr ><td><font color="#FF0000">
      <?php if ($s[$site_id][0]) { echo round($s[$site_id][1]/$s[$site_id][0]*100,2); } else { echo "0"; }?>%</font></td></tr>
      </table></td>
    <?php }?>
  </tr>
 <?php } else { ?>
	<tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
<?php } ?>
  <tr  class="table_list_head">
    <td><span>合计</span></td>
    <td>-</td>
	<?php
	$i=0;
	for ($h=0;$h<=$maxh;$h++) {
            if($i==0){
                $jsdata1="'".$h."'";
                $l[$h][0]>0?$jsdata2=$l[$h][0]:$jsdata2='0';
                $l[$h][1]>0?$jsdata3=$l[$h][1]:$jsdata3='0';
            } else {
                $jsdata1.=",'".$h."'";
                $l[$h][0]>0?$jsdata2.=",".$l[$h][0]:$jsdata2.=',0';
                $l[$h][1]>0?$jsdata3.=",".$l[$h][1]:$jsdata3.=',0';
            }
            $i++;
	?>
    <td width="30"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><b>
            <?=$l[$h][0]+0?>
          </b></td>
        </tr>
        <tr>
          <td><b><font color="#0000FF"><?=$l[$h][1]+0?></font></b></td>
        </tr>
    <tr ><td><font color="#FF0000">
      <?php if ($l[$h][0]) { echo round($l[$h][1]/$l[$h][0]*100,2); } else { echo "0"; }?>%</font></td></tr>
      </table></td>
	<?php } ?>
    <td width="30" bgcolor="#F2F2F2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><b>
            <?=$total[0]+0?>
          </b></td>
        </tr>
        <tr>
          <td><b><font color="#0000FF"><?=$total[1]+0?></font></b></td>
        </tr>
    <tr ><td><font color="#FF0000">
      <?php if ($total[0]) { echo round($total[1]/$total[0]*100,2); } else { echo "0"; }?>%</font></td></tr>
      </table></td>
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
                text: '游戏注册分时统计',
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
