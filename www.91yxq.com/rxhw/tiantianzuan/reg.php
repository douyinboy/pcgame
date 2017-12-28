<?php
/**
 * @注册接口  http://www.91yxq.com/rxhw/tiantianzuan/reg.php?regid=64725644&project_id=13389&ttzcode=sdjhfjsd
 * @绑定查询  http://api.ttz.com/?api_action=Game.Api.GetRegisterInfo&ProjectId=12689&RegId=64725644
 */

if (empty($_GET['regid']) || empty($_GET['project_id']) || empty($_GET['ttzcode'])) {
    exit('所有参数均不能为空!');
}
$pcid = $_GET['regid'];
$adid = $_GET['project_id'];
$sign = $_GET['ttzcode'];
$key  = '23ddd1bf994b43cf98c5031c201ac517';

//if ($sign !== md5($adid . $pcid . $key)) {
//    exit('签名错误!');
//}


$url = "http://api.91yxq.com/api/_get_max_server_info.php?gid=3&agent_id=10027&adid=".$adid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$result = curl_exec($ch);
curl_close($ch);
unset($ch);

$result = json_decode($result);
$serverId = $result->serverId;

if (!$result->end_time) {
    exit('Hello，adid is wrong!');
}

if (!$result->state) {
    exit('Hello, the number of registered is full, please come back tomorrow!');
}

if ($serverId > $result->end_server_id || time() > $result->end_time) {
    exit('Hello, the activity has expired!');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>热血虎卫</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="register">
    <div class="container">
        <div class="hd">
            <img src="images/logo.png" alt="">
        </div>
        <div class="bd">
            <div class="inner">
                <div class="btn01">
                    <a href="javascript:void(0)"><img src="images/btn-01.png" alt=""></a>
                </div>
                <form action="http://www.91yxq.com/main.php?act=reg_tiantianzuan" method="post">
                    <input type="hidden" id="other_act" name="action" value="1" />
                    <input type="hidden" name="game_id" value="3" />
                    <input type="hidden" name="server_id" value="<?php echo $serverId;?>" />
                    <input type="hidden" name="agent_id" value="10027" />
                    <input type="hidden" name="placeid" value="10092" />
                    <input type="hidden" name="pcid" value="<?php echo $pcid;?>" />
                    <input type="hidden" name="adid" value="<?php echo $adid;?>" />
                    <div class="form">
                        <ul>
                            <li>
                                <label>通行证：</label>
                                <input type="text" name="login_name">
                                <p>*4-20个字符</p>
                            </li>
                            <li>
                                <label>密　码：</label>
                                <input type="password" name="login_pwd">
                                <p>*6-18个字符</p>
                            </li>
                            <li>
                                <label>确认密码：</label>
                                <input type="password" name="repeat_pwd">
                                <p>*6-18个字符</p>
                            </li>
                        </ul>
                    </div>
                    <div class="btn02">
                        <input type="submit" style="width: 100px; background-image: url("./images/btn-02.png")" />
                        <!--						<a href="###"><img src="images/btn-02.png" alt=""></a>-->
                    </div>
                </form>
            </div>
            <div class="qr">
                <img src="images/qr.png" alt="">
            </div>
        </div>
        <div class="ft">
            <img src="images/reg-word.png" alt="">
        </div>
    </div>
</div>
</body>
</html>