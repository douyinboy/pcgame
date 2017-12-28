<?php
/*每月定时执行更新充值平台月数据*/
ini_set("display_errors", "On");
error_reporting(0);
set_time_limit(3600);
include_once(dirname(__DIR__) . "/include/config.inc.php");

//获取游戏列表
$sql="select * from game_list WHERE is_open=1";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)){  
    //获取公会列表
    $sql ="SELECT * FROM 91yxq_admin.agent WHERE state=1";
    $res2x=mysql_query($sql);
    while ($row2=mysql_fetch_object($res2x)){
        $sql ="select * from month_guild_data WHERE `game_id` =".$row ->id."
AND `ym` =201410   AND  agent_id =".$row2 ->id; 
        $res3x=mysql_query($sql);
        $ii = 0;
        while($row3 =mysql_fetch_object($res3x)){
            if( $ii >0 ){
                $sql ="delete from month_guild_data where id=".$row3 ->id;
                mysql_query($sql);
            }else{
                $ii++;
            }
        }
    }
}
mysql_close();

?>