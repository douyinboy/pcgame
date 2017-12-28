<?php
require_once('../common/common.php');
include('include/isLogin.php');
$tdate=trim($_REQUEST["tdate"]);
$agent_id=trim($_REQUEST["agent_id"]);
$game_id=trim($_REQUEST["game_id"]);
$autor=$_REQUEST['autor'];
$desc=  intval($_REQUEST['desc'])+0; //0为降序，1为升序
$ordertype=  intval($_REQUEST['or_tp'])+0; //0为按公会排序，1为按注册量排序
if($ordertype >0){
    $orserby=" reg ";
    $orserby.= $desc >0 ? " ASC ":" DESC ";      
}else{
    $orserby=" agent_id ";
    $orserby.= $desc >0 ? " ASC ":" DESC ";        
}
$desc= $desc >0 ? 0:1;
if (!$tdate) {
    $tdate=date("Y-m-d");
}
$fagent='';
if($agent_id!=''){
    $fagent=' and agent_id='.intval($agent_id);
}
$adtype=4;
$webtype=15;
if($autor){
    $fiter.=" and a.adduid=".$autor;
}
if($game_id){
    $fgame=' and game_id='.$game_id;
}
if ($tdate==date("Y-m-d")) {
    $maxh=date("H");
} else {
    $maxh=23;
}
$i=1;
$aid='';
$sql="select distinct agent_id from ".GUILDMEMBER." s left join ".GUILDINFO." a on s.agent_id=a.id where 1  $fiter $fagent ";
$res=$db->find($sql);
if($res){
    foreach($res as $re){
        $aid.=$re['agent_id'];
        if($i!=count($res)){
                $aid.=',';
        }
        $i++;
    }
}
$year = date("Y",strtotime($tdate));
if($aid!=''){
    $sql="SELECT count(id) as reg,agent_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate 00:00:00') and reg_time<=unix_timestamp('$tdate 23:59:59') and agent_id in ($aid) $fgame group by agent_id order by  $orserby";
    $res=$db->find($sql);
    foreach($res as $re){
        $sql="select agentname from ".GUILDINFO." where id='".$re['agent_id']."'";
        $are=$db->get($sql);
        $data[$adtype+0][$re['agent_id']]['name'] = $are['agentname'];
        $data[$adtype+0][$re['agent_id']]['agent_id'] = $re['agent_id'];
    }
}
for($h=0;$h<=$maxh;$h++) {
    $th=$h <=9 ? '0'.$h:$h;
    //注册
    if($aid!=''){
        $sql="SELECT count(id) as reg,agent_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59') and agent_id in ($aid) $fgame group by agent_id ";  
        $res=$db->find($sql);
        foreach($res as $re){
            $data[$adtype+0][$re['agent_id']][$h][0] +=$re['reg'];
            $t1[$adtype+0][$re['agent_id']][0] +=$re['reg'];
            $t2[$adtype+0][$h][0] +=$re['reg'];
            $total[0]+=$re['reg'];
        }
        $sql="SELECT count(id) as login,agent_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate $th:00:00') and reg_time<=unix_timestamp('$tdate $th:59:59') and from_unixtime(login_time,'%Y-%m-%d')='$tdate' and agent_id in ($aid) $fgame group by agent_id ";
        $res=$db->find($sql);
        foreach($res as $re){
            $data[$adtype+0][$re['agent_id']][$h][1] +=$re['login'];
            $t1[$adtype+0][$re['agent_id']][1] +=$re['login'];
            $t2[$adtype+0][$h][1] +=$re['login'];
            $total[1]+=$re['login'];
        }
    }
}
if($aid!=''){
    $sql="SELECT count(id) as reg,agent_id FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$tdate 00:00:00') and reg_time<=unix_timestamp('$tdate 23:59:59') and agent_id in ($aid) group by agent_id ";
    $res=$db->find($sql);
    foreach($res as $re){
        $d[$re['agent_id']]['total']=$re['reg'];
    }
}
//游戏列表
$sql="select id,name from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$game_arr=$db->find($sql);
/**后台管理人员*/
$sql=" select * from ".ADMINUSERS." where uLoginState=1";
$chargeman_arr=$db ->find($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>公会注册实时统计</title>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script type="text/javascript" >
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
        <DIV class=divOperation style="float: left;">
            <FORM id="myform" method="post" name="myform" action="">
                日期
                <input name="tdate" type="text" class="box" id="tdate"  onClick="WdatePicker();" value="<?=$tdate?>" size="10" />
                公会ID<input name="agent_id" type="text" class="box" id="agent_id"  value="<?=$agent_id?>" size="5" />
                游戏
                <select name="game_id" class="box" id="game_id"   >
                    <option value="0">全部</option>
                        <?php foreach($game_arr as $games){ ?>
                    <option value="<?=$games['id']?>" <?php if ($games['id']==$game_id) {echo " selected";} ?> ><?=$games['name']?></option>
                 <?php } ?>
                </select>
                负责人：
                <select name="autor">
                    <option value="">全部</option>
                        <?php foreach($chargeman_arr as $k=>$val){ ?>
                    <option value="<?=$val['uid']?>" <?php if($autor==$val['uid']){ echo 'selected'; } ?> ><?=$val['uName']?></option>
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
<table width="99%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td width="80">公会ID<a href="?tdate=<?=$tdate?>&agent_id=<?=$agent_id?>&game_id=<?=$game_id?>&autor=<?=$autor?>&desc=<?=$desc?>" style="color:#F00">&nbsp;<?=$desc >0 ? "↓":"↑" ?></a></td>
        <td width="80">公会名称</td>
        <?php for ($h=0;$h<=$maxh;$h++) { ?>
            <td><?=$h?>点</td>
        <?php }?>
	<td><strong>合计<a href="?tdate=<?=$tdate?>&agent_id=<?=$agent_id?>&game_id=<?=$game_id?>&autor=<?=$autor?>&or_tp=1&desc=<?=$desc?>" style="color:#F00">&nbsp;<?=$desc >0 ? "↓":"↑" ?></a></strong></td>
    </tr>
    <?php
  	$j=0;
	if($data){
            foreach($data[$adtype] as $v){
    ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
        <td ><?=$v['agent_id']?></td>
    	<td ><?=$v['name']?><br/><a href="guildRegCount_h_detail.php?tdate=<?=$tdate?>&agent_id=<?=$v['agent_id']?>&game_id=<?=$game_id?>&autor=<?=$autor?>&adtype=<?=$adtype?>&webtype=<?=$webtype?>"><font color="#17f326">[详细]</font></a></td>
        <?php for ($h=0;$h<=$maxh;$h++) { ?>
        <td width="30" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?=$v[$h][0]+0?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$v[$h][1]+0?></font></td>
                </tr>
                <tr>
                    <td><font color="#FF0000">
                    <?php if ($v[$h][0]) { echo round($v[$h][1]*100/$v[$h][0],2);} else {echo "0";}?>%</font>
                    </td>
                </tr>
            </table>
        </td>
        <?php } ?>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?=$t1[$adtype+0][$v['agent_id']][0]+0?></td>
                </tr>
                <tr>
                    <td><font color="#0000FF"><?=$t1[$adtype+0][$v['agent_id']][1]+0?></font></td>
                </tr>
                <tr>
                    <td><font color="#FF0000">
                    <?php if ($t1[$adtype+0][$v['agent_id']][0]) { echo round($t1[$adtype+0][$v['agent_id']][1]*100/$t1[$adtype+0][$v['agent_id']][0],2);} else {echo "0";}?>%</font></td>
                </tr>
            </table>
        </td>
    </tr>
  <?php } }else{ ?>
    <tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
  <?php } ?>
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
	<td width="30">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><b><?=$t2[$adtype+0][$h][0]+0?></b></td>
                </tr>
                <tr>
                  <td><b><font color="#0000FF"><?=$t2[$adtype+0][$h][1]+0?></font></b></td>
                </tr>
                <tr ><td><font color="#FF0000">
                    <?php if ($t2[$adtype+0][$h][0]) { echo round($t2[$adtype+0][$h][1]/$t2[$adtype+0][$h][0]*100,2); } else { echo "0"; }?>%</font></td></tr>
            </table>
        </td>
	<?php } ?>
        <td width="30"class="table_list_head">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><b><?=$total[0]+0?></b></td>
                </tr>
                <tr>
                    <td><b><font color="#0000FF"><?=$total[1]+0?></font></b></td>
                </tr>
                <tr ><td><font color="#FF0000">
                    <?php if ($total[0]) { echo round($total[1]/$total[0]*100,2); } else { echo "0"; }?>%</font></td></tr>
            </table>
        </td>
  </tr>
</table>
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
                text: '公会注册实时统计',
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
