<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once ('include/cls.show_page.php');

if (!empty($_POST)) {
    $varValue = $_POST['rechargeType'];
    $sql = "UPDATE 91yxq_publish.91yxq_sys SET varValue = " . $varValue . " WHERE id = 60";
    $db->query($sql);
    echo  '<script language="javascript">alert("服务器更新成功！");</script>';
} else {
    $sql="SELECT varValue FROM 91yxq_publish.91yxq_sys WHERE id = 60";
    $arr= $db->get($sql);
    $varValue = $arr['varValue'];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>切换支付模式</TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<div style="margin: 100px auto 0; width: 500px; height: 300px;">
    <form method="post" action="" target="_self">
        <select name="rechargeType" id="" style="width: 200px; height: 32px; font-size: 16px; margin-right: 60px;">
            <option value="0" <?php if (!$varValue): echo 'selected'; endif;?> style="font-size: 16px;">直立行走充值系统</option>
            <option value="1" <?php if ($varValue): echo 'selected'; endif;?> style="font-size: 16px;">畅付云充值系统</option>
        </select>
        <input style="width: 50px; height: 32px; font-size: 16px; cursor: pointer;" type="submit" value="确认">
    </form>
</div>
</BODY></HTML>
