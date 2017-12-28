<?php
require(__DIR__ . "/cls.game_api.php");
function pay_gameb($t,$id,$orderid="") {
    $sql="SELECT * FROM `pay_orders` where orderid='$orderid'";
    $res=mysql_query($sql);
    $row=mysql_fetch_object($res);
    $user_name =$row->user;
    $orderid =$row->orderid;
    $game_id   =$row->game;
    $server_id =$row->server;
    $money = $row->money;
    $paid_amount = $row->paid_amount;
    $pay_gold = $row->pay_gold;
    $user_ip   =  long2ip($row->user_ip);
    $pay_channel = $row->pay_channel;
    $pay_date = $row->pay_date;
    $bank_type = $row->bank_type;

    if($game_id>0){//充值到游戏币
        $sql="select game_byname from game_list where id=".$game_id;
        $res2=mysql_query($sql);
        $row2=mysql_fetch_object($res2);
        $game_byname = $row2->game_byname;
        $sql="select pay_url from game_server_list where game_id=".$game_id." and server_id=".$server_id;
        $res2=mysql_query($sql);
        $row2=mysql_fetch_object($res2);
        $pay_url=$row2->pay_url;
        $game_table = "`pay_".$game_byname."_log`";
        $game_pay_fun = "pay_".$game_byname."_b";
        $sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`pay_date`,`remark`) VALUES('$orderid','$user_name','$money','$paid_amount','$pay_gold','$pay_channel','$user_ip','$server_id',now(),'$pay_channel')";
        if (!mysql_query($sql)) {
            return false;
        }

        //查询充值用户信息
        $sql = "SELECT * FROM 91yxq_users.users WHERE user_name='" . $user_name . "'";
        $_res = mysql_query($sql);
        $_row = mysql_fetch_object($_res);
        //返利游戏集合
        $game_rabate = [2, 3, 19, 21];
        if (in_array($game_id, $game_rabate) && $_row->agent_id == 100) {
            $paid_amount *= 2;
        }

        //mocuz和站长链接来的用户任何游戏充值双倍
        if (in_array($_row->agent_id, [10020, 10021])) {
            $paid_amount *= 2;
        }

        $game_obj = new Game($user_name,$orderid,$server_id,$pay_url,$money,$paid_amount,$pay_gold,$pay_channel);
        $result=$game_obj ->$game_pay_fun();//发游戏币
        $game_obj = NULL;
        if ($result) {
            mysql_query("update $t set b_flag=2 where id='$id'");
        } else {
            mysql_query("update $t set b_flag=0 where id='$id'");
        }
    }else if($game_id==0){//充值到91yxq平台币

        $fhandle2=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/pay_to_platform.log","a");
        fwrite($fhandle2,date("Y-m-d H:i:s")."	".$_SERVER["REMOTE_ADDR"]."	".$orderid." ".$paid_amount."\r\n");
        fclose($fhandle2);

        $sql="INSERT INTO pay_platform (`orderId`,`bank_type`,`user_name`,`pay_date`,`user_ip`,`money`,`paid_amount`,`pay_gold`,`pay_channel`) VALUES('$orderid','$bank_type','$user_name','$pay_date','$user_ip','$money','$paid_amount','$pay_gold','$pay_channel')";
        if (!mysql_query($sql)) {
            return false;
        }

        $time_now=time();
        $sign=md5($time_now.'123');
        $update_url = 'http://api.91yxq.com/remote_login.php';
        $post_fields="time={$time_now}&sign={$sign}&act=update_user_platform&user_name={$user_name}&pay_gold={$pay_gold}";
        $ch = curl_init($update_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $update_result=curl_exec($ch);
        curl_close($ch);

        if ($update_result) {
            if(mysql_query("UPDATE 91yxq_recharge.pay_platform SET succ=1,sync_date=now() WHERE orderId='{$orderid}'")){
                $result = true;
            }
        }else{
            return false;
        }
    }

    return $result;
}
?>