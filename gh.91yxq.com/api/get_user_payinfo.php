<?php
require_once('../common/common.php');
$game = trim($_GET['game_id']);
$server   = trim($_GET['server_id']);
$user_name = trim($_GET['user_name']);
$stime = trim($_GET['stime']);
$etime = trim($_GET['etime']);
    $sql=" select user_role,sum(paid_amount) as money from db_5399_pay.pay_list where game_id=".$game." and server_id=".$server.
            " and user_name='".$user_name."' and pay_date >='".$stime."' and pay_date <='".$etime."'";
    $result=mysql_query($sql);
    $data=array();
    while ($row = mysql_fetch_assoc($result)){
        if(empty($row['user_role'])){
            $row['user_role']='未获取到';
        }elseif(empty($row['money'])){
            $row['money']=0;
        }
        $data=$row;
    }
    echo json_encode($data);
?>