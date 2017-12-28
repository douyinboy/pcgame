<?php
/**
 * @注册接口  http://www.91yxq.com/cgtx/tiantianzuan/index.php?regid=91342050&project_id=13269&ttzcode=sdjhfjsd
 * @绑定查询  http://api.ttz.com/?api_action=Game.Api.GetRegisterInfo&ProjectId=12869&RegId=64725644
 */
    if (empty($_GET['regid']) || empty($_GET['project_id']) || empty($_GET['ttzcode'])) {
        exit('所有参数均不能为空!');
    }
    $pcid = $_GET['regid'];
    $adid = $_GET['project_id'];
    $sign = $_GET['ttzcode'];
    $key  = '23ddd1bf994b43cf98c5031c201ac517';

    if ($sign !== md5($adid . $pcid . $key)) {
        exit('签名错误!');
    }
	
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
    	case 12967:
    		$serverId = $serverId > 9 ? 0 : $serverId;
    		break;
    	case 13125:
    		$serverId = $serverId > 18 ? 0 : $serverId;
    		break;
    	case 13269:
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
                    <form action="http://www.91yxq.com/main.php?act=reg_tiantianzuan" method="post">
                        <input type="hidden" id="other_act" name="action" value="1" />
                        <input type="hidden" name="game_id" value="19" />
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