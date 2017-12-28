<?php
/**
 * http://www.91yxq.com/mhzn2/pceggs/reg.php?pcid=12300008&state=1
 */
if (empty($_GET['pcid']) || empty($_GET['state'])) {
    exit('所有参数均不能为空!');
}
$pcid = $_GET['pcid'];
$adid = $_GET['state'];

$url = "http://api.91yxq.com/api/_get_max_server_info.php?gid=22&agent_id=10010&adid=".$adid;
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

switch ($adid) {
    case 1:
        $adid = '2bbcybvMtqg%3d';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>蛮荒之怒2</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="register register02">
    <div class="container">
        <div class="bd">
            <div class="inner">
                <div class="btn01">
                    <a href="###"><img src="images/btn-01.png" alt=""></a>
                </div>
                <form action="http://www.91yxq.com/main.php?act=reg_pceggs" method="post">
                    <input type="hidden" id="other_act" name="action" value="1" />
                    <input type="hidden" name="game_id" value="22" />
                    <input type="hidden" name="server_id" value="<?php echo $serverId;?>" />
                    <input type="hidden" name="agent_id" value="10010" />
                    <input type="hidden" name="placeid" value="10045" />
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
                        <!--                            <a href="###"><img src="images/btn-02.png" alt=""></a>-->
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