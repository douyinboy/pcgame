<?php
include_once('../ban_game.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>女神联盟</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div class="register register-nvshen">
		<div class="container">
			<div class="bd">
				<div class="hd">
				<img src="images/nvshen-logo.png" alt="">
			</div>
				<div class="inner">
					<div class="btn01">
						<a href="###"><img src="images/btn-01.png" alt=""></a>
					</div>
                    <form action="http://www.91yxq.com/main.php?act=other_reg" method="post">
                        <input type="hidden" id="other_act" name="action" value="1" />
                        <input type="hidden" name="game_id" value="<?php echo $game_id;?>" />
                        <input type="hidden" name="server_id" value="<?php echo $sid;?>" />
                        <input type="hidden" name="agent_id" value="<?php echo $aid; ?>" />
                        <input type="hidden" name="placeid" value="<?php echo $pid;?>" />
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
                    <?php if ($aid == 10013): ?>
					<img src="images/qr.png" alt="">
                    <?php else: ?>
                    <img src="images/qr2.png" alt="">
                    <?php endif; ?>
                </div>
			</div>
			<div class="ft">
				<img src="images/reg-word.png" alt="">
			</div>
		</div>
	</div>
</body>
</html>