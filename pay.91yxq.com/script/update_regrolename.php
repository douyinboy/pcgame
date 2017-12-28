<?php
/*后台轮询进程，每隔1分钟更新获取新注册用户的角色*/
ini_set("display_errors", "On");
error_reporting(0);
//include_once(dirname(__DIR__) . "/include/dbconn_4.php");
include_once(dirname(__DIR__) . "/include/config.inc.php");
include_once(dirname(__DIR__) . "/include/user.game_api.php");
$stime =  time()-600;
$tb = "91yxq_users.91yxq_agent_reg_".date("Y");
$sql="select * from ".$tb." where reg_time >".$stime." AND user_role is NULL";
//echo $sql;
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    if($row ->game_id > 0 && $row ->server_id >0){
        $ug = new GameUser();
        $rolename = $ug->getRoleName($row ->game_id, $row ->server_id, $row ->user_name);
        if($rolename){
            $sql ="update ".$tb." SET user_role ='".$rolename."' WHERE id =".$row ->id;
            mysql_query($sql);
        }
    }
}