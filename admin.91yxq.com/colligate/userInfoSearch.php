<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once ('include/cls.show_page.php');

$arr = array();
if (!empty($_POST)) {
    $uid = $_POST['uid'];
    $tableName = '91yxq_agent_reg_' . date('Y');
    $sql="SELECT u.uid, u.user_name, u.agent_id, u.place_id, a.game_id, a.server_id, a.reg_time FROM 91yxq_users.users u LEFT JOIN 91yxq_users.".$tableName." a ON u.user_name=a.user_name WHERE uid = " . $uid;
    $arr= $db->get($sql);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>用户信息查询</TITLE>
    <META content="text/html; charset=utf-8" http-equiv=Content-Type>
</HEAD>
<BODY>
<div style="margin: 100px auto 0; width: 500px; height: 300px;">
    <form method="post" action="" target="_self">
        用户ID：<input type="text" name="uid" value="<?=$_POST['uid'] ?>">
        <input style="width: 50px; height: 32px; font-size: 16px; cursor: pointer;" type="submit" value="查询">

        <?php if (!empty($arr)): ?>
            <p style="margin: 20px 0;">
                ID：<?=$arr['uid'] ?><br>
                用户名：<b style="font-size: 24px;"><?=$arr['user_name'] ?></b><br>
                推广渠道：<?=$arr['agent_id'] ?><br>
                推广者：<?=$arr['place_id'] ?><br>
                注册游戏：<?=$arr['game_id'] ?><br>
                注册区服：<?=$arr['server_id'] ?><br>
                注册时间：<?=date('Y-m-d H:i:s', $arr['reg_time']) ?>
            </p>
        <?php endif; ?>

    </form>
</div>
</BODY></HTML>
