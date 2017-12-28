<?php
/**
 * @注册接口  http://www.91yxq.com/cycs2/jiquwang/index.php?ji7_uid=272952&ji7_adid=1004034&sign=155455dcdd&time=1554965
 */

if (empty($_GET['ji7_uid']) || empty($_GET['ji7_adid']) || empty($_GET['sign']) || empty($_GET['time'])) {
    exit('所有参数均不能为空!');
}
$pcid = $_GET['ji7_uid'];
$adid = $_GET['ji7_adid'];
$sign = $_GET['sign'];
$time = $_GET['time'];
$key = 'd29c1fe77841a8a2b5bf7dbd607a24e0';

if ($sign !== md5($pcid . $adid . $key . $time)) {
	exit('签名错误!');
}

$url = "http://api.91yxq.com/api/get_max_server.php?gid=21";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$result = curl_exec($ch);
curl_close($ch);
unset($ch);

$serverId = $result;
exit('活动已过期!');
switch ($adid) {
    case 1004065:
        $serverId = $serverId > 14 ? 0 : $serverId;
        break;
    case 1004198:
        $serverId = $serverId > 28 ? 0 : $serverId;
        break;
}
	
if ($serverId == 0) {
	exit('活动已过期!');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>赤月传说2</title>
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
                    <form action="http://www.91yxq.com/main.php?act=reg_jiquwang" method="post">
                        <input type="hidden" id="other_act" name="action" value="1" />
                        <input type="hidden" name="game_id" value="21" />
                        <input type="hidden" name="server_id" value="<?php echo $serverId;?>" />
                        <input type="hidden" name="agent_id" value="10029" />
						<input type="hidden" name="placeid" value="10096" />
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