<?php
require_once('../common/common.php');
include('include/isLogin.php');
$game_id = $_REQUEST['game_id'];
$server_id = $_REQUEST['server_id'];
$filter_2 = " WHERE 1 ";
if ( $game_id>0 ) {
    $filter_2 .= " AND game_id=$game_id";
    $sql="SELECT * FROM ".PAYDB.".".SERVERLIST." $filter_2  order by server_id desc";
    $gs_list_arr = $db ->find($sql);
    foreach ( $gs_list_arr as $val) {
       $servers_arr[$val['server_id']] = $val['name'];
    }
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$game_list_arr = $db ->find($sql);
$game_arr = array();
foreach ( $game_list_arr as $val) {
   $game_arr[$val['id']] = $val['name'];
}
if ( $_POST['act'] =='pay' ) {
	$user_name = trim($_REQUEST['user_name']);
	$orderid = trim($_REQUEST['orderid']);
	$b_num = trim($_REQUEST['b_num']);
	$money = trim($_REQUEST['money']);
	$pay_type = $_POST['pay_type'];
	$remark = $_POST['remark'];
	if ( $b_num>50000 ) {
            echo "<script>alert('您补发的元宝数量过大，请联系技术部！');history.back();</script>";die;
	}
	if ($user_name=='' || $b_num=='' || $remark=='' || !$game_id || !$server_id) {
            echo "<script>alert('充值帐号，游戏币数量，充值说明，游戏，服务器不能为空！');history.back();</script>";die;
	}
	if ($pay_type==101 || $pay_type==100){
            $bank_date = $_REQUEST['bank_date'];
            $bank_name = $_REQUEST['bank_name'];
            if(!$bank_date || !$bank_name) {
                echo "<script>alert('人工充值的充值时间和充值银行不能为空！');history.back();</script>";die;
            }
	} else if ($orderid=='') {
            echo "<script>alert('订单号不能为空！');history.back();</script>";die;
	}
	$sql="insert into ".YYDB.".".KFAPPLYYB." (username,platform_id,orderid,money,gold,pay_date,pay_bank,game_id,server_id,pay_type,pay_memo,addautor,addtime,state) values('$user_name',1,'$orderid','$money','$b_num','$bank_date','$bank_name','$game_id','$server_id','$pay_type','$remark','".$_SESSION['uName']."',now(),4)";
	if($db->query($sql)){
            echo "<script>alert('元宝补发申请提交成功！');history.back();</script>";
	} else {
            echo "<script>alert('元宝补发申请提交失败！');history.back();</script>";
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>申请补发元宝</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?>
</HEAD>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=619>
  <TBODY>
  <TR>
    <TD width="611" vAlign=top>
      <TABLE width="612" border=0 cellPadding=3 cellSpacing=1 class=table_list_auto>
        <TBODY>
        <TR>
          <TD width="604" vAlign=top><font color='red'>请先查询用户的游戏币充值记录，确认该到帐的没有到再使用本功能直接给用户充游戏币</font>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
              <form action="" name="myform" id="myform" method="post" target="_self">
                <INPUT value="pay" type="hidden" name="act">
                <TBODY>
                <TR class=trEven>
                    <TD width="109">游    戏：</TD>
                  <TD width="473">
                    <SELECT name="game_id" id="game_id" onChange="document.location.href='KFapplyGold.php?game_id='+this.value+'&user_name='+$('#user_name').val()+'&orderid='+$('#orderid').val()+'&b_num='+$('#b_num').val()">
                     <option value="0">请选择游戏</option>
                      <?php foreach( $game_list_arr as $val ) { ?>
                      <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                      <?php } ?>
                      </SELECT>
                    </TD></TR>
                  <TR class=trEven>
                    <TD>服 务 器：</TD>
                    <TD><SELECT name="server_id" id="server_id">
                    <?php
                    if(empty($gs_list_arr))
                    echo "<OPTION value='0'>请选择区服</OPTION>";
                    else
                    foreach( $gs_list_arr as $val ) {
                        $td=date('Y-m-d').' 00:00:00';
                        if($val['create_date']<$td && $val['is_open']==0 ){ continue; }
                    ?>
                    <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                    <?php } ?>
                    </SELECT>
                    </TD>
                </TR>
				<TR class=trEven>
                    <TD>玩家帐号：</TD>
                  <TD><INPUT name="user_name" id="user_name"  ></TD></TR>
				  <TR class=trEven>
                    <TD>订单号：</TD>
                  <TD><INPUT name="orderid" id="orderid" >
<font color='red'>（补单时请务必填写正确的订单号）</font></TD>
				  </TR>
				  <TR class=trEven>
                    <TD>订单金额：</TD>
                  <TD><INPUT name="money" id="money" >
<font color='red'>（补单时请务必填写正确的订单金额）</font></TD>
				  </TR>
				<TR class=trEven>
                    <TD>游戏币数量：</TD>
                  <TD><INPUT name="b_num" id="b_num" ></TD></TR>
                  <TR class=trEven>
                    <TD>银行到帐时间：</TD>
                  <TD><INPUT name="bank_date" id="bank_date" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})")>
                  <font color='red'>（*人工充值选填项：填写正确的银行到帐时间）</font></TD></TR>
                  <TR class=trEven>
                    <TD>充值银行：</TD>
                    <TD>
					<select name="bank_name" id="bank_name" style="width: 150px;">
		  <option value="支付宝">支付宝</option>
          <option value="微信">微信</option>
        </select>
					<font color='red'>（*人工充值选填项：请选择玩家所用充值银行）</font>                    </TD>
                </TR>
                 <TR class=trEven>
                    <TD>补发原因：</TD>
                    <TD>
					<select name="pay_type" id="pay_type" style="width: 150px;">
          <option value="100">测试充值</option>
          <option value="101">人工充值</option>
          <option value="102">帐号充错补发</option>
          <option value="103">帐号充错游戏补发</option>
          <option value="104">帐号充错服务器补发</option>
          <option value="105">充值成功元宝未发</option>
		  <option value="106">充值成功,但是元宝发放查询没记录</option>
		  <option value="107">充值成功,帐号游戏服全都出错,元宝发放查询没记录！！！</option>
        </select>
					<font color='red'>（认真选择的对应补发原因）</font>                    </TD>
                </TR>
                <TR class=trEven>
                    <TD>充值说明：</TD>
                    <TD>
                    <textarea id="remark" class="box" rows="5" name="remark"></textarea>
                    </TD>
                </TR>
                  <TR class=trEven>
                    <TD>&nbsp;</TD>
                  <TD><INPUT value="申请补发" type="submit" name="login"></TD>
                </TR>

                  </TBODY></form></TABLE>
</TABLE></TD></TR></TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</BODY></HTML>
