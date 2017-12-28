<?php
require_once('../common/common.php');
include('include/isLogin.php');
$date1=$_REQUEST["date1"];
$date2=$_REQUEST["date2"];
if(!$date2) {
    $date2=date("Y-m-d");
}
if(!$date1){
    $date1=date('Y-m')."-01";
}
$date11=str_replace('-','',$date1);
$date22=str_replace('-','',$date2);
$sql="SELECT `reg_user`,`reg_ip`,`login_user`,`login_ip`,`date`,`mx_user`,`mx_ip` FROM ".YYDB.".".DAYUSERC." where  date >={$date11} and date <=".$date22;
$data=$db ->find($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>本月用户登录统计分析</title>
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
                <DIV class=divOperation align="center">
                  <FORM id="myform" method="post" name="myform" action="">
                    起始日期
                    <input name="date1" type="text" class="box" id="date1"  onClick="WdatePicker();" value="<?=$date1?>" size="10" />
                    结束日期
                    <input name="date2" type="text" class="box" id="date2"  onClick="WdatePicker();" value="<?=$date2?>" size="10" />
                         &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
                  </FORM>
                </DIV>
            </TD>
        </TR>
    </TBODY> 
  </TABLE> 
<div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
<table width="70%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td>日期</td>
        <td>新用户</td>
        <td>新用户IP</td>
        <td>老用户</td>
        <td>老用户IP</td>
        <td>官网新用户</td>
        <td>官网新用户IP</td>
        <td>新用户累计</td>
        <td>合计</td>
        <td>用户流失率</td>
    </tr>
<?php
    if($data){
  	$i=0;
        $row=array();
        foreach($data as $v) {
            $date=  substr($v['date'],0,4)."-".substr($v['date'],4,2)."-".substr($v['date'],-2);
            $sum+=$v['reg_user'];
?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align: center;">
        <td ><?=$date?></td>
        <td><?=$v['reg_user']+0?></td>
        <td><?=$v['reg_ip']+0?></td>
        <td><?=$v['login_user']+0?></td>
        <td><?=$v['login_ip']+0?></td>
        <td><?=$v['mx_user']+0?></td>
        <td><?=$v['mx_ip']+0?></td>
        <td><?=$v['reg_user']+$v['login_user']+$v['mx_user']?></td>
        <td><?=$sum?></td>
        <td><?=@round((1-$v['login_user']/$sum)*100)?>%</td>
    </tr>
    <?php
            $jsdata1.="'".substr($date,5)."',";
            $row['nuser'].= $v['reg_user'] >0 ? $v['reg_user'].",":"0,";
            $row['mxuser'].= $v['mx_user'] >0 ? $v['mx_user'].",":"0,";
            $row['nip'].= $v['reg_ip'] >0 ? $v['reg_ip'].",":"0,";
            $row['mxip'].= $v['mx_ip'] >0 ? $v['mx_ip'].",":"0,";
            $row['ouser'].= $v['login_user'] >0 ? $v['login_user'].",":"0,";
            $row['oip'].= $v['login_ip'] >0 ? $v['login_ip'].",":"0,";
	}
    } else { ?>
	<tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
<?php } 
$data_arr=array();
array_push($data_arr,array('name'=>'新用户','data'=>$row['nuser']));
array_push($data_arr,array('name'=>'新用户IP','data'=>$row['nip']));
array_push($data_arr,array('name'=>'老用户','data'=>$row['ouser']));
array_push($data_arr,array('name'=>'老用户IP','data'=>$row['oip']));
array_push($data_arr,array('name'=>'官网用户','data'=>$row['mxuser']));
array_push($data_arr,array('name'=>'官网IP','data'=>$row['mxip']));
?>
  
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
                        text: '本月用户登录统计分析',
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
                        return '<b>'+ this.series.name +'</b><br/>'+
                                        this.x +': '+ this.y +'人';
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
                series: [
            <?php foreach ($data_arr as $v){?>
                {
                        name: '<?=$v['name']?>',
                        data: [<?=  substr($v['data'],0,-1)?>]
                },
            <?php }?>
                ]
        });			
    });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>
