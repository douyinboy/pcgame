<?php
$user = $mysqli->escape_string(strip_tags(trim($_REQUEST['user'])));
$pwForPt = $mysqli->escape_string(strip_tags(trim($_REQUEST['pwForPt'])));
$paid_amount = trim($_REQUEST['paid_amount']);
$paid_amount += 0;
if($paid_amount==0){
    exit("money error");
}
$platformB = $paid_amount * 100;
$user_table=usertab($user);
$sql="select userPayPw,money_plat from {$user_table} where user_name='{$user}'";
$arr=$mysqli->query($sql)->fetch_assoc();
if($arr['userPayPw'] != $pwForPt || $arr['money_plat'] < $platformB){
    exit("pw or ye error");
}else{
    $sql_pay="update `$user_table` set `money_plat`=`money_plat`-{$platformB} WHERE `user_name`='$user'";
    if($mysqli->query($sql_pay)){
            exit("ok");
    }else{
            exit("other error");
    }
}
