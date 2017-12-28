<?php
require_once('../common/common.php');	
include("include/pay_way.inc.php");
$tdate = trim($_REQUEST["tdate"]);
$game_id =trim($_REQUEST["game_id"]);
$orderby=$_REQUEST['orderby'];
if(!$orderby){ $orderby='paysum1'; }
$moneytype=$_REQUEST['moneytype'];
if($moneytype==2){
    $pay_field='paid_amount';
} else {
    $pay_field='money';
}
if ($_SESSION['sp_gamelist']) {
    $arr=explode('|',$_SESSION['sp_gamelist']);
    $sp_gamelist= $arr[1];
}
$filter = " WHERE is_open =1 ";
if ($sp_gamelist) {
    $filter .= " AND id IN (".$sp_gamelist.")";
}
$game_list_arr = $db ->find("SELECT * FROM ".PAYDB.".".GAMELIST." $filter "." ORDER by id DESC ");
if (!$tdate) {
    $tdate=date("Y-m-d");
}
$where=" where pay_date>='$tdate 00:00:00' and pay_date<='$tdate 23:59:59'";
if ($sp_gamelist) {
    $where.=" and game_id in (".$sp_gamelist.")";
}
if ( $game_id !='all' && $game_id !='') {
    $where.=" and game_id =".$game_id;
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>收入合计查询</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function game_change(info) {
        if(!info){return false;}
            var uname = $("#user_name").val();
            var date1 = $("#tdate").val();
   window.location.href='gameDataCount.php?game_id='+info+'&user_name='+uname+'&tdate='+date1;
   }
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
      &nbsp;&nbsp;充值日期：
      <INPUT  value="<?=$tdate?>" name="tdate" id="tdate" size="20" onClick="WdatePicker();" >
      &nbsp;&nbsp;游戏：
      <SELECT name="game_id" id="game_id" onChange="game_change(this.value)">
	  <OPTION label="所有游戏" value="all" >所有游戏</OPTION>
       <?php  foreach( $game_list_arr as $val ) { ?>
           <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
      <?php } ?>	
     </SELECT>
     &nbsp;&nbsp;排序：
        <SELECT name="orderby" id="orderby">
            <OPTION value="paysum1" >按游戏总收入排序↓</OPTION>
            <OPTION value="arpu" <?php if($orderby=='arpu'){ echo 'selected="selected"'; } ?> >ARPU值↓</OPTION>
            <OPTION value="ucount" <?php if($orderby=='ucount'){ echo 'selected="selected"'; } ?> >付费用户↓</OPTION>
        </SELECT>
     &AElig;&nbsp;&nbsp; 查看类型：
        <SELECT name="moneytype" id="moneytype">
            <OPTION value="1" <?php if($moneytype=='1'){ echo 'selected="selected"'; } ?> >充值面额</OPTION>
            <OPTION value="2" <?php if($moneytype=='2'){ echo 'selected="selected"'; } ?> >充值净值</OPTION>
        </SELECT> &nbsp;&nbsp;
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
         </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
  <?php 
  
  
  
  
    
        $wh2 = $wh22 = '';
        if($game_id > 0){
            $wh2 .= ' AND game_id ='.$game_id;
            $wh22 = ' where id='.$game_id;
        }
        $sql="select * from ".PAYDB.".".GAMELIST." $wh22 order by id asc";
        $game_arr = $db ->find($sql);
        $sql="select sum($pay_field) as sumpay  from ".PAYDB.".".PAYLIST." $where AND game_id !=0 AND server_id !=0 ";
        $sumpay =$db ->get($sql);
        $spay= $sumpay['sumpay'];
        $sumpay=array();
        $sumuser =0;//总共付费人数
        $money1 = 0;//总共收入
        $money2 = 0; //实际收入
        $pay_yester_s =0;//昨天总收入
        $pay_lastweek_s =0;//上周总收入
        $data = array();
        $i = 0;
        foreach ( $game_arr as $val) {
            //---------------------------变量初始化
            $pay_yester =0;//昨天收入
            $pay_lastweek = 0;//上周收入
            $ucount=0; //付费用户
            //$sumuser=0; //合计付费用户
            $paysum1 = 0;//合计支付
            $paysum2 = 0;//实收金额
            $arpu =0 ; //ARPU值
            $per = 0; //该游戏所占总收入比例
            $pay=array();
            $sql="select sum($pay_field) as paycount ,count(user_name) as paytimes,count(distinct user_name) as payers,pay_way_id from ".PAYDB.".".PAYLIST." $where AND game_id !=0 AND server_id !=0 and game_id=".$val['id']." group by pay_way_id";
            $game_pay_arr = $db ->find($sql);
            if(date("Y-m-d") == $tdate){
                $his = date(" H:i:s");
            }else{
                $his = date(" 23:59:59");
            }	
            //昨天----------------------------上周---------------------//
            $yesterday = date("Y-m-d",strtotime($tdate)-3600*24);
            $yesterdayc = $yesterday.$his;
            $lastweek = date("Y-m-d",strtotime($tdate)-3600*24*7);
            $lastweekc =  $lastweek.$his;
            $sql = "select sum($pay_field) as pym from ".PAYDB.".".PAYLIST." where game_id !=0 AND server_id !=0 AND game_id=".$val['id']." and  pay_date>='$yesterday 00:00:00' and pay_date<='$yesterdayc'";
            $pay_yes_arr=$db ->get($sql);
            $pay_yester = round($pay_yes_arr['pym']);
            $pay_yester_s +=$pay_yester;

            $sql = "select sum($pay_field) as lwm from db_5399_pay.pay_list where game_id !=0 AND server_id !=0 AND game_id=".$val['id']." and  pay_date>='$lastweek 00:00:00' and pay_date<='$lastweekc'";
            $pay_lastweek_arr = $db ->get($sql);
            $pay_lastweek = round($pay_lastweek_arr['lwm']);
            $pay_lastweek_s +=$pay_lastweek;
            //昨天----------------------------上周--------------------//
            $paysum1=0;
            foreach ( $game_pay_arr as $val2) {
                $pay[$val2["pay_way_id"]][0]=floor($val2['paycount']*100)/100;
                $pay[$val2["pay_way_id"]][1]=floor($val2['paytimes']*100)/100;
                $pay[$val2["pay_way_id"]][2]=floor($val2['payers']*100)/100;
                $sumpay[$val2["pay_way_id"]][0]+=floor($val2['paycount']*100)/100;
                $sumpay[$val2["pay_way_id"]][1]+=floor($val2['paytimes']*100)/100;
                $sumpay[$val2["pay_way_id"]][2]+=floor($val2['payers']*100)/100;
                $paysum[$val2["pay_way_id"]]+=floor($val2['paycount']*100)/100;
                $ucount+=$val2['payers'];
                $paysum1+=floor($val2['paycount']*100)/100;
            }
            $sumuser += $ucount;
            $money1+=$paysum1;
            if ($ucount) {
                $arpu=round($paysum1*100/$ucount)/100;
            } else {
                $arpu=0;
            }
            if ($spay) {
                $per=round($paysum1*10000/$spay)/100;
            } else {
                $per=0;
            }
            $data[$val['id']]['game']=$val['name'];
            $data[$val['id']][1]=$pay[1][0]+$pay[13][0];
            $data[$val['id']][18]=$pay[18][0];
            $data[$val['id']][3]=$pay[3][0];
            $data[$val['id']][5]=$pay[5][0];
            $data[$val['id']][6]=$pay[6][0];
            $data[$val['id']][9]=$pay[9][0];
            $data[$val['id']][10]=$pay[10][0];
            $data[$val['id']][11]=$pay[11][0];
            $data[$val['id']][14]=$pay[14][0];
            $data[$val['id']][15]=$pay[15][0];
            $data[$val['id']][22]=$pay[22][0];
            $data[$val['id']][30]=$pay[30][0];
            $data[$val['id']][31]=$pay[31][0];
            $data[$val['id']][100]=$pay[100][0];
            $data[$val['id']]['ucount']=$ucount;
            $data[$val['id']]['paysum1']=$paysum1;
            $data[$val['id']]['arpu']=$arpu;
            $data[$val['id']]['per']=$per;
            $data[$val['id']]['incp']=round($paysum1-$pay_yester);
            $data[$val['id']]['incp1']=round($paysum1-$pay_lastweek);
        }
        $data=list_sort_by($data,'["'.$orderby.'"]','desc');
?>

<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
  <TR class=table_list_head>
    <TD width="37" noWrap>游戏</TD>
    <TD width=75>快钱</TD>
    <TD width="75">支付宝(余额)</TD>
    <TD width="75">微信支付</TD>
    <TD width="75">平台币支付</TD>
    <TD width="75">手机QQ支付</TD>
    <TD width="73">快钱账号</TD>
    <TD width="71">神州行(快)</TD>
    <TD width=64>北京骏网</TD>
    <TD width="65">首充</TD>
    <TD width="65">充V</TD>
    <TD width="65">平台发放</TD>
    <TD width="65">公会赔付</TD>
    <TD width="65">快钱电信</TD>
    <TD width="65">快钱联通</TD>
    <TD width="83">付费用户</TD>
    <TD width="81">合计支付</TD>
    <TD width="65">ARPU值</TD>
    <TD width="74">收入比例</TD>
    <TD width="66">昨天增长</TD>
    <TD width="75">上周增长</TD>
  </TR>
<?php	   
    $totalrgsum = 0;
    foreach($data as $key =>$re){
        /*当前*/
        //首充
        $stime = strtotime($tdate." 00:00:00");
        $etime =  strtotime($tdate.$his);
        $sql ="SELECT sum(money) as fmoney FROM ".PAYDB.".".PAYFIRST." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
        $fpay=$db->get($sql);
         //充v
        $sql ="SELECT sum(money) as vmoney FROM ".PAYDB.".".PAYVIP." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
        $vpay=$db->get($sql);
        $vpay_money=$vpay['vmoney'];
        //内充
        $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
        $npay=$db->get($sql);
        //平台发放
        $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE game_id=".$key." AND pay_type=1 AND state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
        $pfpay=$db->get($sql);
        //公会赔付
        $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE game_id=".$key." AND pay_type=2 AND state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
        $ghpay=$db->get($sql);
        $totalrg = intval($fpay['fmoney']) + intval($vpay['vmoney']) + intval($npay['nmoney']);
         //人工充值结束
        $totalrgsum += $totalrg;
        $money1 +=$totalrg;
        $re['paysum1']+=$totalrg;

        $fpay_total += $fpay['fmoney'];
        $vpaytotal += $vpay_money;
        $pfpay_total += $pfpay['nmoney'];
        $ghpay_total += $ghpay['nmoney'];
       //前一天游戏内充总额
        //获取所有人工充值
         //首充
         $stime = strtotime($yesterday." 00:00:00");
         $etime =  strtotime($yesterday.$his);
         $sql ="SELECT sum(money) as fmoney FROM ".PAYDB.".".PAYFIRST." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $fpay=$db->get($sql);
         //充v
         $sql ="SELECT sum(money) as vmoney FROM ".PAYDB.".".PAYVIP." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $vpay=$db->get($sql);
         //内充
         $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $npay=$db->get($sql);
         $totalrg1 = intval($fpay['fmoney']) + intval($vpay['vmoney']) + intval($npay['nmoney']);
         //上周游戏内充总额
        //获取所有人工充值
         //首充
         $stime = strtotime($lastweek." 00:00:00");
         $etime =  strtotime($lastweek.$his);
         $sql ="SELECT sum(money) as fmoney FROM ".PAYDB.".".PAYFIRST." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $fpay=$db->get($sql);
         //充v
         $sql ="SELECT sum(money) as vmoney FROM ".PAYDB.".".PAYVIP." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $vpay=$db->get($sql);
         //内充
         $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE state=1 AND game_id=".$key." AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
         $npay=$db->get($sql);
         $totalrg2 = intval($fpay['fmoney']) + intval($vpay['vmoney']) + intval($npay['nmoney']);
         //人工充值结束
         $pay_yester_s +=$totalrg1;
         $pay_lastweek_s +=$totalrg2;
         $mods = $re['ucount'] >0 ? $re['ucount'] :1 ;
         $re['arpu'] = round(($re['paysum1']/$mods), 2);
         $re['incp'] = $re['incp']+$totalrg -$totalrg1;
         $re['incp1'] =$re['incp1']+$totalrg -$totalrg2;     
    if($re['paysum1'] >0){       
  ?>
    <TR class=<? if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap><?=$re['game']?></TD>
        <TD noWrap><?=$re[1]?></TD><!--快钱-->
        <TD noWrap><?=$re[18]?></TD>
        <TD noWrap><?=$re[30]?></TD>
        <TD noWrap><?=$re[100]?></TD>
        <TD noWrap><?=$re[31]?></TD>
        <TD noWrap><?=$re[3]?></TD>
        <TD noWrap><?=$re[6]?></TD>
        <TD noWrap><?=$re[9]?></TD>
        <TD noWrap><?=$fpay['fmoney']?></TD>
        <TD noWrap><?=$vpay_money?></TD>
        <TD noWrap><?=$pfpay['nmoney']?></TD>
        <TD noWrap><?=$ghpay['nmoney']?></TD>
        <TD noWrap><?=$re[14]?></TD>
        <TD noWrap><?=$re[15]?></TD>
        <TD><?=$re['ucount']?></TD>
        <TD noWrap><?=$re['paysum1']?></TD>
        <TD ><?=$re['arpu']?></TD>
        <TD ><?=$re['per']?>%</TD>
        <TD ><?php if ($re['incp']>0) echo '<font color="#00CC00">'.$re['incp'].'</font>';else echo '<font color="#FF0000">'.$re['incp'].'</font>';?></td>  
        <TD ><?php if ($re['incp1']>0) echo '<font color="#00CC00">'.$re['incp1'].'</font>';else echo '<font color="#FF0000">'.$re['incp1'].'</font>'; ?></td>
    </TR>
  <?php } } ?>
    <TR class="trEven">
        <TD noWrap><font color="red">合计</font></TD>
        <TD noWrap><?=$paysum[1]?></TD><!--快钱-->
        <TD noWrap><?=$paysum[18]?></TD>
        <TD noWrap><?=$paysum[30]?></TD>
        <TD noWrap><?=$paysum[100]?></TD>
        <TD noWrap><?=$paysum[31]?></TD>
        <TD noWrap><?=$paysum[3]?></TD>
        <TD noWrap><?=$paysum[6]?></TD>
        <TD noWrap><?=$paysum[9]?></TD>
        <TD noWrap><?=$fpay_total?></TD>
        <TD noWrap><?=$vpaytotal?></TD>
        <TD noWrap><?=$pfpay_total?></TD>
        <TD noWrap><?=$ghpay_total?></TD>
        <TD noWrap><?=$paysum[14]?></TD>
        <TD noWrap><?=$paysum[15]?></TD>
        <TD><?=$sumuser?></TD>
        <TD noWrap><?=$money1?></TD>
        <TD ><?php if ($sumuser) echo round($money1*100/$sumuser)/100;else '0';?></TD>
        <TD ></TD>
        <TD ><?php if ($money1-$pay_yester_s>0) echo '<font color="#00CC00">'.($money1-$pay_yester_s).'</font>';else echo '<font color="#FF0000">'.($money1-$pay_yester_s).'</font>';?></td>  
        <TD ><?php if ($money1-$pay_lastweek_s>0) echo '<font color="#00CC00">'.($money1-$pay_lastweek_s).'</font>';else echo '<font color="#FF0000">'.($money1-$pay_lastweek_s).'</font>';?></td>
    </TR>
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
