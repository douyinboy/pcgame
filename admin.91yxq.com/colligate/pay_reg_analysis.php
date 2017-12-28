<?php
require_once('../common/common.php');
include('include/isLogin.php');
$date1=trim($_REQUEST["date1"]);
$date2=trim($_REQUEST["date2"]);
$money1=intval($_REQUEST["money1"]);
$money2=intval($_REQUEST["money2"]);
$game_id =trim($_REQUEST["game_id"]);
if (!$date1) {
    $date1=date("Y-m-")."01";
} 
if (!$date2) {
    $date2=date("Y-m-d");
}
if ($money1<=0 || $money2 <=0) { 
    $money1 = 1;
	$money2 = 5000;
}
$s=" WHERE `pay_date`>='".$date1." 00:00:00' AND `pay_date`<='".$date2." 23:59:59' ";
if ( $game_id !='' && $game_id!=='all' ) {
    $s .= " AND game_id=".$game_id;
}
$sql="SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST."  where is_open=1 order by id desc ";
$game_list_arr = $db ->find($sql);
foreach($game_list_arr as $val){
    $game_arr[$val['id']]=$val['name'];
    $game_byname[$val['id']]=$val['game_byname'];
}
/*-------------------注册分时处理--------------------------------------*/
$sql="select sum(`money`) as sm,`user_name`,`reg_date` from ".PAYDB.".".PAYLIST." $s and game_id !=0 AND server_id !=0  group by user_name";
$pay_m_arr =$db ->find($sql);
$data = array();
for ($i = 0; $i <= 23; $i++) {
    $data[$i] = array('count'=>0);
}
foreach ( $pay_m_arr as $key=>$val) {
    $reg_h = intval(date("H",strtotime($val['reg_date'])));
    if ( $val['sm']>= $money1 && $val['sm']<= $money2 ) {
        $data[$reg_h]['count'] += 1;
    }
}
foreach( $data as $key=>$value ) {
    $jsdata1.="'".$key."',";
    $jsdata2.=$value['count'].","; 
}
$jsdata1 = substr($jsdata1, 0, -1);
$jsdata2 = substr($jsdata2, 0, -1);
/*-------------------注册分时处理--------------------------------------*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>收入分时段显示</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
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
      &nbsp;&nbsp;充值日期：
      <INPUT  value="<?=$date1?>" name="date1" id="date1" size="20" onClick="WdatePicker();" > -
	  <INPUT  value="<?=$date2?>" name="date2" id="date2" size="20" onClick="WdatePicker();" >
      &nbsp;&nbsp;充值金额范围：<INPUT  value="<?=$money1?>" name="money1" id="money1" size="7" >
      -<INPUT  value="<?=$money2?>" name="money2" id="money2" size="7" >
      游戏：
        <SELECT name="game_id" id="game_id">
	  <OPTION label="所有游戏" value="all" >所有游戏</OPTION>
        <?php foreach( $game_list_arr as $val ) {?>
           <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
       <?php } ?>	
        </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
	 &nbsp;&nbsp;&nbsp;
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
      </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
        <TD width="100" noWrap>日期时段(小时)/充值人数 </TD>
	<?php foreach( $data as $key=>$value ) { ?>
        <TD width="17"><?=$key?>点</TD>
	<?php } ?>
    </TR>
    <TR class=<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap></TD>
	<?php foreach( $data as $key=>$value ) { ?>
        <TD noWrap><?=$value['count']?></TD>
	<?php } ?>
    </TR>
</TBODY></TABLE>
<div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
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
                text: '各时段收入按注册统计',
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
                return '<b>'+ this.series.name +'</b><br/>'+ this.x +'时: '+ this.y +'人';
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
                name: '充值人数',
                data: [<?=$jsdata2?>]
            }]
        });
				
    });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
	search_pro();
  </SCRIPT>
</BODY>
</HTML>
