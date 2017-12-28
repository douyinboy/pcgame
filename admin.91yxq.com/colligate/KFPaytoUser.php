<?php
require_once('../common/common.php');
include('include/isLogin.php');
$game_id = $_REQUEST['game_id'] + 0;
$server_id = $_REQUEST['server_id'] + 0;
$user_name = trim($_REQUEST['user_name']);
$money = $_REQUEST['money'] + 0;
$remark = trim($_REQUEST['remark']);
$game_arr = $server_arr = array();
$sql="SELECT `id`,`name` FROM ".PAYDB.".".GAMELIST." WHERE `is_open`=1 order by id desc ";
$game_query = $db->find($sql);
foreach ($game_query as $v){
    $game_arr[$v['id']] = $v;
}
$sql="SELECT `server_id`,`name` FROM ".PAYDB.".".SERVERLIST." WHERE `game_id`=$game_id"." order by server_id desc ";
$server_query = $db ->find($sql);
foreach ($server_query as $v){
    $server_arr[$v['server_id']] = $v['name'];
}
if ($_POST['act'] == 'pay') {
    if (empty($user_name) || $game_id <= 0 || $server_id <= 0 || $money <= 0 || $money>50000 || empty($remark)) {
        exit("<script>alert('输入有误，请检查！');history.back();</script>");
    }
    $sql="SELECT `uid` FROM ".USERDB.".".USERS."  WHERE `user_name`='$user_name' LIMIT 1";
    $is_user = $db->get($sql);
    if (! $is_user[0]) {
        exit("<script>alert('该用户不存在！');history.back();</script>");
    }

    $time = time();
    $pay_ip = GetIP();
    $Key_HD = '5apasywuE(73)s$%&KBJzCc:5qLM0928h';
    $flag = md5($time.$Key_HD.$user_name.$game_id.$server_id.$pay_ip);
    $post_str = "admin_username=".$_SESSION['uName']."&user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&money=".$money."&pay_type=101&flag=".$flag."&pay_ip=".$pay_ip."&remark=".$remark;
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_URL, GETUSERROLE_URL);
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
    curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
    curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
    curl_setopt( $ch, CURLOPT_VERBOSE, true);
    ob_start( );
    curl_exec( $ch );
    $result = ob_get_contents( );
    ob_end_clean();
    curl_close($ch);
    if (strlen($result) < 10) {
        exit("<script>alert(" . $result . ");history.back();</script>");
    }
    $pay_list = $db->get("SELECT orderid, pay_gold, pay_date FROM " . PAYDB . "." . PAYORDER . " where orderid='".$result."'");
    $orderid = $pay_list['orderid'];
    $gold = $pay_list['pay_gold'];
    $pay_date = $pay_list['pay_date'];
    $sql="INSERT INTO 91yxq_recharge.pay_people (`orderid`,`user_name`,`game`,`server`,`money`,`gold`,`pay_date`,`sync_date`,`remark`) VALUES ('".$orderid."','".$user_name."',".$game_id.",".$server_id.",".$money.",".$gold.",".$pay_date.",".$pay_date.",'".$remark."')";
    $stmt = $db->query($sql);
    $showtip = "<script>alert('申请成功');history.back();</script>";
    exit($showtip);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>人工充值申请</TITLE>
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
                    <TD width="604" vAlign=top><font color='red'>请先查询用户的充值转账记录，确认该用户转账后给用户充游戏币</font>
                        <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
                            <form action="" name="myform" id="myform" method="post" target="_self">
                                <INPUT value="pay" type="hidden" name="act">
                                <TBODY>
                                <TR class=trEven>
                                    <TD>玩家帐号：</TD>
                                    <TD><INPUT name="user_name" id="user_name" value="<?=$user_name?>"  ></TD></TR>
                                <TR class=trEven>
                                    <TD>充值金额：</TD>
                                    <TD><INPUT name="money" id="money" value="<?=$money?>" ></TD>
                                </TR>
                                <TR class=trEven>
                                    <TD width="109">游    戏：</TD>
                                    <TD width="473">
                                        <SELECT name="game_id" id="game_id" onChange="document.location.href='KFPaytoUser.php?game_id='+this.value+'&user_name='+$('#user_name').val()+'&money='+$('#money').val()">
                                            <?php foreach( $game_arr as $val ) {?>
                                                <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                                            <?php } unset($val); ?>
                                        </SELECT>
                                    </TD></TR>
                                <TR class=trEven>
                                    <TD>服 务 器：</TD>
                                    <TD><SELECT name="server_id" id="server_id">
                                            <?php if(empty($server_arr))
                                                echo "<option value='0'>请选择游戏</option>";
                                            else
                                                foreach ($server_arr as $key => $val) { ?>
                                                    <OPTION value="<?=$key?>" <?php if ( $key == $server_id ) { echo 'selected="selected"'; }?>><?=$val?></OPTION>
                                                <?php }?>
                                        </SELECT>
                                    </TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>备注说明：</TD>
                                    <TD>
                                        <textarea id="remark" class="box" rows="5" name="remark"></textarea>
                                    </TD>
                                </TR>
                                <TR class=trEven>
                                    <TD>&nbsp;</TD>
                                    <TD><INPUT value="来一发" type="submit" name="submit"></TD>
                                </TR>

                                </TBODY></form></TABLE>
            </TABLE></TD></TR></TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</BODY></HTML>
