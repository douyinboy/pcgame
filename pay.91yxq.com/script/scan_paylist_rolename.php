<?php
/*每隔30分钟更新最近1个小时充值玩家的角色名*/
ini_set("display_errors", "On");
error_reporting(0);
//include_once("/www/pay.91yxq.com/include/dbconn_4.php");
include_once(dirname(__DIR__) . "/include/config.inc.php");
include_once(dirname(__DIR__) . "/include/user.game_api.php");
$stime =  time()-3600;
$sql="select * from pay_list where sync_date >'".date("Y-m-d H:i:s", $stime)."' AND (user_role is NULL or user_role ='')";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    if($row ->game_id > 0 && $row ->server_id >0 && $row ->user_role ==''){
        $ug = new GameUser();
        $rolename = $ug->getRoleName($row ->game_id, $row ->server_id, $row ->user_name);
        if($rolename && trim($rolename) !=''){
            $sql ="update pay_list SET user_role ='".$rolename."' WHERE id =".$row ->id;
            mysql_query($sql);
        }
    }
}
?>
