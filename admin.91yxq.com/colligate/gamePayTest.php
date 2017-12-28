<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once('include/ip.php');
$game_id = $_REQUEST['game_id'];
$server_id = $_REQUEST['server_id'];
$user_name = trim($_REQUEST['user_name']);
$orderid = $_REQUEST['orderid'];
$b_num = trim($_REQUEST['b_num']);
$money = trim($_REQUEST['money']);
$filter_2=" WHERE 1 ";
if ( $game_id>0 ) {
    $filter_2 .= " AND game_id=$game_id";
    $sql="SELECT * FROM ".PAYDB.".".SERVERLIST.$filter_2." order by server_id desc ";
    $gs_list_arr = $db ->find($sql);
    foreach ( $gs_list_arr as $val) {
       $servers_arr[$val['server_id']] = $val['name'];
    }
}
$sql="SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_list_arr = $db ->find($sql);
$game_arr = array();
foreach ( $game_list_arr as $val) {
   $game_arr[$val['id']] = $val['name'];
   $game_byname[$val['id']]=$val['game_byname'];
}

if ( $_POST['act'] =='pay' ){
    $pay_type = $_POST['pay_type'];
    $remark = $_POST['remark'];
    $name_list = array('admin');
    if ( $b_num>100 || $money>10) {
        if ( !( in_array($_SESSION['uName'],$name_list) && $b_num<=100)) { 
          echo "<script>alert('您补发的元宝数量不能大于100，请联系技术部！');history.back();</script>";die;
        }
    }
    if ($user_name=='' || $b_num=='' || $remark=='') {
        echo "<script>alert('充值帐号，游戏币数量，充值说明不能为空！');history.back();</script>";die;
    }
    
    $time = time();
    $pay_ip = GetIP();
    $Key_HD = KEY_HDPAY;
    $flag = md5($time.$Key_HD.$user_name.$game_id.$server_id.$pay_ip);
    $post_str = "admin_username=".$_SESSION['uName']."&user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&pay_type=".$pay_type."&flag=".$flag."&pay_ip=".$pay_ip."&remark=".$remark;

    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_URL, PAY_URL);
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
    curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
    curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
    curl_setopt( $ch, CURLOPT_VERBOSE, true); 
    ob_start( );
    curl_exec( $ch );
    $contents = ob_get_contents( );
    ob_end_clean();
    curl_close( $ch );
    if ($contents=="1") {
            $log_msg=$_SESSION["uName"]."为{$user_name}在".$game_arr[$game_id]."的".$server_id."服充值{$b_num}游戏币成功|".$remark;
            $showtip = "<script>alert('充值成功');document.location.href='yb_reissue.php';</script>";
        } else if ($contents=="5"){
            $log_msg=$_SESSION["uName"]."为{$user_name}在".$game_arr[$game_id]."的".$server_id."服充值{$b_num}游戏币失败，此订单事情已经补过单，不可对同一订单多次补发|".$remark;
            $showtip = "<script>alert('此订单号已经补过单，不可对同一订单多次补发');history.back();</script>";
        } else if ($contents=="0") {
            $log_msg=$_SESSION["uName"]."为{$user_name}在".$game_arr[$game_id]."的".$server_id."服充值{$b_num}游戏币失败|".$remark;
                 $showtip = "<script>alert('充值失败');history.back();</script>";
        } else if ($contents=='6') {
            $log_msg=$_SESSION["uName"]."为{$user_name}在".$game_arr[$game_id]."的".$server_id."服充值{$b_num}游戏币失败|".$remark;
            $showtip = "<script>alert('充值失败，由于订单号不存在');history.back();</script>";
        }
        $sql="insert into ".YYDB.".".OPERATELOG." (user_name,ip,op_date,op_content,pay_type,url) values('".$_SESSION['uName']."','".$pay_ip."',now(),'".$log_msg."','$pay_type','"."http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."')";
        $db ->query($sql);
        echo $showtip ; exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>游戏充值接口测试</TITLE>
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
          <TD width="604" vAlign=top><font color='red'>仅供游戏充值测试</font>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
              <form action="" name="myform" id="myform" method="post" target="_self">
                <INPUT value="pay" type="hidden" name="act"> 
                <TBODY>
                <TR class=trEven>
                    <TD width="109">游    戏：</TD>
                  <TD width="473">
                    <SELECT name="game_id" id="game_id" onChange="document.location.href='gamePayTest.php?game_id='+this.value+'&user_name='+$('#user_name').val()+'&orderid='+$('#orderid').val()+'&b_num='+$('#b_num').val()">
                     <option value="0">请选择游戏</option>
                      <?php foreach( $game_list_arr as $val ) {?>
                            <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                      <?php } ?>	
                      </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
                    </TD></TR>
                  <TR class=trEven>
                    <TD>服 务 器：</TD>
                    <TD><SELECT name="server_id" id="server_id">
                    <?php foreach( $gs_list_arr as $val ) {
                        $td=date('Y-m-d').' 00:00:00';
                    ?>
                    <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
                    <?php }?>	
                    </SELECT>
                    </TD>
                </TR>
                <TR class=trEven>
                    <TD>玩家帐号：</TD>
                    <TD><INPUT name="user_name" id="user_name" value="<?=$user_name?>"  ></TD>
                </TR>
                <TR class=trEven>
                    <TD>测试金额：</TD>
                    <TD><INPUT name="money" id="money" value="<?=$money?>" ></TD>
                </TR>
                <TR class=trEven>
                    <TD>游戏币数量：</TD>
                    <TD><INPUT name="b_num" id="b_num" value="<?=$b_num?>" ></TD>
                </TR>  
                 <TR class=trEven>
                    <TD>补发原因：</TD>
                    <TD>
                        <select name="pay_type" id="pay_type" style="width: 150px;">
                            <option value="100">游戏测试</option>
                        </select>
                    </TD>
                </TR>
                <TR class=trEven>
                    <TD>充值说明：</TD>
                    <TD>
                    <textarea id="remark" class="box" rows="5" name="remark"></textarea>
                    </TD>
                </TR>  
                  <TR class=trEven>
                    <TD>&nbsp;</TD>
                  <TD><INPUT value="来一发" type="submit" name="login"></TD>
                </TR>
                  
            </TBODY>
              </form>
            </TABLE>
</TABLE></TD></TR></TBODY></TABLE>
<SCRIPT>
var pro_str=<?=json_encode($game_arr)?>;
var pro_str_byname=<?=json_encode($game_byname)?>;
search_pro();
</SCRIPT>
</BODY></HTML>
