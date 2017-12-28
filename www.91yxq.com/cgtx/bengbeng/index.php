<?php
/**
 * @注册接口  http://www.91yxq.com/cgtx/bengbeng/index.php?annalID=67235354&adid=16082
 */
	if (empty($_GET['annalID']) || empty($_GET['adid'])) {
		exit('所有参数均不能为空!');
	}
    $pcid = $_GET['annalID'];
    $adid = $_GET['adid'];

	$url = "http://api.91yxq.com/api/get_max_server.php?gid=19";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $result = curl_exec($ch);
    curl_close($ch);
    unset($ch);

    $serverId = $result;

    switch ($adid) {
        case 15489:
            $serverId = $serverId > 3 ? 0 : $serverId;
            break;
        case 15703:
            $serverId = $serverId > 9 ? 0 : $serverId;
            break;
        case 15914:
            $serverId = $serverId > 18 ? 0 : $serverId;
            break;
        case 16082:
            $serverId = $serverId > 24 ? 0 : $serverId;
            break;
        default:
            $adid = 0;
    }

if ($adid == 0) {
    exit('adid参数错误!');
}

if ($serverId == 0) {
	exit('活动已过期!');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>操戈天下</title>
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
                    <form action="http://www.91yxq.com/main.php?act=reg_bengbeng4" method="post">
                        <input type="hidden" id="other_act" name="action" value="1" />
                        <input type="hidden" name="game_id" value="19" />
                        <input type="hidden" name="server_id" value="<?php echo $serverId;?>" />
                        <input type="hidden" name="agent_id" value="10014" />
                        <input type="hidden" name="placeid" value="10070" />
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