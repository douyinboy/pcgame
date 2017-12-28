<?php 
require_once('../common/common.php');
include('include/isLogin.php');	
include("include/pay_way.inc.php");
require_once('include/ip.php');
$QQWry=new QQWry;
$user_name = trim($_REQUEST["user_name"]);
$orderid = trim($_REQUEST["orderid"]);
$total_pay=0;
$sql="SELECT id,name,game_byname FROM  ".PAYDB.".".GAMELIST."  where is_open=1 ";
$game_list_arr = $db ->find($sql);
$game_arr = array();
foreach ($game_list_arr as $val) {
    $game_arr[$val['id']] = $val;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>玩家充值查询</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702">
</HEAD>
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
            &nbsp;&nbsp;充值帐号：
            <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=20 >
            &nbsp;&nbsp;订单号：
            <INPUT value="<?=$orderid?>" size="30" name="orderid" id="orderid"> 
            <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>

<?php 

if ( $_POST['act'] =='serach' && ($user_name || $orderid)) {
        $filter = " WHERE 1 ";
            $filter_game = " WHERE 1 ";
        if ( $user_name ) {
                $filter .= " AND user='$user_name'";
                $filter_game .= " AND user_name='$user_name'";
              }
              if ( $orderid ) {
                    $filter .= " AND orderid='$orderid'";
                    $filter_game .= " AND orderid='$orderid'";
              }
            ?>
			<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1226 height=40>
			  <TBODY>
			  <TR class=table_list_head>
				<TD width="5%" align=middle>充值账号</TD>
				<TD width="10%" align=middle>充值IP</TD>
				<TD width="10%" align=middle>订单号</TD>
				<TD width="10%" align=middle>支付日期</TD>
				<TD width="5%" align=middle>金额(元)</TD>
				<TD width="5%" align=middle>游戏币</TD>
				<TD width="10%" align=middle>充值游戏</TD>
				<TD width="5%" align=middle>充值游戏区服</TD>
				<TD width="5%" align=middle>订单状态</TD>
				<TD width="5%" align=middle>元宝发放</TD>
				<TD width="10%" align=middle>充值方式</TD>
				<TD width="10%" align=middle>手机号码</TD>
			  </TR>
         <?php
                $sql="SELECT * FROM ".PAYDB.".".PAYORDER.$filter." AND game !=0 AND server !=0";
			$data = $db ->find($sql);
			foreach ( $data as $val ) {
			         $val['user_ip'] = long2ip($val['user_ip']);
			         $ifErr=$QQWry->QQWry($val['user_ip']);
			         $ipaddr[$val['user_ip']]=$QQWry->Country;
			         $area=$ipaddr[$val['user_ip']];
					 $game_table = "pay_".$game_arr[$val['game']]['game_byname']."_log";
					 if($val['game']==0){
						$game_table = "pay_platform";
						$game_arr[$val['game']]['name']= "91yxq";
						$val['server']="平台币";
                                                $sql="SELECT succ FROM ".PAYDB.".{$game_table} {$filter_game} AND orderId='".$val['orderid']."'";
					}else{
                                            $sql="SELECT stat FROM ".PAYDB.".{$game_table} {$filter_game} AND orderid='".$val['orderid']."'";
					}
                                        echo $sql;
                                        $data2 = $db ->get($sql); 
					 if ( $val['succ']==1 ) {
                                                $total_pay +=	$val['money'];
					 }
					 
		 ?>
             <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
    		 <TD align=middle><?=$val['user']?></TD>
             <TD align=middle><?=$val['user_ip']?><br><?=iconv("gb2312","utf-8",$area)?></TD>
			 <TD align=middle><?=$val['orderid']?></TD>
			 <TD align=middle><?=date("Y-m-d H:i:s",$val['pay_date'])?></TD>
			 <TD align=middle><?=$val['money']?></TD>
			 <TD align=middle><?=$val['pay_gold']?></TD>
             <TD align=middle><?php if ($game_arr[$val['game']]['name']) echo $game_arr[$val['game']]['name'];else echo '游戏ID：'.$val['game'];?></TD>
             <TD align=middle>
			 <?php 
				if($val['server']>1000){
					echo '合'.($val['server']-1000);
				}else{
					echo $val['server'];
				}
				if($val['server']!="平台币"){
					echo "服";
				}
				?> </TD>
             <TD align=middle><a href="yb_pay_list.php?act=serach&orderid=<?=$val['orderid']?>"><?php if ( $val['succ']==1 ) echo '<font color=#007700>支付成功</font>';else echo '<font color=#AAAAAA>尚未支付</font>';?></a></TD>
	         <TD align=middle>
			<?php 
			if($val['game']==0){
                            if ($data2['succ']==1) echo '<font color=#007700>已发放</font>';
                            else echo '<font color=#FF0000>未发</font>';
			}else{
                            if ($data2['stat']==1) echo '<font color=#007700>已发放</font>';
                            else echo '<font color=#FF0000>未发</font>';
                            }
			?>
				</TD>
			 <TD align=middle>
			 <?php if($val['pay_channel']!=100){
				 echo $pay_way_arr[$val['pay_channel']]['payname'];
				 }else{
				 echo '平台币支付';
			 }?>
			 </TD>
			 <TD align=middle><?php echo $val['phone']?></TD>
             </TR>
		  <?php } ?>
		  </TBODY></TABLE>
	
<?php } ?>
    <DIV align=left>该玩家合计支付<?=$total_pay?>元 
    </DIV>	
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>