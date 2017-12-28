<?php
//ini_set('display_errors', true);
require_once('../common/common.php');
include('include/isLogin.php');
include dirname(__DIR__) . '/configs/pay_way.inc.php';
$act = $_REQUEST['act'];
$pay_date=trim($_REQUEST["pay_date"]);
$pay_date2 = trim($_REQUEST['pay_date2']);
if (!$pay_date) {
     $pay_date2 = $pay_date = date("Y-m-d");
}
if ( $act =='bf' ) {
     $user_name = $_REQUEST['user_name'];
     $orderid = $_REQUEST['orderid'];
	 $game_id = $_REQUEST['game_id'];
	 $server_id = $_REQUEST['server_id'];
	 $pay_list = $db->get("SELECT succ FROM " . PAYDB . "." . PAYORDER . " where orderid='".$orderid."' and game !=0 and server !=0 ");
	 if ( $pay_list['succ']==1 ) {
	      $game_info =  $db -> get("SELECT back_result,game_byname FROM " . PAYDB . ".`game_list` WHERE id={$game_id}");
		  $game_byname = trim($game_info['game_byname']);
		  $back_result = trim($game_info['back_result']);
		  $game_tab_name = "pay_".$game_byname."_log";
		  $pay_info = $db -> get("SELECT back_result,money,pay_gold FROM " . PAYDB . ".$game_tab_name WHERE orderid='".$orderid."'");
		  if ( trim($pay_info['back_result']) == $back_result ) {
		      echo "<script>alert('该订单早已补发成功了，有疑问请到游戏后台查询。');document.location.href='checkPayGameFailureOrder.php';</script>";exit;
		  } else { //为玩家发放元宝
		    $time = time();
			$pay_ip = GetIP();
			$remark = $_SESSION['uName']."为玩家自动补，后台自动扫描方式。";
			$Key_HD = '5apasywuE(73)s$%&KBJzCc:5qLM0928h';
			$flag = md5($time.$Key_HD.$user_name.$game_id.$server_id.$pay_ip);
			$b_num = $pay_info['pay_gold'];
			$money = $pay_info['money'];
			$post_str = "admin_username=".$_SESSION['uName']."&user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&pay_type=105&flag=".$flag."&pay_ip=".$pay_ip."&remark=".$remark."&orderid=".$orderid;
			$ch = curl_init( );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_URL, "http://pay.91yxq.com/api/sync_myhaodong.php" );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
			curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
			curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
			$contents = curl_exec( $ch );
                        //$contents = ob_get_contents( );
                        //ob_end_clean();
                        curl_close( $ch );
                        unset($ch);

			if ($contents==1) {
			     echo "<script>alert('充值成功，请通知玩家注意查收。');document.location.href='checkPayGameFailureOrder.php';</script>";exit;
			} else {
			     echo "<script>alert('充值失败!');document.location.href='checkPayGameFailureOrder.php';</script>";exit;
			}
		}
	 } else {
	      echo "<script>alert('支付不成功，请跟支付渠道确认。补发失败');document.location.href='checkPayGameFailureOrder.php';</script>";exit;
	 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>充元宝失败订单扫描</title>
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
                <DIV class=divOperation style="float: left;margin-left: 130px;">
                  <FORM id="myform" method="post" name="myform" action="">
                     起始日期
                    <input name="pay_date" type="text" class="box" id="pay_date"  onClick="WdatePicker();" value="<?=$pay_date?>"  size="10" />
                    &nbsp;&nbsp;结束日期
                    <input name="pay_date2" type="text" class="box" id="pay_date2"  onClick="WdatePicker();" value="<?=$pay_date2?>"  size="10" />
                    &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();">
                  </FORM>
                </DIV>
            </TD>
        </TR>
    </TBODY>
  </TABLE>
<table width="99%" border="0" class="table_list" id="tb">
<TR class=table_list_head>
    <TD width="5%" align=middle>充值帐号</TD>
  <TD width="5%" align=middle>充值方式</TD>
    <TD width="5%" align=middle>充值订单</TD>
  <TD width="6%" align=middle>充值游戏</TD>
  <TD width="8%" align=middle>充值所在服</TD>
    <TD width="7%" align=middle>充值金额</TD>
    <TD width="10%" align=middle>所得游戏币</TD>
  <TD width="10%" align=middle>充值时间</TD>
  <TD width="9%" align=middle>充值IP</TD>
    <TD width="10%" align=middle>充值状态</TD>
    <TD width="16%" align=middle>游戏币发放状态</TD>
  <TD width="9%" align=middle>操作管理</TD>
  </TR>






<?php
  if ($pay_date ) {

    $game_list_arr = $db->find("SELECT id,name,game_byname FROM `" . PAYDB . "`.`game_list`");
    $game_arr = array();
    foreach ($game_list_arr as $val) {
        $game_arr[$val['id']]['name'] = $val['name'];
            $game_arr[$val['id']]['game_byname'] = $val['game_byname'];
    }
    $pay_date2 =='' && $pay_date2 =date("Y-m-d");
    $starttime = strtotime($pay_date." 00:00:00");
    $endtime = strtotime($pay_date2." 23:59:59");
    $pay_orders = $db->find("SELECT * FROM `" . PAYDB . "`.`pay_orders` WHERE succ=1 and game !=0 and server !=0 and sync_date >".$starttime ." AND sync_date <=".$endtime);
    $i=0;
    foreach($pay_orders as $val2){

    $tb = "pay_".$game_arr[$val2['game']]['game_byname']."_log";
    $res = $db->get("SELECT stat FROM `" . PAYDB . "`.`".$tb."` WHERE orderid='".$val2['orderid']."'");
    if ( $res['stat']!=1) {
    ?>
      <TR id=newooo class="<? if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
      <TD align=middle><?=$val2['user']?></TD>
      <TD align=middle>
      <?php
      echo $pay_way_arr[$val2['pay_channel']]['payname'] ?: '';
      ?>
      </TD>
      <TD align=middle><?=$val2['orderid']?></TD>
      <TD align=middle>
      <?php
      if($val2['game']!=0){
      echo $game_arr[$val2['game']]['name'];
      }else{
        echo "91yxq";
      }
      ?>
      </TD>
      <TD align=middle>
      <?php
      echo $val2['server'];
      ?>
      </TD>
      <TD align=middle><?=$val2['money']?></TD>
      <TD align=middle><?=$val2['pay_gold']?></TD>
      <TD align=middle><?=date("Y-m-d H:i:s", $val2['sync_date'])?></TD>
      <TD align=middle><?=long2ip($val2['user_ip'])?></TD>
      <TD align=middle><?php if ( $val2['succ']==1 ) echo '<font color="#00FF33">成功</font>'; else echo '<font color="#FF0000">失败</font>';?></TD>
      <TD align=middle>失败</TD>
      <TD align=middle><a href="?act=bf&user_name=<?=$val2['user']?>&orderid=<?=$val2['orderid']?>&game_id=<?=$val2['game']?>&server_id=<?=$val2['server']?>" onClick="return confirm('确认为玩家补发游戏币?一定成功有问题就要联系开发处理！！！')"><strong>补发</strong></a></TD>
      </TR>
        <?php
        }
    }
} //pay_date
      ?>

</TBODY>
</table>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>
