<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once ('include/cls.show_page.php');

if (!empty($_POST)) {
    $user_name = $_POST['user_name'];
    $server_id = $_POST['server_id'];
    $tableName = '91yxq_agent_reg_' . date('Y');
    $sql = "UPDATE 91yxq_users.".$tableName." SET server_id =".$server_id." WHERE user_name='".$user_name."'";
    $db->query($sql);
    echo  '<script language="javascript">alert("更新成功！");</script>';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>注册区服修改</TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<div style="margin: 100px auto 0; width: 600px; height: 300px;">
    <form method="post" action="" target="_self">
        用户名：<input type="text" name="user_name" value="<?=$_POST['user_name'] ?>">
        最终区服：<input type="text" name="server_id" value="<?=$_POST['server_id'] ?>">
        <input style="width: 100px; height: 32px; font-size: 16px; cursor: pointer;" type="submit" value="确认修改">
    </form>
</div>
</BODY></HTML>
