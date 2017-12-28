<?php
set_time_limit(0);
require_once('../common/common.php');
include('include/isLogin.php');
$tdate=trim($_REQUEST["tdate"]);
$agent_id=trim($_REQUEST["agent_id"]);
$game_id=trim($_REQUEST["game_id"]);
$adtype=trim($_REQUEST["adtype"])+0;
if (!$tdate) {
    $tdate=date("Y-m-d");
}
if($game_id){
    $fgame=' and game_id='.$game_id;
}
if ($tdate==date("Y-m-d")) {
    $maxh=date("H");
} else {
    $maxh=23;
}
$year = date('Y'); 
if($agent_id){
    $sql="select site_id,agent_id,author from ".GUILDMEMBER." where agent_id=".$agent_id;
    $rs = $db->find($sql);
    $sql="SELECT count(id) as reg,agent_id,placeid, FROM_UNIXTIME( reg_time,  '%k' ) AS df FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate 00:00:00') and reg_time<=unix_timestamp('$tdate 23:59:59') and agent_id =$agent_id $fgame group by agent_id,placeid,df order by reg desc";
    $res=$db->find($sql);
    $data=array();
    $ids='';
    foreach ($res as $key => $value) {
        $data[$value['placeid']][$value['df']] = $value['reg'];
    }
    foreach ($rs as $key => $value) {
        $ids .= $value['site_id'].',';
    }
}
$sql="select id,name from ".PAYDB."." .GAMELIST." where is_open=1  order by id desc ";
$game_arr=$db->find($sql);
if($_GET['dump']=='dump'){
    header('Content-Type: text/xls');
    header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
    $agent = $db->get("select agentname from ".GUILDINFO." where id=".$agent_id);
    $filename = mb_convert_encoding($agent['agentname'].'-注册明细.csv', 'gbk', 'utf-8');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    $table_data = '';
    $table_data .= '成员ID,成员名称';
    for ($i = 0; $i < 24; $i++) {
            $table_data .= (','.$i.'点');
    }
    $table_data .= ",合计 \n";
    $hj=array();
    foreach($rs as $key=>$value){
        $table_data .= "{$value['site_id']},{$value['author']}";
        $sum = 0;
        for ($h=0;$h<24;$h++) {
                $n = $data[$value['site_id']][$h]+0;
                $table_data .= ",{$n}";
                $sum += $n;
                $hj[$h]+=$n;
        }
        $table_data .= ",{$sum} \n";
    }
    $table_data .= ",合计:";
    $sum=0;
    for($h=0;$h<24;$h++){
        $table_data .=",".$hj[$h];
        $sum+=$hj[$h];
    }
    $table_data .=",".$sum;
    echo mb_convert_encoding($table_data, 'gbk', 'utf-8');
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>公会成员详情</title>
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
        <div style="float:left;">
            <sapn> <a style="color:#f80560;" href='guildRegCount_h_detail.php?dump=dump&tdate=<?=$tdate?>&agent_id=<?=$agent_id?>&game_id=<?=$game_id?>&agent_type=<?=$agent_type?>&payway=<?=$payway?>&adtype=<?=$adtype?>&webtype=<?=$webtype?>'>导出数据</a></sapn>
        </div>
        <DIV class=divOperation align="center">
            <FORM id="myform" method="post" name="myform" action="">
                日期
                <input name="tdate" type="text" class="box" id="tdate"  onClick="WdatePicker();" value="<?=$tdate?>" size="10" />
                游戏<span class="text_zhifu">
                <select name="game_id" class="box" id="game_id"   >
                  <option value="0">全部</option>
                  <?php foreach($game_arr as $games){ ?>
                 <option value="<?=$games['id']?>" <?php if ($games['id']==$game_id) {echo " selected";} ?> ><?=$games['name']?></option>
                 <?php } ?>
                </select>
                 &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
            </FORM>
        </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<table width="99%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td width="60">成员ID</td>
        <td width="100">成员名称</td>
        <?php for ($h=0;$h<=$maxh;$h++) { ?>
        <td><?=$h?>点</td>
	<?php } ?>
	<td><strong>合计</strong></td>
  </tr>
<?php
    $j=0;
    if($data){
        $t=array();
        $total = 0;
        foreach($rs as $key=>$value){
  ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
        <td ><?=$value['site_id']?></td>
    	<td ><?=$value['author']?></td>
        <?php
            $t1=0;
            for ($h=0;$h<=$maxh;$h++) {
                $t1 += $data[$value['site_id']][$h];
                $t[$h] += $data[$value['site_id']][$h];
                $total += $data[$value['site_id']][$h];
    	?>
        <td width="30" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= ($data[$value['site_id']][$h])?"<font style='color:red'>{$data[$value['site_id']][$h]}</font>":0;?></td>
        </tr>
        </table></td>
        <?php } ?>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><?=$t1+0?></td>
        </tr>
        </table></td>
	</tr>
  <?php $j++; } }else{ ?>
	<tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
  <?php }  ?>
  <tr  class="table_list_head">
	<td><span>合计</span></td>
	<td width="40">-</td>
    <?php
	$i=0;
	for ($h=0;$h<=$maxh;$h++) {
            if($i==0){
                $jsdata1="'".$h."'";
                $t2[$adtype+0][$h][0]>0?$jsdata2=$t2[$adtype+0][$h][0]:$jsdata2='0';
                $t2[$adtype+0][$h][1]>0?$jsdata3=$t2[$adtype+0][$h][1]:$jsdata3='0';
            } else {
                $jsdata1.=",'".$h."'";
                $t2[$adtype+0][$h][0]>0?$jsdata2.=",".$t2[$adtype+0][$h][0]:$jsdata2.=',0';
                $t2[$adtype+0][$h][1]>0?$jsdata3.=",".$t2[$adtype+0][$h][1]:$jsdata3.=',0';
            }
            $i++;
	?>
	<td width="30"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><b><?=$t[$h]+0?></b></td>
        </tr>
        </table></td>
	<?php } ?>
    <td width="30"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><b><?=$total+0?></b></td>
        </tr>
    </table></td>
  </tr>
</table>
黑色:注册<br>
<div id="container" style="width: 900px; height: 700px; margin: 0 auto"></div>
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
                text: '注册实时统计',
                x:0 //center
            },
            subtitle: {
                text: '',
                x:0
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
            series: [
            <?php foreach ($rs as $key => $value) {?>
            {
                name: '<?=$value['author']?>',
                data: [<?php
                    $str = '';
                    for ($i = 0; $i < 24; $i++) {
                            $str.=($data[$value['site_id']][$i]+0).',';
                    }
                    echo substr($str, 0,-1);				
                ?>]
            }					
            <?php echo ',';}?>]
            });
    });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
</SCRIPT>
</body>
</html>
