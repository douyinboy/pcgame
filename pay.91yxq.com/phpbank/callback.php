<?
	ini_set('date.timezone','Asia/Shanghai');
	echo md5('admin'); //请确认为 21232f297a57a5a743894a0e4a801fc3
	echo '</br>';
	$keyvalue = "a051d608b85e9aab6a899fb2f0b9a663";//;用户中心获取
	$returncode = $_GET["returncode"];

	$userid = $_GET["userid"]; //order.UserId.ToString();
	$orderid = $_GET["orderid"];//order.UserOrderNo;
	$money = $_GET["money"];//order.OrderMoney.ToString();

	$sign = $_GET["sign"];
	  $sign2 = $_GET["sign2"];
	if(!isset($sign2) && empty($sign2))
	{
		echo 'param error';
		exit;
	}
	$ext = $_GET["ext"];//order.Ext;

	$localsign = format("returncode={0}&userid={1}&orderid={2}&keyvalue={3}"
	   , $returncode
	   , $userid
	   , $orderid
	   , $keyvalue
	);

	echo $localsign;

	echo '</br>';
	$localsign="returncode=".$returncode."&userid=".$userid."&orderid=".$orderid."&keyvalue=".$keyvalue;
	echo $localsign;
	echo '</br>';
	$localsign2="money=".$money."&returncode=".$returncode."&userid=".$userid."&orderid=".$orderid."&keyvalue=".$keyvalue;

	$localsign = md5($localsign);
	$localsign2 = md5($localsign2);

	echo $sign;
	echo '</br>';
	echo $localsign;
	echo '</br>';
	if ($sign != $localsign)
	{ 
		echo 'sign error';
		exit;            //加密错误
	}
	//注意这个带金额的加密 判断 一定要加上，否则非常危险 ！！
	if ($sign2 != $localsign2)
	{ 
		echo 'sign2 error';
		exit;            //加密错误
	}
			
	switch ($returncode)
	{ 
		case "1"://成功
			//成功逻辑处理，现阶段只发送成功的单据
			echo 'ok';
			break;
		default:
			//失败
			break;
	}
			
			
	function format() {     
	 $args = func_get_args();    
	 if (count($args) == 0) { return;}     
	 if (count($args) == 1) { return $args[0]; }     
	 $str = array_shift($args);         
	 $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);    
	 return $str;
	}
?>